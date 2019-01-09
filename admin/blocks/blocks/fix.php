<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::G("default:fix");
	
	class blocks_fix extends default_fix{
		
		function __construct($Path){	
			parent::__construct($Path);					
		}	

		function Map(){
			return Oxs::G("blocks:add")->Map();
		}
		
		function ExecBefore(){
			parent::ExecBefore($Param);

			if($this->getP("fixingId")==1){
				$this->SetAjaxCode(-1);
				$this->SetAjaxText(Oxs::G("languagemanager")->T("noEditRoot"));				
				return TRUE;
			}
		}		
		
	}