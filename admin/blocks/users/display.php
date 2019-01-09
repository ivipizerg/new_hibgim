<?php
		
	if(!defined("OXS_PROTECT"))die("protect");

	//	Наследуемся от стандартного блока вывода
	Oxs::I("default:display");

	class users_display extends default_display{

		function __construct($Path){			
			parent::__construct($Path);
		}			
		
		function LoadData($Page){	
			
			$Sql = Oxs::L("sqlsearch");
			
			//	базовый запрос
			Oxs::G("DBLIB.IDE")->DB()->SetQ( "SELECT `T1`.* ,  `T2`.`name` AS `default_block_name` FROM `oxs_users` AS `T1` LEFT JOIN `oxs_blocks` AS `T2` ON (`T1`.`default_block` = `T2`.`id`) ORDER BY `position` ASC" );
			
			//	Добавляем поиск
			$DB = $Sql->search(Oxs::G("DBLIB.IDE")->DB(),Oxs::G("datablocks_manager")->Params["data"]["searchString"],array(
				"username" , "default_block_name" 
			));		

			//	Дописываем лимиты
			$DB->AddQ(" ".$this->getLimits($Page));			

			return $DB->Exec();
		}


		//	Заменяем корень
		function FieldsProcessing($Fields){					
			return Oxs::G("fields")->ChangeKey($Fields,"default_block","default_block_name");
		}
	}

