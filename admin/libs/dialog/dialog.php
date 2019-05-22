<?php

	if(!defined("OXS_PROTECT"))die("protect");

	class dialog extends CoreMultiLib{	

		private $uiNmae;
		private $HTML = "";
		private $objName;
			
		function __construct($Path,$params=null){
			parent::__construct($Path,$params);
			Oxs::G("field");				
		}	
	
		function addButton($Text,$Name,$Param=null){
			if(empty($Param["class"]))$Param["class"] = "btn btn-default"; 
			$this->HTML .= field::Button($Name,$Text,$Param);
		}

		function addText($Text){
			$this->HTML .= $Text;
		}

		function addPassword($Name,$Text=NULL,$Desc=null,$Param=null){
			$this->HTML .= field::Password($Name,$Text,array( "attr"=> $Param["attr"] , "class"=>"form-control ".$Param["class"] , "style" => "margin-top:3px; ".$Param["style"] , "auto_clear" => $Desc) );
		}

		function addEdit($Name,$Text=NULL,$Desc=null,$Param=null){
			$this->HTML .= field::Text($Name,$Text,array( "attr"=> $Param["attr"] , "class"=>"form-control ".$Param["class"] , "style" => "margin-top:3px; ".$Param["style"] , "auto_clear" => $Desc) );
		}

		function addHtml($html){
			$this->HTML .= $html;
		}

		function addBr(){
			$this->HTML .= "<br>";
		}

		function getObjectName(){
			return $this->objName;
		}

		function setName($Name){
			$this->uiNmae = $Name;
		}

		function build(){		

			//	Подгружаем интерфейс
			Oxs::G("oxs_obj")->G("crypto.base64");
			
			Oxs::G("BD")->Start();
			//	Обернем диолог в оконце
			Oxs::G("js.window")->GetObject("dialog_window_".$this->uiNmae);				
			$this->objName =  Oxs::J("dialog.js:dialog", array( Oxs::G("crypto.base64")->E($this->HTML) , $this->uiNmae  ) , $this->uiNmae );
			return  Oxs::G("BD")->getEnd();								
		}	
	}	

?>
