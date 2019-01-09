<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:fix_end");
	
	class fields_fix_end extends default_fix_end{
		
		function __construct($Path){	
			parent::__construct($Path);					
		}	

		function Exec(){

			//	Получим еще не измененное поле			
			$CurrentField = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__fields` WHERE `id` = 'oxs:id'" , $this->getP("fixingId"))[0];
			if(!$CurrentField){
				$this->SetAjaxCode(-1);
				$this->Msg(Oxs::G("languagemanager")->T("fieldNotExist"),"ERROR");		
			}		

			//	Проверяем введенные данные
			////////////////////////////////////////////////////////		

			//	Уровень доступа должен быть числом			
			////////////////////////////////////////////////////////////////////////////////////
			if( !Oxs::G("cheker")->Int($this->getD("access"),"+0")  ){
				$this->SetAjaxCode(-1);
				$this->Msg(Oxs::G("languagemanager")->T("noAccess"),"ERROR");					
			}

			//	Ошибок нет выполянем стандартный fix_end			
			//	Получаем инфу о блоке к которому добавляемся, так как нам тут приходит id а нужен system_name
			$BlockInfo = Oxs::G("blocks:model")->GetAboutBlockById($this->getD("block_name"))[0];
			$TMP = $this->getD("block_name");
			$this->setD("block_name" , $BlockInfo["system_name"]);
			parent::Exec();
			$this->setD("block_name" , $TMP);

			if(Oxs::G("logger")->Get("ERROR")){
				$this->SetAjaxCode(-1);
				$this->SetAjaxText( Oxs::G("message_window")->ErrorUl("ERROR") );
			}
			////////////////////////////////////////////////////////
			
			//	Проверим тип друг нам подсунул какую т обяку
			if(Oxs::G("fields")->checkType($this->getD("db_type")) == TRUE ) return TRUE;

			//	Если изменилось меняем поле
			Oxs::G("DBLIB.IDE")->DB()->Exec("ALTER TABLE `#__oxs:sql` CHANGE `oxs:sql` `oxs:sql` ".($this->getD("db_type"))." NOT NULL" , $CurrentField["block_name"], $CurrentField["system_name"] , $this->getD("system_name"));	

			////////////////////////////////////////////////////////////////////////////////////////			

			if(!Oxs::G("logger")->Get("ERROR")){				

				if(!Oxs::G("logger")->Get("ERROR")){
					$this->SetAjaxCode(1);
					$this->SetAjaxData("nextStep","fields");
					$this->Msg( Oxs::G("languagemanager")->T("dataBlockUpdateSuccess") , "ERROR" );
				}else{
					$this->SetAjaxCode(-1);
					$this->SetAjaxText( Oxs::G("message_window")->ErrorUl("ERROR") );
				}
				
			}else{
				$this->SetAjaxCode(-1);
				$this->SetAjaxText( Oxs::G("message_window")->ErrorUl("ERROR") );
			}		
		}	
		
	}