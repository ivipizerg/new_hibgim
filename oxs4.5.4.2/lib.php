<?php

	class Lib{

		protected $oxs_Type;			//	Тип библиотеки
		protected $Path="";			//	Путь к фреймоврку	
		protected $LibName = "";
		protected $LibComponent = "";
		protected $LocalPath = "";

		//	Констурктор по умолчанию
		function __construct($_Path,$Params=null){
			$this->Path=$_Path;
			$this->Path = ltrim($this->Path,"/");
			$this->Msg("Загружаю библиотеку ".get_class($this)."(".$this->GetVersion().")","OBJECT_CREATE");

			$this->LibName = $Params["LibName"];
			$this->LibComponent = $Params["LibComponent"];
			$this->LocalPath = $Params["LocalPath"];
		}

		function SetLibName($Value){
			$this->LibName = $Value;
		}

		function SetLibComponent($Value){
			$this->LibComponent = $Value;
		}

		function SetLocalPath($Value){
			$this->LocalPath = $Value;			
		}

		function SetAjaxCode($Value=0){
			global $AjaxCode;
			$AjaxCode = $Value;
		}		

		function GetAjaxCode($Param=NULL){
			global $AjaxCode;
			return $AjaxCode;
		}

		function SetAjaxText($Value=0){
			global $AjaxText;
			$AjaxText = $Value;			
		}

		function GetAjaxText($Param=NULL){
			global $AjaxText;
			return $AjaxText;
		}


		function SetAjaxData($Name,$Value=0){
			global $AjaxData;
			$AjaxData[$Name] = $Value;			
		}

		function AddAjaxData($Name,$Value=0){
			global $AjaxData;
			
			if(!isset($AjaxData[$Name])){
				$AjaxData[$Name] = array();				
			}	

			array_push($AjaxData[$Name],$Value);		
		}

		function GetAjaxData($Name=null){
			global $AjaxData;
			if($Name==null) return $AjaxData;
			else return $AjaxData[$Name];
		}

		//	Подключить CSS стиль
		function Css($F=NULL){			
			
			if($F==NULL){
				$F=$this->LibName;
			}	

			Oxs::G("dom")->LoadCssOnce($this->Path."/".$this->LocalPath."/".$F.".css");			
		}

		//	Подключить js файл
		function JS($F=NULL,$ui_name=NULL){

			if($F==NULL){
				$Comp = $this->LibComponent;
				if(empty($Comp)){
					$Comp = $this->LibName;
				}
			}else{
				$Comp = $F;
			}			
			
			Oxs::G("js.loader")->GetObject($this->LibName.":".$Comp,NULL,$ui_name);
			
		}

		//	Получить тип
		function GetType(){return $this->oxs_Type;}

		//	Проверить тип на singlelib
		function IfSingle(){
			if($this->GetType()=="singlelib") return 1;
			return 0;
		}

		//	Проверить тип на singlelib
		function IfMulti(){
			if($this->GetType()=="multilib") return 1;
			return 0;
		}

		//	Получить версию
		function GetVersion(){

			$cl = new ReflectionClass(get_class($this));

			if(is_file(dirname($cl->getFileName())."/version.php"))
				include(dirname($cl->getFileName())."/version.php");
			else{
				$Version = "ВЕРСИЯ НЕ ОПРЕДЕЛЕНА";
			}
			return $Version;
		}

		//	Метод для записи информации в лог
		//	Записывает в общий канал а так же в личный канал библиотеки
		function Msg($Text,$Chanell,$Code=-1){
			$Err=Oxs::G("logger");
			$Err->AddMessage($Text,$Chanell.",".strtoupper(get_class($this)).".".$Chanell,$Code);
		}

	}

	/*
		Класс база для multilib
	*/

	class MultiLib extends Lib{

		protected $oxs_Type="multilib";

		//	Констурктор по умолчанию
		function __construct($_Path,$Params=null){
			parent::__construct($_Path,$Params);
		}

		function Init($Param=NULL){
			return 0;
		}
	}

	/*
		Класс база для singlelib
	*/

	class SingleLib extends Lib{

		protected $oxs_Type="singlelib";

		//	Констурктор по умолчанию
		function __construct($_Path,$Params=null){
			parent::__construct($_Path,$Params);
		}

	}

?>
