
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default.tree:add_end");

	class buttons_add_end extends default_tree_add_end{
		
		function __construct($Path){	
			parent::__construct($Path);				
		}
		
		function Exec(){	
			
			//	Проверяем введенные данные
			////////////////////////////////////////////////////////			

			//	Уровень доступа должен быть числом			
			////////////////////////////////////////////////////////////////////////////////////
			if( !Oxs::G("cheker")->Int($this->getD("access"),"+0")  ){
				$this->SetAjaxCode(-1);
				$this->Msg(Oxs::G("languagemanager")->T("noAccess"),"MESSAGE");					
			}

			//	id родителя должно быт ьчисло
			////////////////////////////////////////////////////////////////////////////////////
			if( !Oxs::G("cheker")->id($this->getD("bid")) ){
				$this->SetAjaxCode(-1);
				$this->Msg(Oxs::G("languagemanager")->T("wrongBID"),"MESSAGE");					
			}

			//	Нет ли уже такой кнопки?
			/////////////////////////////////////////////////////////////////////////////////////
			$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__buttons` WHERE `name` = 'oxs:sql' and `bid` = 'oxs:id' and `displayin` = 'oxs:sql' and `action` = 'oxs:sql'" , $this->getD("name") , $this->getD("bid") , $this->getD("displayin") , $this->getD("action")  );				
			if($R!=FALSE){
				$this->SetAjaxCode(-1);
				$this->Msg( Oxs::G("languagemanager")->T("buttonAlreadyExist",$this->getD("name") ),"ERROR");
				$this->SetAjaxText( Oxs::G("message_window")->ErrorUl("ERROR") );
				return TRUE;
			} 

			$this->Msg("Проверки выполнены передаю стандартному обработчику","MESSAGE");
			$this->setD("pid",1);
			parent::Exec();			
		}
	}