<?php
		
	if(!defined("OXS_PROTECT"))die("protect");	

	class content_table_main_table extends MultiLib{

		private $MainTable;

		function __construct($Path){			
			parent::__construct($Path);	
			echo Oxs::G("dom")->JQ();	
			echo Oxs::G("dom")->Ui();				
		}


		function Show($Fields,$Data){			
			
			Oxs::G("BD")->Start();

			$Table = Oxs::L("table",array( "class"=>"table-hover oxs_smatr_table" , "count" => count($Fields) , "attr" => "id = 'oxs_smatr_table_id' border=0" ) ) ;			

			//	Делаем шапку
			for($j=0;$j<count($Fields);$j++){	
				$Table->Add( $Fields [$j]["name"]	, "class=\"".$Fields[$j]["field_class"]."\" style='" .$Fields[$j]["field_style"]."'" );	
			}

			//	Допиливаем содержимое
			for($i=0;$i<count($Data);$i++){	
				for($j=0;$j<count($Fields);$j++){					
					
					if($Data[$i]["status"]==0){
						$statusOff = "color:#ccc;";
					}else{
						$statusOff = "";
					}
					
					$Table->Add( "" . $Data[$i][$Fields [$j]["system_name"]] . "" , "data-block=".(Oxs::G("datablocks_manager")->RealCurrentBlockName)." data-id=\"" .$Data[$i]["id"]. "\" class=\"ui-state-defaul ".$Fields[$j]["data_class"]." ".$Data[$i]["data_class"]." \" style='" .$statusOff.$Fields[$j]["data_style"]." ".$Data[$i]["data_style"]."'");	
				}
			}
			
			$Table->Show();
					

			return Oxs::G("BD")->GetEnd();
		}	
	} 
