<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::G("default:display");

	class default_tree_display extends default_display{		

		function __construct($Path,$Params=null){	
			parent::__construct($Path,$Params);								
		}

		function LoadMyJS(){
			Oxs::G("oxs_obj")->G("default.js.display:fix");
			Oxs::G("oxs_obj")->G("default.js.display:navigation");

			Oxs::G("search")->Init();	
			Oxs::G("dialog")->Init();		
			
			Oxs::G("oxs_obj")->G("default.js:collect_cheked_id");		
			Oxs::G("oxs_obj")->G("default.js:active_buttons");	

			Oxs::G("oxs_obj")->G("default.tree.js:position");
			Oxs::G("oxs_obj")->G("default.js.display:fixing");
		}
	
		function LoadData($Page){	

			$Sql = Oxs::L("sqlsearch");
			
			$T = $this->getFieldsForSearch();
			array_push($T,"name_pid");
			//	базовый запрос

			Oxs::G("DBLIB.IDE")->DB()->SetQ( "SELECT `T1`.* ,  `T2`.`name` AS `name_pid` , `T1`.`pid` AS `T1pid` FROM `oxs_oxs:sql` AS `T1` LEFT JOIN `oxs_oxs:sql` AS `T2` ON (`T1`.`pid` = `T2`.`id`) ORDER BY `left_key` ASC"  , Oxs::G("datablocks_manager")->RealCurrentBlockName , Oxs::G("datablocks_manager")->RealCurrentBlockName );			
			
			//	Добавляем поиск
			$DB = $Sql->search(Oxs::G("DBLIB.IDE")->DB(),Oxs::G("datablocks_manager")->Params["data"]["searchString"],$T);		

			//	Дописываем лимиты
			$DB->AddQ(" ".$this->getLimits($Page));			

			return $DB->Exec();			
		}

		//	Заменяем корень
		function FieldsProcessing($Fields){					
			return Oxs::G("fields")->ChangeKey($Fields,"pid","name_pid");
		}

	}