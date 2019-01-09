
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:add_end");

	class fields_add_end extends default_add_end{
		
		function __construct($Path){	
			parent::__construct($Path);				
		}
		
		function Exec(){	
			
			parent::Exec();

			//	Если были ошибки при станадртном доабвлении завершаемся
			if($this->GetAjaxCode()==-1) return TRUE;

			//	Добавляем в таблицу поле
			//////////////////////////////////////////////////////////////
			//	Получаем инфу о блоке к которому добавляемся, так как нам тут приходит id а нужен system_name
			$BlockInfo = Oxs::G("blocks:model")->GetAboutBlockById($this->getD("block_name"))[0];
			
			//	Проверим тип друг нам подсунул какую т обяку
			if(Oxs::G("fields")->checkType($this->getD("db_type")) == TRUE ) { 
				$this->SetAjaxCode(-1);				
				$this->SetAjaxText(Oxs::G("message_window")->ErrorUl("ERROR"));
				return TRUE;
			}

			//	Добалвяем поле
			Oxs::G("DBLIB.IDE")->DB()->Exec("ALTER TABLE `#__oxs:sql` ADD `oxs:sql` ".($this->getD("db_type"))." NOT NULL" , $BlockInfo["system_name"] , $this->getD("system_name") );	

			if(Oxs::G("logger")->Get("ERROR")){

				Oxs::G("DBLIB.IDE")->DB()->Remove("#__".Oxs::G("datablocks_manager")->RealCurrentBlockName," WHERE `id` = 'oxs:id'" , $this->CurrentID  );			

				$this->SetAjaxCode(-1);				
				$this->SetAjaxText(Oxs::G("message_window")->ErrorUl("ERROR"));
				return TRUE;
			}

			//	Изменяем id блока на его system_name		
			Oxs::G("DBLIB.IDE")->DB()->Update("#__".Oxs::G("datablocks_manager")->RealCurrentBlockName,array(
				"sql:block_name" => $BlockInfo["system_name"]
			) , "WHERE `id` = 'oxs:id'" , $this->CurrentID );	

			if(!Oxs::G("logger")->Get("ERROR")){
				$this->SetAjaxCode(1);
				$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName);
				$this->SetAjaxText(  Oxs::G("message_window")->Good( Oxs::G("languagemanager")->T("fieldAddGood")) );
			}else{
				$this->SetAjaxCode(-1);				
				$this->SetAjaxText(Oxs::G("message_window")->ErrorUl("ERROR"));
			}		
		}
	}