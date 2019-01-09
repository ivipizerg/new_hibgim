<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::G("default:add");
	
	class default_fix extends default_add{
		
		function __construct($Path){	
			parent::__construct($Path);		
		}

		function GetData(){
			return Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__oxs:sql` WHERE `id` = 'oxs:id'" , Oxs::G("datablocks_manager")->RealCurrentBlockName ,$this->getP("fixingId"));
		}			

		function ExecBefore(){
			if(!Oxs::G("cheker")->id($this->getP("fixingId")) || empty($this->getP("fixingId"))){
				$this->SetAjaxCode(1);
				$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName);
				$this->SetAjaxText(Oxs::G("languagemanager")->T("noID"));				
				return TRUE;
			}
		}
	}