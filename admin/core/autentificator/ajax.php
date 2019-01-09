<?php

if(!defined("OXS_PROTECT"))die("protect");

class autentificator_ajax extends CoreSingleLib{	

	function __construct($Path){
		parent::__construct($Path);										
	}	

	function AjaxExec($Param=NULL){

		switch($Param["action"]){
			case "getform": echo Oxs::G("autentificator:forms")->GetAuthForm(); break;
			case "try_enter": echo Oxs::G("autentificator:controller")->TryLogin($Param["login"],$Param["password"],$Param["cookie"]); break;	
			case "logOut": echo Oxs::G("autentificator:controller")->logOut(); break;				
			default: return;
		}	
	}
	
}

?>