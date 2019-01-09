<?php
		
	if(!defined("OXS_PROTECT"))die("protect");

	//	Наследуемся от стандартного блока вывода
	Oxs::I("default.tree:display");

	class buttons_display extends default_tree_display{

		function __construct($Path,$Params=null){			
			parent::__construct($Path,$Params);
		}			
		
		function LoadData($Page){	

			$Sql = Oxs::L("sqlsearch");	

			Oxs::G("DBLIB.IDE")->DB()->SetQ( "SELECT `T1`.* , `T2`.`name` AS `bid_name` FROM `#__buttons` AS T1 LEFT JOIN  `#__blocks` AS T2 ON ( `T1`.`bid` = `T2`.`id`) WHERE `T1`.`name` != 'ROOT' ORDER BY `T2`.`name` ASC , `left_key` ASC" );

			$DB = $Sql->search(
				Oxs::G("DBLIB.IDE")->DB(),
				$this->getD("searchString"),
				array(
					"name" , "displayin" , "action" , "bid_name"
				)
			);		

			$DB->AddQ(" ".$this->getLimits($Page));

			return $DB->Exec();
		}		

		//	Заменяем корень
		function FieldsProcessing($Fields){	
			return Oxs::G("fields")->ChangeKey($Fields,"bid","bid_name");			
		}

		function DataProcessing($Data){
			$Data = parent::DataProcessing($Data);
			
			$OldBname = "";
			$C = count($Data);
			$TMP;
			for($i=0,$j=0;$j<$C;$i++){
				if($Data[$j]["bid_name"]!=$OldBname){					 
					
					$OldBname = $Data[$j]["bid_name"];
					$inner = array( "data_style" => "background:#eae8e8; border-top:#91b4fd 1px solid;" ,"checkbox_template" => "no_chekbox" , "status" => 1 , "name" => "<b>".$OldBname."</b>" );
					
					$TMP[$i] = $inner;				
					$i++;
					$TMP[$i] = $Data[$j];										
				
				}else $TMP[$i] = $Data[$j];

				$j++;
			}
			return $TMP;
		}		
	}
