<?php

	define("OXS_PROTECT",TRUE);

	class setting_manager extends CoreSingleLib{

		function __construct($Path){
			parent::__construct($Path);
		}

		function getOption($Name=NULL){			
			
			if($Name==NULL){
				$this->Msg(Oxs::G("languagemanager")->T("noSettingName"),"ERROR");
			}		

			$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT `value` FROM `#__settings` WHERE `system_name` = 'oxs:sql'" , $Name);
			if(!$R) 
				return null;
			else
				return $R[0]["value"];
		
		}		
	}

?>
