<?php

	if(!defined("OXS_PROTECT"))die("Wrong start point");

	class DBLIB_DB extends MultiLib{	

		private $cfg_ServerName="host";
		private $cfg_Login="user";
		private $cfg_Password="password";
		private $cfg_BD="db";
		private $cfg_dbprefix="dbprefix";

		private $ServerName;
		private $Login;
		private $Password;
		private $BD;
		private $Connect;

		private $BID;

		private $IfConnect = 0;
		private $CfgPath;

		private $Query;

		function __construct($Path){

			parent::__construct($Path);

			if(get_magic_quotes_gpc()){
				$this-Msg("волшебные кавычки - ВКЛючены","ERROR");
			}else{
				$this->Msg("волшебные кавычки - ВЫКЛючены","MESSAGE");
			}
		}

		function Init($Param=NULL){
			if(!empty($Param["cfg_file"]))	{
				$this->CfgPath = $Param["cfg_file"];
				Oxs::G("cfg")->SetCfgFile($Param["cfg_file"]);
			}
			if($this->Connect()) {
				$this->IfConnect=true;
			}else{
				$this->IfConnect=false;
			}
			return 1;
		}

		private function Connect(){

			if(empty($this->CfgPath) ){
				$this->Msg("Не указан файл конфигурации","WARNING");
			}else{
				$Cfg=Oxs()->GetLib("cfg");
				$this->ServerName=$Cfg->Get($this->cfg_ServerName,$this->CfgPath);
				$this->Login=$Cfg->Get($this->cfg_Login,$this->CfgPath);
				$this->Password=$Cfg->Get($this->cfg_Password,$this->CfgPath);
				$this->BD=$Cfg->Get($this->cfg_BD,$this->CfgPath);
				$this->dbprefix=$Cfg->Get($this->cfg_dbprefix,$this->CfgPath);
			}

			if(empty($this->ServerName)){$this->Msg("Не указано имя сервера базы данных","ERROR"); }
			if(empty($this->Login)){$this->Msg("Не указан логин подключения к базе даных","ERROR"); }
			if(empty($this->BD)){$this->Msg("Не указана база данных","ERROR");}
			if(empty($this->dbprefix)){$this->Msg("Не указан префикс таблиц базы данных","ERROR");}

			@$this->BID = mysqli_connect($this->ServerName, $this->Login, $this->Password,$this->BD);
			@mysqli_set_charset($this->BID,'utf8');
			@mysqli_character_set_name($this->BID,'utf8');

			/* проверка соединения */
			if (mysqli_connect_errno()) {
				$this->Msg("Не удалось подключиться к базе:".mysqli_connect_error(),"ERROR");
				return 0;
			} else{
				$this->Msg("Подключен к базе данных","MESSAGE"); $this->BProtector=1;
				return 1;
			}
		}


		function Exec(...$Query){

			if(!$this->IfConnect){
				$this->Msg("Подключение не установлено не могу выполнить запрос","WARNING");
				return ;
			} 

			if(!empty($Query)){
				$this->SetQ(...$Query);
			}

			$Err=Oxs()->GetLib("logger");
			$Res=$Err->GetMessages("DB.ERROR,DB.FATAL_ERROR");
			if(!empty($Res)){
				return 0;
			}

			//	Заменяем #__ на приставку к названиям таблиц
			//////////////////////////////////////////////////
			$this->Query=str_replace ("#__",$this->dbprefix,$this->Query);
			/////////////////////////////////////////////////

			if(empty($this->Query)){
				$this->Msg("Попытка выполнить пустой запрос","WARNING");
				return 0;
			}

			$this->Msg("Выполняю запрос: ".$this->Query,"DB_QUERY");
			$this->QueryCount++;

			$result = mysqli_query($this->BID,$this->Query);
			$Er=mysqli_error($this->BID);
			if(Empty($Er)){
				@$NuberRows=mysqli_num_rows($result);
				if($NuberRows!=0){
					$i=0;
					while ($data = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
						$DataEnd[$i]=$data;
						$i++;
					}
					mysqli_free_result($result);
					$this->Query="";
					return $DataEnd;
				} else { $this->Query=""; return FALSE;}
				$this->Query="";
			} else {
				$this->Msg("Ошибка при выполнении запроса: ".$Er,"ERROR");
				$this->Query="";
				return FALSE;
			}
		}

		function AddQ(...$Query){
			return $this->Query(...$Query);
		}

		function SetQ(...$Query){
			$this->Query="";
			return $this->Query(...$Query);
		}

		private function str_replace_once($search, $replace, $text){ 
		   $pos = strpos($text, $search); 
		   return $pos!==false ? substr_replace($text, $replace, $pos, strlen($search)) : $text; 
		} 

		private function Query(...$Query){	

			$QueryString = "[ ".implode(",",$Query)." ]";

			//	Вызов с пустым занчением просто игнорируем без предупреждения
			if( count($Query)==1 AND ( empty($Query[0]) OR $Query[0]==NULL ) ){
				$this->Msg("Не передано не одного параметра для запроса","WARNING");
				return 0;
			}			

			//	Разбираем переданные данные, ищем флаги и вытаскиваем их тип
			//////////////////////////////////////////////////////
			
			for($i=0;$i<count($Query);$i++){				
				
				//echo "<br>!".$i."!";
				
				//	Рыскаем строку она будет маской
				if(Oxs::G("cheker")->String($Query[$i],true)){

					//echo "<br>проверяемый обьект".$Query[$i]." i=".$i;

					//	рыскаем флаги в строке
					if(preg_match_all("/(oxs:[a-zA-Zа-яА-Я+-]*)+/",$Query[$i],$result)){
						
						//	Ищем следующий за строкой параметр
						$i++;
						
						for($j=0;$j<count($result[0]);$j++){	

							//echo "<br>Найден флаг".$result[0][$j]." j= ".$j;
							//echo "<br>Номер элемента для флага".($i+$j);
							if(!isset($Query[$i+$j]) AND $Query[$i+$j]!==NULL ){
								$this->Msg("Не найдено значение для флага(".$result[0][$j].") в маске ".$Query[$i-1],"ERROR") ;
							}else{
								$Count=1;
								//echo "<br>Тип флага".$result[0][$j];
								//echo "<br>Значение флага".$Query[$i+$j];
								$Tmp = $this->Check($this->str_replace_once("oxs:","",$result[0][$j]),$Query[$i+$j]);
								//echo "<br>";
								//echo $result[0][$j]."-".$Query[$i+$j];
								//var_dump($Tmp);
								
								if($Tmp!==NULL){
									//echo "<br>Заменяем ".$result[0][$j]." на ".$Tmp. " в ".$Query[$i-1];
									$Query[$i-1] = $this->str_replace_once($result[0][$j], $Tmp,  $Query[$i-1]);	
									//echo "<br>После замены ".$Query[$i-1];								
								}else{
									$this->Msg("Флаг не соовтетсует типу ".str_replace("oxs:","",$result[0][$j])."(".$Query[$i+$j].") в маске ".$Query[$i-1] . $QueryString ,"ERROR");
									return 0;
								}								
							}							
						}

						//	Добавляем в запрос преобразованную маску
						$this->Query .= $Query[$i-1];
						//echo "<br>this->Query =  ".$this->Query;

						//	Увеличим i на колчиевтов найденых флагов
						//echo "<br>Увеличиваем i на ".$j;
						$i+=$j-1;		
						//echo "<br>i после увеличения =".$i;				

					}else{						
						$this->Query.=(string)$Query[$i];
					}
					
				}else{
				//	Если не нарсыкали строку просто приписываем значение к запросу
					$this->Query.=(string)$Query[$i];
				}

			}

			return 1;
			////////////////////////////////////////////////////			
		}

		private function Check($Type,$Value){

			switch($Type){
				case "sql":
					return mysqli_real_escape_string($this->BID,$Value);
				break;
				case "id":				
					if( Oxs::G("cheker")->id($Value) OR $Value=="" OR $Value==NULL){
						return $Value;
					}else{
						return NULL;
					}					
				break;
				case "int":
					if( Oxs::G("cheker")->int($Value) OR $Value=="" OR $Value==NULL ){
						return $Value;
					}else{
						return NULL;
					}					
				break;
				default: return NULL;
			}			

			return FALSE;
		}

		function GetLastID(){
			return mysqli_insert_id($this->BID);
		}

		function GetQ($mode=false){
			if(!$mode)return $this->Query;
			else{return str_replace ("#__",$this->dbprefix,$this->Query);}
		}

		function IfEmpty($Table){
		    $q = $this->Exec("SELECT * FROM `".$Table."`");
		    if (empty($q))return TRUE;
		    else return FALSE;
		}

		function Insert($Table,$Data=NULL){
			$this->SetQ("INSERT INTO ");
			$this->AddQ(" `".$Table."` ");

			print_r($Data);

			if($Data==NULL){
				$this->Msg("Не переданы данные","ERROR");
				return ;
			}

			$this->AddQ(" ( ");
			$Keys=array_keys($Data);
			$Fields=$Keys;
			
			for($i=0;$i<count($Fields);$i++){
				$Fields[$i]=str_replace("int:","",$Fields[$i]);				
				$Fields[$i]=str_replace("~sql:","",$Fields[$i]);
				$Fields[$i]=str_replace("sql:","",$Fields[$i]);
				$Fields[$i]=str_replace("id:","",$Fields[$i]);
				$this->AddQ(" `".$Fields[$i]."` ");
				if($i!=count($Keys)-1)$this->AddQ(" , ");
			}

			$this->AddQ(" ) ");

			$this->AddQ(" VALUES ( ");
			for($i=0;$i<count($Keys);$i++){
				// разбираем переданные параметры
				if(strripos($Keys[$i],"int:")!==FALSE){
					if($this->AddQ(" 'oxs:int' " , $Data[$Keys[$i]])==0) {  return 0; }
				}else if (strripos($Keys[$i],"~sql:")!==FALSE){
					if($this->AddQ(" oxs:sql " , $Data[$Keys[$i]] )==0) return 0;
				}else if (strripos($Keys[$i],"sql:")!==FALSE){
					if($this->AddQ(" 'oxs:sql' " , $Data[$Keys[$i]] )==0) return 0;
				}else if (strripos($Keys[$i],"id:")!==FALSE){
					if($this->AddQ(" 'oxs:id' " , $Data[$Keys[$i]] )==0) return 0;
				}else{
					if($this->AddQ( "'".$Data[$Keys[$i]]."'" )==0) return 0;
				}

				if($i!=count($Keys)-1)$this->AddQ(" , ");
			}
			$this->AddQ(" ) ");
			//echo "<br>".$this->GetQ();
			$this->Exec();

			return $this->GetLastID();
		}

		function Update($Table, $Data, ...$Where){
			$this->SetQ("UPDATE ");
			$this->AddQ("`".$Table."` SET ");

			$Keys=array_keys($Data);
			$Fields=$Keys;
			for($i=0;$i<count($Keys);$i++){
				$Fields[$i]=str_replace("int:","",$Fields[$i]);				
				$Fields[$i]=str_replace("~sql:","",$Fields[$i]);
				$Fields[$i]=str_replace("sql:","",$Fields[$i]);
				$Fields[$i]=str_replace("id:","",$Fields[$i]);
			}

			for($i=0;$i<count($Keys);$i++){
				// разбираем переданные параметры
				if(strripos($Keys[$i],"int:")!==FALSE){
					if($this->AddQ( "`".$Fields[$i]. "` =  'oxs:int' " , $Data[$Keys[$i]])==0) return 0;
				}else if (strripos($Keys[$i],"~sql:")!==FALSE){
					if($this->AddQ( "`".$Fields[$i]. "` =  oxs:sql " , $Data[$Keys[$i]])==0) return 0;
				}else if (strripos($Keys[$i],"sql:")!==FALSE){
					if($this->AddQ( "`".$Fields[$i]. "` =  'oxs:sql' " , $Data[$Keys[$i]])==0) return 0;
				}else if (strripos($Keys[$i],"id:")!==FALSE){
					if($this->AddQ( "`".$Fields[$i]. "` =  'oxs:id' " , $Data[$Keys[$i]])==0) return 0;
				}else{
					if($this->AddQ( "`".$Fields[$i]. "` =  ".$Data[$Keys[$i]]." "  )==0) return 0;
				}

				if($i!=count($Keys)-1) $this->AddQ(" , ");
			}

			if(!empty($Where)) $this->AddQ(...$Where);
			$this->Exec();
		}

		function Remove($Table,...$Where){
			$this->Delete($Table,...$Where);
		}

		function Delete($Table,...$Where){
			$this->SetQ("DELETE FROM ");
			$this->AddQ(" `".$Table."` ");
			if(!empty($Where)) $this->AddQ(...$Where);
			$this->Exec();
		}

		function Clear($Table){
			$this->Msg("Очищаю таблицу ".$Table."","WARNING");
			$this->Exec("TRUNCATE `".$Table."`");
		}

		/*function Select($Tables,$Fields,$Where=NULL){
			$this->Add("SELECT ".$Fields);
			$this->Add(" FROM ");
			$this->Add($Tables);
		}*/
	}
?>
