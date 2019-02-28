<?php

	define("OXS_PROTECT",TRUE);

	class oxs_fw{

		private $Path;
		private $Root = NULL;
		private $BackPath = "";

		function __construct(){			
		}

		function setSourses(...$Path){


			if(empty($Path[0])){
				$this->Error("Ошибка при инициализации OXS: не передан не один путь");
			}else{
				$this->Path[0] = $Path[0];				
			}

			if(count($Path)>=2){
				$t=1;
				for($i=1;$i<count($Path);$i++){
					$LibName = explode("/",$Path[$i]);
					$LibName=$LibName[count($LibName)-2];

					//echo $this->BackPath.$Path[$i].$LibName.".php<br>";

					if(file_exists($this->BackPath.$Path[$i].$LibName.".php")){
						$this->Path[$t++] = $Path[$i];
					}else{
						$this->Error("Проблемы с дополнительным источником библиотек:" . $Path[$i],"ERROR");
					}
				}
			}
		}

		function getOxsPath(){
			return $this->Path[0];
		}

		function AddSource($Path){			
		
			$LibName = explode("/",$Path);
			$LibName=$LibName[count($LibName)-2];		

			if(file_exists($this->BackPath.$Path.$LibName.".php")){
				$this->Path[count($this->Path)] = $Path;
				//echo ">>>>>>>>>>>>";
			}else{
				$this->Error("!Проблемы с дополнительным источником библиотек:" . $Path,"ERROR");
			}
		}

		//	Путь заканчиаеться слешем обязательно
		//	sample/ или /
		function SetRoot($Path = NULL){

			$this->BackPath="";

			if(empty($Path))$Path = "/" ;			

			//echo "Строка запроса: ". $_SERVER["SCRIPT_NAME"]."<br>";
			
			preg_match("/\/(.*)\/.*\.php$/",$_SERVER["SCRIPT_NAME"],$Result);
			$Request = $Result[1]."/";			

			//echo "Строка запроса обработанная: ".$Request ."<br>";	

			if($Path=="/"){
				if($Request=="/"){
					$this->BackPath = ""; 
					$this->Root = "/" ;
				}else{
					$this->Root = $Path ;
					for($i=0;$i<count(explode("/",$Request))-1 ;$i++){					
						$this->BackPath.="../";
					}
				}				
			}else{
				$Request = str_replace($Path,"",$Request)."/";
				$Request = str_replace("//","/",$Request);
				//echo "!".$Request."!";
				$this->Root = $Path ;
				if($Request=="/"){
					$this->BackPath = ""; 					
				}else{					
					for($i=0;$i<count(explode("/",$Request))-1 ;$i++){					
						$this->BackPath.="../";
					}
				}
			}			
		}

		function GetRoot(){
			return $this->Root;
		}

		function GetBack(){
			return $this->BackPath;
		}

		function Error($Text){
			throw new Exception($Text);			
		}

		private function InitLib($Name,$Param=NULL,$Requere=false,$OnlyChek=false){

			$TN = $Name;

			//	Проверяем указан ли компонент
			if(strripos($Name,":")===FALSE)
				$ComponentName=NULL;
			else{
				$ComponentName=explode(":",$Name);
				$ComponentName = $ComponentName[1];
			}

			if($ComponentName!==NULL){
				$Name = str_replace(":".$ComponentName,"",$Name);
			}

			//echo $Name;
			$DottedName = $Name;
			$Name=explode(".",$Name);
			$LibPath=implode("/",$Name);

			if($ComponentName!==NULL){
				$Name = $ComponentName;
			}else{
				$Name=$Name[count($Name)-1];
			}

			//	echo "LibPath = " . $LibPath." ";
			//echo "Name = " . $Name."<br>";

			include_once("lib.php");

			for($i=0;$i<count($this->Path);$i++){

				//echo $i."!".$this->BackPath."!";
				//echo "<br>".$this->BackPath.$this->Path[$i].$LibPath."/".$Name.".php<br>";

				if(file_exists($this->BackPath.$this->Path[$i].$LibPath."/".$Name.".php")){

					if($OnlyChek) return true;

					//	Подключаем основу
					if($i!=0){
						$CoreName = explode("/",$this->Path[$i]);
						$CoreName=$CoreName[count($CoreName)-2];

						include_once ($this->BackPath.$this->Path[$i]."/".$CoreName.".php");
					}					

					//echo $this->BackPath.$this->Path[$i]."/".$LibPath."/".$Name.".php<br>";
					include_once ($this->BackPath.$this->Path[$i]."/".$LibPath."/".$Name.".php");

					//echo "!".$LibPath.$ComponentName."!";

					$T=str_replace("/","_",$LibPath.( $ComponentName!==NULL ? "/".$ComponentName : "" ));

					//echo "!".$T."!";

					if(!class_exists($T)){
						$this->Error("Не найден класс библиотеки:" . $Name);
					}

					if(!$Requere) {
						$TT = new $T($this->Path[$i],array(
							"LibName" => $this->LibName = $DottedName,
							"LibComponent" => $this->LibComponent = $ComponentName,
							"LocalPath" => $this->LocalPath = $LibPath,
						));	
						return $TT;
					}

					return NULL;
				}
			}

			if($OnlyChek) return false;			
			$this->Error("Не найдена библиотека: ".$TN);
		}

		//	Просто подинключидть файл библиотеки
		function IncludeLib($Name){
			$this->InitLib($Name,$Param,true);
		}

		function IncludeFile($Path){				
			if(file_exists($this->BackPath.$Path)){
				include ($this->BackPath.$Path);
				return true;
			}else return false;	
		}

		function IncludeFileOnce($Path){	
			if(file_exists($this->BackPath.$Path)){
				include_once ($this->BackPath.$Path);
				return true;
			}else return false;	
		}

		//	Создать новый жкземпляр билиотеки multilib
		function LoadLib($Name,$Param=NULL){
			$T=$this->InitLib($Name,$Param);
			if($T->IfMulti()){ $T->Init($Param);  return $T; }
			else { unset($T); $this->Error("Неверный тип библиотеки ".$Name);}
		}

		//	Получить библиотеку singllib
		function GetLib($Name){
			static $ObjectMass;

			if(isset($ObjectMass[$Name])){
				return $ObjectMass[$Name];
			}else{
				$ObjectMass[$Name]=$this->InitLib($Name);
				if($ObjectMass[$Name]->IfSingle()){ return $ObjectMass[$Name]; }
				else { unset($ObjectMass[$Name]); $this->Error("Неверный тип библиотеки ".$Name);}
			}
		}

		function isExist($LibName){			
			return $this->InitLib($LibName,$Param,true,true);
		}

		function isFunctionExist($LibName,$FunctionName){
			Oxs::I($LibName);
			$LibName = str_replace(".", "_", $LibName);
			$LibName = str_replace(":", "_", $LibName);	
			return method_exists($LibName,$FunctionName);
		}

		//	Вывести сообщения библиотек
		function ShowErrors($Mode=true){
			return $this->GetLib("logger")->ShowLog($Mode);
		}

		/*function GetPaths(){
			for($i=0;$i<=$this->GetPathCount();$i++){
				$T .= $this->GetPath($i).",";
			}
			return trim($T,",");
		}*/

		function GetPath($i=0){
			return $this->Path[$i];
		}

		function GetPathCount(){
			return count($this->Path);
		}

		function GetVersion(){
			return Oxs::GetLib("cfg")->Get("Version",$this->getOxsPath()."version.php");
		}

	}

	//	Обертка для эстетичности кода
	class Oxs{		

		//	Функция старта
		static function Start(){
			global $Oxs;												
			$Oxs = new oxs_fw();				
			return $Oxs;
		}

		static function AddSource($Path){
			return Oxs()->AddSource($Path);
		}

		static function L($Name,$Param=NULL){
			return Oxs()->LoadLib($Name,$Param);
		}

		static function LoadLib($Name,$Param=NULL){
			return Oxs()->LoadLib($Name,$Param);
		}

		static function G($Name){
			return Oxs()->GetLib($Name);
		}

		static function GetLib($Name){
			return Oxs()->GetLib($Name);
		}

		static function isExist($LibName){
			return Oxs()->isExist($LibName);
		}

		static function isFunctionExist($LibName,$FunctionName){
			return Oxs()->isFunctionExist($LibName,$FunctionName);
		}

		static function I($Name){
			return Oxs()->IncludeLib($Name);
		}

		static function IF($Path){
			return Oxs()->IncludeFile($Path);
		}

		static function IFO($Path){
			return Oxs()->IncludeFileOnce($Path);
		}	

		static function IncludeLib($Name){
			return Oxs()->IncludeLib($Name);
		}

		static function ShowLog($Mode=true){
			return Oxs()->ShowErrors($Mode);
		}

		static function setSourses(...$Path){
			return Oxs()->setSourses(...$Path);
		}

		static function GetRoot(){
			return Oxs()->GetRoot();
		}

		static function GetBack(){
			return Oxs()->GetBack();
		}

		static function SetRoot($Path=NULL){
			Oxs()->SetRoot($Path);
		}

		static function GetPath($i=0){
			return Oxs()->GetPath($i);
		}

		static function GetPathCount(){
			return Oxs()->GetPathCount();
		}

		/*static function GetPaths(){
			return Oxs()->GetPaths();
		}*/

		static function GetVersion(){
			return Oxs()->GetVersion();
		}

		static function getOxsPath(){
			return Oxs()->getOxsPath();
		}

		static function Error($Text){
			die( "<!DOCTYPE html><meta charset=\"UTF-8\"><title>Ошибка фреймворка</title>Программа остановлена: ".$Text."" );
		}
	}

	function Oxs(){
		global $Oxs;
		return $Oxs;
	}

?>
