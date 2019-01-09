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
			$Url_o=$Url;
			//	Рвем строку по знаку вопроса
			$Url = explode("?",$Url);
			//	РВем по слешам
			$Url = explode("/",$Url[0]);
			//	Рвем по точке
			$Url = explode(".",$Url[count($Url)-1]);

			//echo "Исходный: " .$Url_o . " :::: ".$Url[0]."<br>";	 

			return $Url[0];			
		}

		function GetExt($Url=NUL){
			if($Url==NULL) $Url=$this->getUrl();
			
			$Url_o=$Url;
			//	Рвем строку по знаку вопроса
			$Url = explode("?",$Url);
			//	РВем по слешам
			$Url = explode("/",$Url[0]);
			//	Рвем по точке
			$Url = explode(".",$Url[count($Url)-1]);

			//echo "Исходный: " .$Url_o . " :::: ".$Url[1]."<br>";	 		
			if($Url[1]!="") return $Url[1]; else return null;		
		}
	}
?>
