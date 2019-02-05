<?php

	define("OXS_PROTECT",TRUE);

	class param_parser_Params{
		public $Name;
		public $Value;
	}

	class param_parser_Command{
		public $name;
		public $Params;
	}	

	class filters_manager extends CoreSingleLib{

		private $PMode=false;

		function __construct($Path){
			parent::__construct($Path);
		}

		//	Принимаем столбец данных с заголовком
		function Exec(& $Fields , & $Data){	
			//	Бежим по полям и разбираем фильтры на команды
			for($i=0;$i<count($Fields);$i++){
				if(!empty($Fields[$i]["filters"])){

					//	Если задана группа фильтра то выполняем фильт из указанной группы
					///////////////////////////////////////////////////////////////////////////
					/*if(empty($Fields[$i]["filter_group"]))
						$filter_group = Oxs::G("datablocks_manager")->CurrentBlockAction;
					else{
						$filter_group = $Fields[$i]["filter_group"];
					}*/
					///////////////////////////////////////////////////////////////////////////

					//echo "Найдена строка: ".$Fields[$i]["filters"]."<br>";
					$CommandsTmp = $this->ParceFilterString($Fields[$i]["filters"]);
					
					//	Бежим по командам и выполянем их
					for($j=0;$j<count($CommandsTmp);$j++){
						
						//echo "Исполняю команду: ".$CommandsTmp[$j]->name."<br>";

						if(Oxs::isExist("filters.".$CommandsTmp[$j]->name.":".Oxs::G("datablocks_manager")->CurrentBlockAction)){
							Oxs::G("filters.".$CommandsTmp[$j]->name.":".Oxs::G("datablocks_manager")->CurrentBlockAction)->Exec($CommandsTmp[$j],$Fields[$i],$Data);
						}else{
							$this->Msg("Фильтр \"filters.".($CommandsTmp[$j]->name.":".Oxs::G("datablocks_manager")->CurrentBlockAction)."\" не найден","MESSAGE");
						}
					}
				}
			}				
		}

		function EjectValue($Command,$Filter_name){
			
			for($i=0;$i<count($Command->Params);$i++){				
				if($Command->Params[$i]->Name == $Filter_name){
					return $Command->Params[$i]->Value;
				}
			}

			return NULL;
		}

		//	command /v1 asd , command2 /v1 wewewe /v2 "asdasd asd"
		private function ParceFilterString($Param_string){	

			$ReturnCommand;	
			$g=0;
			//echo $Param_string."<br>";	

			//	Разбиваем по запятым, если запятая между кавычками её не считаем
			if(empty($Param_string)) return NULL;

			for($i=0;$i<=strlen($Param_string);$i++){
				
				if( ($Param_string[$i]=="," AND !$this->PMode  ) OR $i == strlen($Param_string) ){					
					$CommandMass[$j] = implode("",$CommandMass[$j]);
					//echo $CommandMass[$j]."<br>";					
					$t=0;
					$j++;					
				}else{
					if($Param_string[$i]=="\"") if(!$this->PMode)$this->PMode=true; else $this->PMode=false;
					$CommandMass[$j][$t++] = $Param_string[$i];
				}
			}
			
			//	На выоде массив строк $CommandMass в каждой строке команда	
			
			//print_r($CommandMass);

			foreach ($CommandMass AS $Command){	

				//echo "Массив:".$Command."<br>";

				//	Result[0] - команда
				preg_match("/^[^\s]*/",trim($Command),$Result);
				//print_r($Result);
				$Command = trim(str_replace($Result[0]."", "", $Command));

				//echo "Команда: ".$Result[0]."<br>";				
				//echo "Строка: " . $Command."<br>";			

				$ReturnCommand[$g] = new param_parser_Command();
				$ReturnCommand[$g]->name =  $Result[0];
				
				if($Command[0]=="/"){				
					$gg=0;	
					//	Разбиваем по параметрам
					for($i=0;$i<=strlen($Command);$i++){										
						if( $Command[$i]=="/"){
							
							$j=0;$Tmp=array();	
							
							while($Command[$i]!=" " AND $i!=strlen($Command) ){
								$Tmp[$j++]=$Command[$i++];
							}							
							
							//	Странно но пришлось это закоментировать так как в $tmp уже сторка
							$Tmp = implode($Tmp,"");
							//echo "Параметр:".$Tmp."<br>";

							$ReturnCommand[$g]->Params[$gg] = new param_parser_Params();
							$ReturnCommand[$g]->Params[$gg]->Name = trim($Tmp,"/");

							//	Смотрим есть ли аргументы и считываем если есть
							//	Пропускаем пробелы
							while( $Command[$i]==" " AND $i!=strlen($Command) ){								
								$i++;		
							}							

							$Tmp=array();$j=0; $ggg=0;
							$this->PMode=false;
							while( $Command[$i]!="/" AND $i!=strlen($Command) ){	

								if($Command[$i]=="\"" AND $Command[$i-1]!="\\"){  if(!$this->PMode) $this->PMode=true; else $this->PMode=false;}

								if( $Command[$i]!=" " AND ($i!=strlen($Command)-1) OR $this->PMode ) {									
									$Tmp[$j++] = $Command[$i++];
								}
								else{									
									$Tmp[$j++] = $Command[$i++];
									//	Странно но пришлось это закоментировать так как в $tmp уже сторка							
									$Tmp = implode($Tmp,"");
									$Tmp=trim($Tmp);
									//	Жахаем екранируемые кавычки
									$Tmp=str_replace("\\\"","\"",$Tmp);
									if(!empty($Tmp)){
										//echo "Значение:".$Tmp."<br>";
										$ReturnCommand[$g]->Params[$gg]->Value[$ggg++]=$Tmp;	
									}																	
									$j=0;
									$Tmp="";
								}								
							}
							$i--;
							$gg++;							
						}else{
							if(!empty($Command))
							$this->Msg("Ошибка синтаксиса в параметра".$Command,"WARNING");
						}
					}

				}else{
					if(!empty($Command))
					$this->Msg("Ошибка синтаксиса в параметра".$Command,"WARNING");
				}

				$g++;					
			}
			
			//var_dump($ReturnCommand);
			return $ReturnCommand;
		}

		function DecodeFilterMessage(){
			
			if(Oxs::G("logger")->get("ERROR.FILTER")!=FALSE){					
				$this->SetAjaxText( Oxs::G("message_window")->ErrorUl("ERROR.FILTER") );
				return TRUE;
			}		

		}
	}

?>
