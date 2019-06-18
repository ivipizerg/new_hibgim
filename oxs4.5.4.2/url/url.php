<?php


if(!defined("OXS_PROTECT"))die("Wrong start point");

class url extends SingleLib {

		function __construct($Path){
			parent::__construct($Path);
		}

		private function getUrl(){
			return $_SERVER["SCRIPT_NAME"];
		}

		function GetParams($Url=NULL){
			if($Url==NULL) $Url =  $this->getUrl();

			$Url = explode("?",$Url);				

			$Url = explode("&",$Url[1]);			

			for($i=0;$i<count($Url);$i++){
				$Param = explode("=",$Url[$i]);
				$this->Param[$Param[0]] = $Param[1];
			}

			return $this->Param;
		}

		function GetPath($Url=NULL){
			if($Url==NULL) $Url=$this->getUrl();
			$Url = explode("?",$Url)[0];				
			return rtrim($Url,$this->GetName($Url).".".$this->GetExt($Url));		
		}

		//	Имя файла не обязательно должно иметь расширение
		function GetName($Url=NULL){
			if($Url==NULL) $Url=$this->getUrl();	

			//	!!!СПОРНЫЙ МЕТОД РЕШЕНЯИ ПРОБЕЛМЫ С КИРИЛЛИЦЕЙ!!!
			setlocale(LC_ALL,'ru_RU.UTF-8');		
			
			$File_info = pathinfo($Url);	

			/*Oxs::G("BD")->Start();

			echo $Url;

			var_dump($File_info);

			$this->Msg(Oxs::G("BD")->getEnd(),"MESSAGE");*/

			return $File_info['filename'] ;			
		}

		function GetExt($Url=NUL){
			if($Url==NULL) $Url=$this->getUrl();
			
			//	!!!СПОРНЫЙ МЕТОД РЕШЕНЯИ ПРОБЕЛМЫ С КИРИЛЛИЦЕЙ!!!
			setlocale(LC_ALL,'ru_RU.UTF-8');
			
			$File_info = pathinfo($Url);			
			return $File_info['extension'] ;		
		}
	}
?>
