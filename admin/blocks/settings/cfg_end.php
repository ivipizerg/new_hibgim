<?php
		
	if(!defined("OXS_PROTECT"))die("protect");	

	class settings_cfg_end extends BlocksSingleLib{

		function __construct($Path,$params=null){			
			parent::__construct($Path,$params);
		}	

		function Exec(& $Param=null){

			if(!Oxs::G("file")->Access("cfg.php")){
				$this->SetAjaxCode(-1);						
				$this->SetAjaxText(Oxs::G("languagemanager")->T("cfgNotWriteable"));
				return TRUE;
			}	

			Oxs::G("file")->Write("cfg.php" , $Param["data"]["cfg_file"] );

			/*if(!Oxs::G("logger")->Get("ERROR")){
				$this->SetAjaxCode(1);
				$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName);
				$this->SetAjaxText(Oxs::G("languagemanager")->T("defaultFixGood"));
			}else{
				$this->SetAjaxCode(-1);				
				$this->SetAjaxText(Oxs::G("message_window")->getErrorUl("ERROR"));
			}*/
		}

	} 
