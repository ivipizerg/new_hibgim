
<?php
	if(!defined("OXS_PROTECT"))die("protect");	

	Oxs::I("default:fixing");

	class default_tree_fixing extends default_fixing{
		
		function __construct($Path){	
			parent::__construct($Path);			
		}			

		//	Нам приходит id перемещаемого 
		//	и id после которого нужно вставиться
		function Exec(){		

			switch($this->getM("mode")){
				//	Вырезать
				case 1 : 
					$this->SetAjaxCode(-1);	
					$this->SetAjaxText(Oxs::G("message_window")->Info(Oxs::G("languagemanager")->T("CuteSelect")));	
					$_SESSION["oxs_copy_cut_id"] = $this->getIds()[0];
					return TRUE;					
				break;						
			}				
		}

		function ExecAfter(){
			switch($this->getM("mode")){
				case 2 :
					$this->setP("currentId",$_SESSION["oxs_copy_cut_id"]);
					$this->setP("changeId",$this->getIds()[0]);
					$this->setP("parentMode","false");
					Oxs::G("default.tree:position")->Exec();
									
				break;
				case 3 : 				
					
					$this->setP("currentId",$_SESSION["oxs_copy_cut_id"]);
					$this->setP("changeId",$this->getIds()[0]);
					$this->setP("parentMode","true");
					Oxs::G("default.tree:position")->Exec();					
				break;
			}

			unset($_SESSION["oxs_copy_cut_id"]);

			if(Oxs::G("logger")->Get("ERROR")){
				$this->SetAjaxCode(-1);				
				$this->SetAjaxText(Oxs::G("message_window")->ErrorUl("ERROR"));		
				return TRUE;	
			}else{
				$this->SetAjaxCode(1);
				$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName);
				$this->SetAjaxText(Oxs::G("message_window")->Good(Oxs::G("languagemanager")->T("COPY_CUT_SUCCESS")));
			}
		}		
	}