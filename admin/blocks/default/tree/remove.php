<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::G("default:remove");

	class default_tree_remove extends default_remove{	

		function __construct($Path){	
			parent::__construct($Path);			
		}			

		function Exec(){
			
			if($this->getIds()!=null){

				$Tree = Oxs::L("DBTree",array("table" => "#__".Oxs::G("datablocks_manager")->RealCurrentBlockName , "db" => Oxs::G("DBLIB.IDE")->DB()));

				for($i=0;$i<count($this->getIds());$i++){
					$Tree->Remove($this->getIds()[$i]);
				}
			}

			if(Oxs::G("logger")->get("ERROR")){
				$this->SetAjaxCode(-1);
				$this->SetAjaxText( Oxs::G("message_window")->ErrorUl( "ERROR" ) ) ;
			}else{
				//	Код 1 редирект на nextStep
				$this->SetAjaxCode(1);
				//	Куда переходить
				$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName);
				//	Сообщение для всплывашки
				$this->SetAjaxText( Oxs::G("message_window")->Good( "removeGood" ) );					
			}			
		}		
	}