<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::G("default:remove");

	class fields_remove extends default_remove{				

		function __construct($Path){	
			parent::__construct($Path);			
		}	

		function ExecBefore(){
			
			if(parent::ExecBefore()) return TRUE;

			//	Спрашиваем подтверждение
			if( empty($this->getP("oxs_dialog_ask_yes_fields_remove")) ){
				Oxs::G("dialog")->AskUser("oxs_dialog_ask_yes_fields_remove",Oxs::G("languagemanager")->T("confirm_remove_field"));				
				return TRUE;
			}
		}

		function Exec(){	
			
			$Tree=Oxs::L("DBTree",array("db" => Oxs::G("DBLIB.IDE")->DB(), "table" => "#__blocks"));
			
			if($this->getIds()!=null){
				for($i=0;$i<count($this->getIds());$i++){

					//	Получаем информацию об удаляемом полю
					$CurrentField = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__fields` WHERE `id` = 'oxs:id'" , $this->getIds()[$i])[0];

					//	Удаляем поле из таблицы блока
					Oxs::G("DBLIB.IDE")->DB()->Exec("ALTER TABLE `#__oxs:sql` DROP `oxs:sql`" , $CurrentField["block_name"] , $CurrentField["system_name"]);

					//	Удаляем саму запись
					Oxs::G("DBLIB.IDE")->DB()->Remove("#__fields"," WHERE `id` = 'oxs:id'" , $this->getIds()[$i]);
				}	

				//	Проверяем были ли ошибки
				if(Oxs::G("logger")->get("ERROR")){
					$this->SetAjaxCode(-1);
					$this->SetAjaxText(Oxs::G("message_window")->ErrorUl("ERROR"));
				}else{
					//	Код 1 редирект на nextStep
					$this->SetAjaxCode(1);
					//	Куда переходить
					$this->SetAjaxData("nextStep","fields");
					//	Сообщение для всплывашки
					$this->SetAjaxText( Oxs::G("message_window")->Good(Oxs::G("languagemanager")->T("FieldDeleteGood")) );					
				}			
			}				
		}
	}