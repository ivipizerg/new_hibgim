<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:fix_end");
	
	class blocks_fix_end extends default_fix_end{
		
		function __construct($Path){	
			parent::__construct($Path);					
		}	

		function Exec(){

			//	Получим еще не измененый блок
			$CurrentBlock = Oxs::G("blocks:model")->GetAboutBlockById($this->getP("fixingId"))[0];
			if(!$CurrentBlock){
				$this->SetAjaxCode(-1);
				$this->Msg(Oxs::G("languagemanager")->T("data_blocks_not_exist"),"blocks_fix_end.MESSAGE");		
			}

			//	Проверяем введенные данные
			////////////////////////////////////////////////////////			

			//	Уровень доступа должен быть числом			
			////////////////////////////////////////////////////////////////////////////////////
			if( !Oxs::G("cheker")->Int($this->getD("access"),"+0")  ){
				$this->SetAjaxCode(-1);
				$this->Msg(Oxs::G("languagemanager")->T("noAccess"),"blocks_fix_end.MESSAGE");					
			}

			//	id родителя должно быть число
			////////////////////////////////////////////////////////////////////////////////////
			if( !Oxs::G("cheker")->id($this->getD("pid")) ){
				$this->SetAjaxCode(-1);
				$this->Msg(Oxs::G("languagemanager")->T("wrongPID"),"blocks_fix_end.MESSAGE");					
			}

			if($this->GetAjaxCode()==-1){
				$this->SetAjaxText( Oxs::G("message_window")->ErrorUl("blocks_fix_end.MESSAGE") );
				return TRUE;
			}
			////////////////////////////////////////////////////////			


			//	Проверяем не изменилась ли у нас таблица блока
			/////////////////////////////////////////////////////////////////////////////////////////////	
			if($CurrentBlock["system_name"]!=$this->getD("system_name")){
				//	Если изменилось проверяем можем ли мы изменить таблицу

				//	Нет ли уже такого блока?
				/////////////////////////////////////////////////////////////////////////////////////
				$R = Oxs::G("blocks:model")->GetAboutBlockByName($this->getD("system_name"));				
				if($R!=FALSE){
					$this->SetAjaxCode(-1);
					$this->Msg(Oxs::G("languagemanager")->T("blockAlreadyExist",$this->getD("system_name") ),"blocks_fix_end.ERROR");
				} 

				//	Проверим нет ли уже такой таблицы в БД, возможно она была создана в ручную
				///////////////////////////////////////////////////////////////////////////////////////
				$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SHOW TABLES LIKE '#__oxs:sql'" , $this->getD("system_name"));			

				if($R!=FALSE){
					$this->SetAjaxCode(-1);
					$this->Msg(Oxs::G("languagemanager")->T("tableAlreadyExist",$this->getD("system_name") ),"blocks_fix_end.ERROR");
				} 

				if($this->GetAjaxCode()==-1){
					$this->SetAjaxText( Oxs::G("message_window")->ErrorUl("blocks_fix_end.ERROR") );
					return TRUE;
				}				

				//	Если все ок меняем имя таблицы
				Oxs::G("DBLIB.IDE")->DB()->Exec( "RENAME TABLE `#__oxs:sql` TO `#__oxs:sql`" , $CurrentBlock["system_name"] ,$this->getD("system_name") );
				Oxs::G("DBLIB.IDE")->DB()->Update("#__blocks",array(
					"sql:system_name" => $this->getD("system_name")
					)," WHERE `id` = 'oxs:id'" , $CurrentBlock["id"] );

				
				if(!Oxs::G("logger")->Get("ERROR")){
					$this->Msg(Oxs::G("languagemanager")->T("tableRenameGood",$this->getD("system_name") ),"blocks_fix_end.GOOD");
				}else{
					$this->SetAjaxCode(-1);
					$this->Msg( Oxs::G("languagemanager")->T("tableRenameError"),"blocks_fix_end.ERROR");
					$this->Msg( Oxs::G("logger")->GetString("ERROR") ,"blocks_fix_end.ERROR");
				}

				if($this->GetAjaxCode()==-1){
					$this->SetAjaxText( Oxs::G("message_window")->ErrorUl("blocks_fix_end.ERROR") );
					return TRUE;
				}	

				//	Если все ок меняем блок в полях
					Oxs::G("DBLIB.IDE")->DB()->Update("#__fields" , array(
					"sql:block_name" => $this->getD("system_name")
				), " WHERE `block_name` = 'oxs:sql'" , $CurrentBlock["system_name"] );

				if(!Oxs::G("logger")->Get("ERROR")){
					$this->Msg(Oxs::G("languagemanager")->T("FieldsRenameGood",$this->getD("system_name") ),"blocks_fix_end.GOOD");
				}else{
					$this->SetAjaxCode(-1);
					$this->Msg( Oxs::G("languagemanager")->T("FieldsRenameError"),"blocks_fix_end.ERROR");
					$this->Msg( Oxs::G("logger")->GetString("ERROR") ,"blocks_fix_end.ERROR");
				}

				if($this->GetAjaxCode()==-1){
					$this->SetAjaxText( Oxs::G("message_window")->ErrorUl("blocks_fix_end.ERROR") );
					return TRUE;
				}	

			}
			////////////////////////////////////////////////////////////////////////////////////////

			//	Проверяем не изменился ли наш родитель
			if($CurrentBlock["pid"]!=$this->getD("pid")){
				$Tree=Oxs::L("DBTree",array("db" => Oxs::G("DBLIB.IDE")->DB(), "table" => "#__blocks"));
				$Tree->ChangeParent($CurrentBlock["id"],$this->getD("pid"));
			}

			//	Обработаем чекбокс
			if($this->getD("section")=="on") $this->setD("section",1); else  $this->setD("section",0);

			$C = Oxs::L("calendar");

			//	Изменяем простые данные название, урвоень доступа, активный не активный, Действие по умолчанию, описание
			Oxs::G("DBLIB.IDE")->DB()->Update("#__blocks",array(
				"sql:name" => $this->getD("name"),
				"int:access" => $this->getD("access"),
				"int:section" => $this->getD("section"),				
				"sql:defaultAction" => $this->getD("defaultAction"),
				"sql:description" => $this->getD("description"),
				"sql:type" => $this->getD("type"),
				"int:update_data" => $C->get("getUnix")
			),"WHERE `id` = 'oxs:id'" , $this->getP("fixingId"));

			if(!Oxs::G("logger")->Get("ERROR")){
				$this->Msg( Oxs::G("languagemanager")->T("dataBlockUpdateSuccess") ,"blocks_fix_end.GOOD");
			}else{
				$this->Msg( Oxs::G("logger")->GetString("ERROR") ,"ERROR");
			}

			//	Код 1 редирект на nextStep
			$this->SetAjaxCode(1);
			//	Куда переходить
			$this->SetAjaxData("nextStep","blocks:display");
			//	Сообщение для всплывашки
			$this->SetAjaxText( 
				Oxs::G("message_window")->GoodUl("blocks_fix_end.GOOD").Oxs::G("message_window")->ErrorUl("blocks_fix_end.ERROR")				
			);
		}	
		
	}