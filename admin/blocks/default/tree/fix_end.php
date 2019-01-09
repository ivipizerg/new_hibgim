
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:fix_end");

	class default_tree_fix_end extends default_fix_end{	

		function __construct($Path){	
			parent::__construct($Path);			
		}	

		function LoadFields(){
			
			$Fields = Oxs::G("fields:model")->GetFieldsForBlock();
			
			for($i=0;$i<count($Fields);$i++){
				if($Fields[$i]["system_name"] == "pid") unset($Fields[$i]);
				sort($Fields);
			}

			return $Fields;
		}	
		
		function Exec(){	

			//	Возьмем старого парента
			$oldPost = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__oxs:sql` WHERE `id` = 'oxs:id'" , $this->getP("block_name") , $this->getP("fixingId") )[0];

			parent::Exec();

			if($oldPost["pid"]!=$this->getD("pid")){
				//	Меняем родителя
				$Tree = Oxs::L("DBTree",array( "table" => "#__".($this->getP("block_name")) , "db" => Oxs::G("DBLIB.IDE")->DB()));
				$Tree->ChangeParent($this->getP("fixingId"),$this->getD("pid"));

				if(!Oxs::G("logger")->Get("ERROR")){								
					$this->SetAjaxText( Oxs::G("message_window")->Good($this->getAjaxText() . Oxs::G("languagemanager")->T("defaultTreeChangeParentGood")));
				}else{
					$this->SetAjaxCode(-1);	
					$this->Msg( Oxs::G("languagemanager")->T("defaultTreeChangeParentError"),"ERROR");			
					$this->SetAjaxText(Oxs::G("message_window")->ErrorUl("ERROR"));
				}
			}
		}		
	}