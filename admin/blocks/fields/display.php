<?php
		
	if(!defined("OXS_PROTECT"))die("protect");

	//	Наследуемся от стандартного блока вывода
	Oxs::I("default:display");

	class fields_display extends default_display{

		function __construct($Path,$Params=null){			
			parent::__construct($Path,$Params);
		}

		function LoadData($Page){	

			$Sql = Oxs::L("sqlsearch");
			
			$T = $this->getFieldsForSearch();	

			//	базовый запрос
			Oxs::G("DBLIB.IDE")->DB()->SetQ( "SELECT * FROM `#__".Oxs::G("datablocks_manager")->RealCurrentBlockName."` ORDER BY `block_name` ASC , `position` ASC " );			
			
			//	Добавляем поиск
			$DB = $Sql->search(Oxs::G("DBLIB.IDE")->DB(),$this->getP("searchString"),$T);		

			//	Дописываем лимиты
			$DB->AddQ(" ".$this->getLimits($Page));			

			return $DB->Exec();
		}

		function DataProcessing($Data){
			$Data = parent::DataProcessing($Data);
			
			$OldBname = "";
			$C = count($Data);
			$TMP;
			for($i=0,$j=0;$j<$C;$i++){
				
				if($Data[$j]["block_name"]!=$OldBname){					 
					
					$OldBname = $Data[$j]["block_name"];
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

