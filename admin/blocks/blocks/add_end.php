
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:add_end");

	class blocks_add_end extends default_add_end{
		
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
				$this->Msg(Oxs::G("languagemanager")->T("noAccess"),"ERROR");					
			}

			//	id родителя должно быт ьчисло
			////////////////////////////////////////////////////////////////////////////////////
			if( !Oxs::G("cheker")->id( $this->getD("pid") ) ){
				$this->SetAjaxCode(-1);
				$this->Msg(Oxs::G("languagemanager")->T("wrongPID"),"ERROR");					
			}

			//	Нет ли уже такого блока?
			/////////////////////////////////////////////////////////////////////////////////////
			$R = Oxs::G("blocks:model")->GetAboutBlockByName($this->getD("system_name"));				
			if($R!=FALSE){
				$this->SetAjaxCode(-1);
				$this->Msg(Oxs::G("languagemanager")->T("blockAlreadyExist",$this->getD("system_name") ),"ERROR");
			} 

			//	Проверим нет ли уже такой таблицы в БД, возможно она была создана в ручную
			///////////////////////////////////////////////////////////////////////////////////////
			$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SHOW TABLES LIKE '#__oxs:sql'" , $this->getD("system_name"));			

			if($R!=FALSE){
				$this->SetAjaxCode(-1);
				$this->Msg(Oxs::G("languagemanager")->T("tableAlreadyExist",$this->getD("system_name") ),"ERROR");
			} 

			if($this->GetAjaxCode()==-1){
				$this->SetAjaxText( Oxs::G("message_window")->ErrorUl("blocks_add_end.ERROR") );
				return ;
			}
			////////////////////////////////////////////////////////			

			//	Вроде все ок создам нужные таблицы и записи
			//	Добавялем запись в таблицу блоков
			
			//	Текущее время 
			$C = Oxs::L("calendar");

			$Tree=Oxs::L("DBTree",array("db" => Oxs::G("DBLIB.IDE")->DB(), "table" => "#__blocks"));
			$LastId = $Tree->Insert($this->getD("pid"),array(
					"create_data" => $C->get("getUnix") ,
					"update_data" => 0,
					"status" => 0,
					"name" => $this->getD("name"),
					"description" => $this->getD("description"),
					"system_name" => $this->getD("system_name"),	
					"defaultAction" => $this->getD("defaultAction"),												
					"access" => $this->getD("access"),
					"section" => $this->getD("section"),
					"type" => $this->getD("type")
				));
				
			//	Смотрим были ли ошибки при доабвлении в базу
			if(Oxs::G("logger")->Get("ERROR")){
				//	Если ошибка во время добавления блока в таблицу завершаемся
				$this->SetAjaxCode(-1);
				$this->SetAjaxText( Oxs::G("message_window")->ErrorUl("ERROR"));
				return ;
			}


			//	Добавили блок в базу создаем ему таблицу
			///////////////////////////////////////////////////////////////////////////////////
			
			Oxs::G("DBLIB.IDE")->DB()->Exec("CREATE TABLE IF NOT EXISTS `#__oxs:sql` (
					`id` int(11) NOT NULL AUTO_INCREMENT,			
					PRIMARY KEY (`id`)
				)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",$this->getD("system_name"));
			
			//	Для tree
			if($this->getD("type")=="tree"){
				
				Oxs::G("DBLIB.IDE")->DB()->Exec("ALTER TABLE `#__oxs:sql`
					ADD `create_data` INT NOT NULL AFTER `id`, 
					ADD `update_data` INT NOT NULL AFTER `create_data`,			
					ADD `status` TINYINT(1) NOT NULL AFTER `update_data`, 
					ADD `position` INT NOT NULL AFTER `status`,
					ADD `level` INT NOT NULL AFTER `position`,
					ADD `left_key` INT NOT NULL AFTER `level`,
					ADD `right_key` INT NOT NULL AFTER `left_key`,
					ADD `pid` INT NOT NULL AFTER `right_key`",$this->getD("system_name"));
				
				$T1 = array( 
					"block_name" => $LastId,
					"name" => "Название",
					"system_name" => "name",
					"type" => "text",
					"db_type" => "tinytext" , 
					"form_name" => "Название",
					"description" => "Введите название",
					"filters" => "show_level /field level /correct -1",
					"access" => 700
				);				

				Oxs::G("datablocks_manager")->RealCurrentBlockName = "fields";
				$TMP = $this->getD();				
				$this->setD(NULL,$T1);	
				if(Oxs::G("fields:add_end")->ExecBefore()!=TRUE){
					//	Если это произошло то все хренвоенько товарищи
					//	Надо бы откатит ьвсе то что был осделано сверху
					if(Oxs::G("fields:add_end")->Exec()==TRUE) return TRUE;
				}
					
				Oxs::G("datablocks_manager")->RealCurrentBlockName = "blocks";
				$this->setD(NULL,$TMP);	

				Oxs::G("DBLIB.IDE")->DB()->Insert("#__fields" , array(
					"block_name" => $this->getD("system_name"),
					"name" => "Родитель",
					"system_name" => "pid",
					"type" => "tree_parent",
					"db_type" => "int" , 
					"form_name" => "Родитель",
					"description" => "Выберите родителя",
					"filters" => "",
					"access" => 700
					) 
				);

				//	Инциализируем ROOT запись
				$TT=Oxs::L("DBTree",array("db" => Oxs::G("DBLIB.IDE")->DB(), "table" => "#__".$this->getD("system_name")));
				$TT->CreateRoot();

				Oxs::G("DBLIB.IDE")->DB()->Update("#__".$this->getD("system_name") , array(
					"sql:name" => "ROOT"
				), " WHERE `id` = '1'"  );
				
			}else{
			//	Для стандартного блока				
				Oxs::G("DBLIB.IDE")->DB()->Exec("ALTER TABLE `#__oxs:sql`
					ADD `create_data` INT NOT NULL AFTER `id`, 
					ADD `update_data` INT NOT NULL AFTER `create_data`,			
					ADD `status` TINYINT(1) NOT NULL AFTER `update_data`, 
					ADD `position` INT NOT NULL AFTER `status`",$this->getD("system_name"));
			}
			
			/////////////////////////////////////////////////////////////////////////////////
			//	Добавили блок в базу создаем ему таблицу

			//	Создаем блоку стандартыне кнопки	Доабвить Удалить Вкл/Выкл	Ок отмена применить отмена
			$TreeButtons=Oxs::L("DBTree",array("db" => Oxs::G("DBLIB.IDE")->DB(), "table" => "#__buttons"));

			//	Доабвить в дисплее
			$TreeButtons->Insert(1,array( 
						"create_data" => $C->get("getUnix"),
						"update_data" => 0,
						"status" => 1,
						"name" => "Добавить",
						"bid" => $LastId,
						"displayin" => $this->getD("system_name").":display",
						"action" => $this->getD("system_name").":add",
						"access" => 1000	
					));

			//	Удалить в дисплее
			$TreeButtons->Insert(1,array( 
						"create_data" => $C->get("getUnix"),
						"update_data" => 0,
						"status" => 1,
						"name" => "Удалить",
						"bid" => $LastId,
						"displayin" => $this->getD("system_name").":display",
						"action" => $this->getD("system_name").":remove"	,
						"access" => 1000			
					));

			//	отключить в дисплее
			$TreeButtons->Insert(1,array( 
						"create_data" => $C->get("getUnix"),
						"update_data" => 0,
						"status" => 1,
						"name" => "Вкл/Выкл",
						"bid" => $LastId,
						"displayin" => $this->getD("system_name").":display",
						"action" => $this->getD("system_name").":status"	,
						"access" => 1000		
					));

			//	Доабвить в дисплее
			$id_fix=$TreeButtons->Insert(1,array( 
						"create_data" => $C->get("getUnix"),
						"update_data" => 0,
						"status" => 1,
						"name" => "Правка",
						"bid" => $LastId,
						"displayin" => $this->getD("system_name").":display",
						"action" => "",
						"access" => 1000		
					));


			//	Для tree
			if($this->getD("type")=="tree"){
				//	Доабвить в дисплее
				$TreeButtons->Insert($id_fix,array( 
							"create_data" => $C->get("getUnix"),
							"update_data" => 0,
							"status" => 1,
							"name" => "Выделить",
							"bid" => $LastId,
							"displayin" => $this->getD("system_name").":display",
							"action" => $this->getD("system_name").":fixing?mode=1",
							"access" => 1000,
							"ui_class" => "oxs_copy_past"		
						));

				//	Доабвить в дисплее
				$TreeButtons->Insert($id_fix,array( 
							"create_data" => $C->get("getUnix"),
							"update_data" => 0,
							"status" => 1,
							"name" => "Вставить",
							"bid" => $LastId,
							"displayin" => $this->getD("system_name").":display",
							"action" => $this->getD("system_name").":fixing?mode=2",
							"access" => 1000,
							"ui_class" => "oxs_copy_past"			
						));

				//	Доабвить в дисплее
				$TreeButtons->Insert($id_fix,array( 
							"create_data" => $C->get("getUnix"),
							"update_data" => 0,
							"status" => 1,
							"name" => "Вложить",
							"bid" => $LastId,
							"displayin" => $this->getD("system_name").":display",
							"action" => $this->getD("system_name").":fixing?mode=3",
							"access" => 1000,
							"ui_class" => "oxs_copy_past"			
						));
			}else{
				//	Доабвить в дисплее
				$TreeButtons->Insert($id_fix,array( 
							"create_data" => $C->get("getUnix"),
							"update_data" => 0,
							"status" => 1,
							"name" => "Вырезать",
							"bid" => $LastId,
							"displayin" => $this->getD("system_name").":display",
							"action" => $this->getD("system_name").":fixing?mode=1",
							"access" => 1000,
							"ui_class" => "oxs_copy_past"			
						));

				//	Доабвить в дисплее
				$TreeButtons->Insert($id_fix,array( 
							"create_data" => $C->get("getUnix"),
							"update_data" => 0,
							"status" => 1,
							"name" => "Копировать",
							"bid" => $LastId,
							"displayin" => $this->getD("system_name").":display",
							"action" => $this->getD("system_name").":fixing?mode=2",
							"access" => 1000,
							"ui_class" => "oxs_copy_past"			
						));

				//	Доабвить в дисплее
				$TreeButtons->Insert($id_fix,array( 
							"create_data" => $C->get("getUnix"),
							"update_data" => 0,
							"status" => 1,
							"name" => "Вставить",
							"bid" => $LastId,
							"displayin" => $this->getD("system_name").":display",
							"action" => $this->getD("system_name").":fixing?mode=3",
							"access" => 1000,
							"ui_class" => "oxs_copy_past"			
						));
			}

			

			//	Проверка в дисплее если тип Tree
			if($Param["data"]["type"]=="tree"){

				$TreeButtons->Insert(1,array( 
						"create_data" => $C->get("getUnix"),
						"update_data" => 0,
						"status" => 1,
						"name" => "Проверка",
						"bid" => $LastId,
						"displayin" => $this->getD("system_name").":display",
						"action" => $this->getD("system_name").":check_base",
						"access" => 1000		
					));
			}			

			//	Ок при добавлении
			$id_add=$TreeButtons->Insert(1,array( 
						"create_data" => $C->get("getUnix"),
						"update_data" => 0,
						"status" => 1,
						"name" => "Добавить",
						"bid" => $LastId,
						"displayin" => $this->getD("system_name").":add",
						"action" => $this->getD("system_name").":add_end",
						"access" => 1000				
					));

			//	Ок при добавлении
			$TreeButtons->Insert($id_add,array( 
						"create_data" => $C->get("getUnix"),
						"update_data" => 0,
						"status" => 1,
						"name" => "... и включить",
						"bid" => $LastId,
						"displayin" => $this->getD("system_name").":add",
						"action" => $this->getD("system_name").":add_end?mode=1",
						"access" => 1000				
					));

			//	Ок при добавлении
			$TreeButtons->Insert($id_add,array( 
						"create_data" => $C->get("getUnix"),
						"update_data" => 0,
						"status" => 1,
						"name" => "... и создать новый",
						"bid" => $LastId,
						"displayin" => $this->getD("system_name").":add",
						"action" => $this->getD("system_name").":add_end?mode=2",
						"access" => 1000				
					));

			//	отмена при добавлении
			$TreeButtons->Insert(1,array( 
						"create_data" => $C->get("getUnix"),
						"update_data" => 0,
						"status" => 1,
						"name" => "Отмена",
						"bid" => $LastId,
						"displayin" => $this->getD("system_name").":add",
						"action" => $this->getD("system_name").":cancel"	,
						"access" => 1000			
					));

			//	Применить при редактировании
			$id_fixx = $TreeButtons->Insert(1,array( 
						"create_data" => $C->get("getUnix"),
						"update_data" => 0,
						"status" => 1,
						"name" => "Сохранить",
						"bid" => $LastId,
						"displayin" => $this->getD("system_name").":fix",
						"action" => $this->getD("system_name").":fix_end"	,
						"access" => 1000			
					));

			$TreeButtons->Insert($id_fixx,array( 
						"create_data" => $C->get("getUnix"),
						"update_data" => 0,
						"status" => 1,
						"name" => "... и не закрывать",
						"bid" => $LastId,
						"displayin" => $this->getD("system_name").":fix",
						"action" => $this->getD("system_name").":fix_end?mode=1"	,
						"access" => 1000			
					));

			//	отмена при редактировании
			$TreeButtons->Insert(1,array( 
						"create_data" => $C->get("getUnix"),
						"update_data" => 0,
						"status" => 1,
						"name" => "Отмена",
						"bid" => $LastId,
						"displayin" => $this->getD("system_name").":fix",
						"action" => $this->getD("system_name").":cancel"	,
						"access" => 1000			
					));

			//	Для tree
			if($this->getD("type")=="tree"){
				$TreeButtons->Insert(1,array( 
						"create_data" => $C->get("getUnix"),
						"update_data" => 0,
						"status" => 1,
						"name" => "Проверка",
						"bid" => $LastId,
						"displayin" => $this->getD("system_name").":display",
						"action" => $this->getD("system_name").":check_base"	,
						"access" => 1000			
					));
			}
			
			//	Код 1 редирект на nextStep
			$this->SetAjaxCode(1);
			//	Куда переходить
			$this->SetAjaxData("nextStep","blocks:display");
			//	Сообщение для всплывашки			
			$this->SetAjaxText( Oxs::G("message_window")->Good( Oxs::G("languagemanager")->T("dataBlockAddedSuccess") ) );
		}
	}