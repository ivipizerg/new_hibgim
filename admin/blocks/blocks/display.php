<?php
		
	if(!defined("OXS_PROTECT"))die("protect");

	//	Наследуемся от стандартного блока вывода
	Oxs::I("default:display");

	class blocks_display extends default_display{

		function __construct($Path,$params=null){
			parent::__construct($Path,$params);			
		}			
		
		function LoadData($Page){	
			
			$Sql = Oxs::L("sqlsearch");
			
			//	базовый запрос
			Oxs::G("DBLIB.IDE")->DB()->SetQ( "SELECT `T1`.* ,  `T2`.`name` AS `name_pid` , `T1`.`pid` AS `T1pid` FROM `oxs_blocks` AS `T1` LEFT JOIN `oxs_blocks` AS `T2` ON (`T1`.`pid` = `T2`.`id`) ORDER BY `left_key`" );
			
			//	Добавляем поиск
			$DB = $Sql->search(Oxs::G("DBLIB.IDE")->DB(),$this->getP("searchString"),array(
				"name" , "system_name" , "description", "defaultAction" , "type" , "name_pid"
			));		

			//	Дописываем лимиты
			$DB->AddQ(" ".$this->getLimits($Page));			

			return $DB->Exec();
		}


		//	Заменяем корень
		function FieldsProcessing($Fields){					
			return Oxs::G("fields")->ChangeKey($Fields,"pid","name_pid");
		}
	}

