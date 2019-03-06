<?php

	if(!defined("OXS_PROTECT"))die("protect");

	class templatemanager_model extends CoreSingleLib{

		function __construct($Path){
			parent::__construct($Path);
		}

		function GetDefaultTemplateName($mode="admin"){
			
			$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__templates` WHERE `inuse` = '1' and `type` = 'oxs:sql'" , $mode);			
			
			if(!$R) return null;
			return $R[0]["system_name"];
		}

		function getCurentTemplateName(){		
			if(Oxs::G("templatemanager")->getTemplateMode()=="admin")	
				return $_SESSION["tpl"]["admin"]["current_template_name"];	
			else	
				return $_SESSION["tpl"]["front"]["current_template_name"];	
		}
	}

?>
