<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::G("default:display");

	class docs_display extends default_display{		

		function __construct($Path,$Params=null){	
			parent::__construct($Path,$Params);								
		}

		function LoadData($Page){	

			$Sql = Oxs::L("sqlsearch");			
			
			$T = $this->getFieldsForSearch();						
			
			//	базовый запрос
			Oxs::G("DBLIB.IDE")->DB()->SetQ( "SELECT `#__docs`.* , `#__doc_cat`.`name`  AS `cat_name` FROM `#__docs` LEFT JOIN `#__doc_cat` ON `#__docs`.`cat` = `#__doc_cat`.`id` ".$mod1." ORDER BY `#__docs`.`position` ASC " );		

			//	Добавляем поиск
			/////////////////////////////////////////////////			
			//	По дополнительынм таблицам
				//	#__doc_tags	
					//	ищем
					if(!empty($this->getP("searchString"))){
						$DB2=Oxs::G("DBLIB.IDE")->getTmpDB();
						$Sql2 = Oxs::L("sqlsearch");

						$DB2->SetQ( "SELECT * FROM `#__doc_tags` " );
						$DB2=$Sql->search($DB2,$this->getP("searchString"),array("name"));	
							
						$R = $DB2->Exec();					
						//	получаем массив id шек
						$add="";
						for($i=0;$i<count($R);$i++){
							$add .= " OR `tags` LIKE '%\"".$R[$i]["id"]."\"%' ";
						}				
					}						

			//	По основнйо талбице
			$DB = $Sql->search(Oxs::G("DBLIB.IDE")->DB(),$this->getP("searchString"),$T);

			//	добавляем то что нашлось в подтаблицах
			$DB->AddQ($add);				

			//	Дописываем лимиты
			$DB->AddQ(" ".$this->getLimits($Page));			

			return $DB->Exec();
		}

		function DataProcessing($Data){		

			//	Замеянем id тегов на их названия
			$Data = Oxs::G("content_table.main_table:tools")->loadContentByJSONId($Data,"tags","#__doc_tags",
				function($tag){	
					return  mb_strimwidth($tag["name"],0,15,"...") . ",";
				},function($str){					
					if(empty($str)) return Oxs::G("languagemanager")->T("TAG_EMPTY");	
					else return rtrim($str,",");	;				
				}
			);

			//	Делаем читабельынй вывод файлов			
			for($i=0;$i<count($Data);$i++){				

				$Files = Oxs::G("JSON.IDE")->JSON()->D($Data[$i]["files"]);
				
				$Data[$i]["files"]="";
				if($Files)
				for($j=0;$j<count($Files);$j++){
					$Data[$i]["files"] .= $Files[$j]->original_name.",";
				}	
				$Data[$i]["files"] = rtrim($Data[$i]["files"],",");				
			}

			return $Data;
		}

		function FieldsProcessing($Fields){
			return Oxs::G("fields")->changeKey($Fields,"cat","cat_name");			
		}		

	}