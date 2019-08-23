<?php
	if(!defined("OXS_PROTECT"))die("protect");

	class img_remove extends BlocksSingleLib{		

		function __construct($Path,$Params=null){	
			parent::__construct($Path,$Params);				
		}

		function ajaxExec($Param){
			

			for($i=0;$i<count($Param["data"]);$i++){
				$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT `#__img`.* , `#__img_cat`.`path` AS `cat_path`  FROM `#__img` , `#__img_cat`  WHERE `#__img`.`cat` = `#__img_cat`.`id` and `#__img`.`id` = 'oxs:id'" , $Param["data"][$i] );

				if(Oxs::G("file")->isExist($R[0]["cat_path"].$R[0]["file"])){
					Oxs::G("file")->delete($R[0]["cat_path"].$R[0]["file"]);
					$this->Msg(Oxs::G("languagemanager")->T("FILE_DELETED_SUCCESS" , $R[0]["file"] ),"GOOD.img_remove");
				}
				else
					$this->Msg(Oxs::G("languagemanager")->T("FILE_NOT_FOUND" , $R[0]["file"] ),"ERROR");
				
				if(Oxs::G("file")->isExist($R[0]["cat_path"]."/thumbs/".$R[0]["file"])){
					Oxs::G("file")->delete($R[0]["cat_path"]."/thumbs/".$R[0]["file"]);
					$this->Msg(Oxs::G("languagemanager")->T("FILE_DELETED_SUCCESS" , $R[0]["file"] ),"GOOD.img_remove");
				}
				else
					$this->Msg(Oxs::G("languagemanager")->T("FILE_NOT_FOUND" , $R[0]["file"] ),"ERROR");

				Oxs::G("DBLIB.IDE")->DB()->Remove("#__img", " WHERE `id` = 'oxs:id'" ,$Param["data"][$i] );
			}

			$this->setAjaxCode(1);
			$this->setAjaxData("nextStep","img:display");
			if(Oxs::G("logger")->get("ERROR")){	
				$this->SetAjaxText(Oxs::G("message_window")->ErrorUl("ERROR").Oxs::G("message_window")->GoodUl("GOOD.img_remove"));
				return ;
			}else{
				$this->SetAjaxText(Oxs::G("message_window")->Good(Oxs::G("languagemanager")->T("ALL_FILE_DELETED_SUCCESS")));
				return ;
			}
		}

	}