<?php
	/*	

		Название:cfg
		Автор: Зарницын Дмитрий Александрович;
		Почта автора: zergvip@mail.ru;
		
	*/

	if(!defined("OXS_PROTECT"))die("Wrong start point");

	class cfg extends SingleLib{

		protected $CfgPath;

		function __construct($Path){
			parent::__construct($Path);			
		}

		function SetCfgFile($FilePath){
			$this->CfgPath=Oxs::GetBack().$FilePath;
		}	

		function isExist($Name,$PathCfgFile=NULL){
			return $this->Get($Name,$PathCfgFile);
		}

		//	Получить значение с конфига		
		//////////////////////////////////////////////////////
		function Get($Name,$PathCfgFile=NULL){	
			
			if($PathCfgFile==NULL){				
				if(empty($this->CfgPath)){					
					$this->Msg("Не указано не одного файла конфигурации ","ERROR");
					return 0;
				}else{					
					$PathCfgFile=$this->CfgPath;
				}				
			}else{
				$PathCfgFile=Oxs::GetBack().$PathCfgFile;
			}
			
			if(is_file($PathCfgFile)){
				include($PathCfgFile);
			}else{
				$this->Msg("Указанный файл конфигурации \"".$PathCfgFile."\" не найден" ,"ERROR");
				return NULL;
			}			

			$this->Msg("Получаю данные \"".$Name."\" из файла конфигурации \"" . $PathCfgFile ."\"" ,"MESSAGE");	

			if(isset($$Name)){ return trim( urldecode($$Name) ); }
			else {$this->Msg("Не удалось найти параметр: ".$Name,"WARNING"); return NULL;}	
			
		}
		
		//	Установить значение в конфиг
		///////////////////////////////////////////////////////	
		function Set($name,$val,$PathCfgFile=NULL){

			$PathCfgFile=Oxs::GetBack().$PathCfgFile;

			if($PathCfgFile==NULL){
				echo "1";
				if(empty($this->CfgPath)){
					$this->Msg("Не указано не одного файла конфигурации ","ERROR");
					return 0;
				}else{
					$PathCfgFile=$this->CfgPath;
				}				
			}	

			if(!is_file($PathCfgFile)){
				$this->Msg("Указанный файл конфигурации \"".$PathCfgFile."\" не найден \"" . $PathCfgFile ."\"" ,"ERROR");
				return 1;
			}	

			if(!is_writable($PathCfgFile)){
				$this->Msg("Указанный файл не доступен для записи \"".$PathCfgFile."\" не найден \"" . $PathCfgFile ."\"" ,"ERROR");
				return 1;
			}

			$this->Msg("Устанавливаю параметр: \"".$name."\" в файл \"". $PathCfgFile . "\"", "MESSAGE" );		
			
			$val=htmlspecialchars($val);
			if(empty($val))$val=0;

			include_once("text_func.php");
			
			$val=urlencode ($val);					

			$line = file_get_contents($PathCfgFile);			
			$line1=GetTextBefore($line,'$'.$name);
			if($line1!=NULL){				
				$line1=GetTextBefore($line,'$'.$name);
				$line2=GetTextAfter($line,'$'.$name);	
				$line2=GetTextAfter($line2,';');			
				
				$File=fopen($PathCfgFile,"w");
					fprintf($File,'%s$%s = \'%s\';%s%s',$line1,$name,$val,"",$line2);
				fclose($File);	
			} else {
				$line1=GetTextBefore($line,"?>");

				if($line1[0]!="<"&&$line1[1]!="?"&&$line1[2]!="p"&&$line1[3]!="h"&&$line1[4]!="p")
				$line1="<?php \n".$line1;								
				
				$File=fopen($PathCfgFile,"w");
					fprintf($File,'%s$%s = \'%s\';%s%s',$line1."\t",$name,$val,"\n","?>");
				fclose($File);	
			}
		}		

	} 	
		
?>