<?php

if(!defined("OXS_PROTECT"))die("Wrong start point");

class js_codebox extends SingleLib{

	function __construct($Path,$params=null){
		parent::__construct($Path,$params);
	}	

	function Inlcude($Param=null){	
		
		//	Подключить ядро билиотеки
		Oxs::G("js.loader")->IncludeObject("js.codebox");
		return true;
	}

	function GetObject($Name="js_codebox",$Param=null){	

		//	Подключить ядро билиотеки
		Oxs::G("js.loader")->GetObject("js.codebox",$Param,$Name);
		return true;	
	}	
	
}

?>