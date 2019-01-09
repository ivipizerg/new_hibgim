<?php

if(!defined("OXS_PROTECT"))die("Wrong start point");

class js_cookie extends SingleLib{

	function __construct($Path,$params=null){
		parent::__construct($Path,$params);
	}	

	function Inlcude($Param=null){	
		
		//	Подключить ядро билиотеки
		Oxs::G("js.loader")->IncludeObject("js.cookie");
		return true;
	}

	function GetObject($Name="js_cookie",$Param=null){	

		//	Подключить ядро билиотеки
		Oxs::G("js.loader")->GetObject("js.cookie",$Param,$Name);
		return true;	
	}	
	
}

?>