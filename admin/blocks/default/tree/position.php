
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::G("default:position");

	class default_tree_position extends default_position{
		
		function __construct($Path){	
			parent::__construct($Path);			
		}	

		function ExecBefore(){			
			parent::ExecBefore();
		}

		//	Нам приходит id перемещаемого 
		//	и id после которого нужно вставиться
		function Exec(){				

			if( empty( $this->getP("currentId") ) ||  !Oxs::G("cheker")->id($this->getP("currentId"))){
				$this->SetAjaxCode(1);
				$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName);
				$this->SetAjaxText(Oxs::G("message_window")->Error(Oxs::G("languagemanager")->T("positionChangeErrorcurrentId")));
				return TRUE;
			}

			if( empty($this->getP("changeId")) ||  !Oxs::G("cheker")->id($this->getP("changeId"))  ){
				$this->SetAjaxCode(1);
				$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName);
				$this->SetAjaxText(Oxs::G("message_window")->Error(Oxs::G("languagemanager")->T("positionChangeErrorСhangeId")));
				return TRUE;
			}

			if(empty($this->getP("parentMode"))){
				$this->setP( "parentMode" , "false" );
			}

			$Tree = Oxs::L("DBTree",array("table" => "#__".Oxs::G("datablocks_manager")->RealCurrentBlockName , "db" => Oxs::G("DBLIB.IDE")->DB()));

			if($this->getP("parentMode")=="false"){
				$Tree->Move($this->getP("currentId"),$this->getP("changeId"));
			}else{
				$Tree->ChangeParent($this->getP("currentId"),$this->getP("changeId"));
			}	

			if(!Oxs::G("logger")->Get("ERROR")){
				$this->SetAjaxCode(1);
				$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName);
				$this->SetAjaxText(Oxs::G("message_window")->Good(Oxs::G("languagemanager")->T("positionChangeGood")));	
			}else{
				$this->SetAjaxCode(1);
				$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName);		
				$this->SetAjaxText(Oxs::G("message_window")->ErrorUl("ERROR") );	
			}			
		}				
	}