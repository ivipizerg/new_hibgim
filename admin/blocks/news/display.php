<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:display");

	class news_display extends default_display{		

		function __construct($Path,$Params=null){	
			parent::__construct($Path,$Params);				
		}		

		function LoadData($Page){	

			$Sql = Oxs::L("sqlsearch");
			
			$T = $this->getFieldsForSearch();	

			//	базовый запрос
			Oxs::G("DBLIB.IDE")->DB()->SetQ( "SELECT * FROM `#__".Oxs::G("datablocks_manager")->RealCurrentBlockName."` ORDER BY `position` DESC " );			
			
			//	Добавляем поиск
			$DB = $Sql->search(Oxs::G("DBLIB.IDE")->DB(),$this->getP("searchString"),$T);		

			//	Дописываем лимиты
			$DB->AddQ(" ".$this->getLimits($Page));			

			return $DB->Exec();
		}		
	}