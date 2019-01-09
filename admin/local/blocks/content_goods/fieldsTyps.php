 <?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:fieldsTyps");
	
	class content_goods_fieldsTyps extends default_fieldsTyps{
		
		function __construct($Path){	
			parent::__construct($Path);	
		}

		function select($Field,$Data){	

			//	Нам приходит field_source_table и field_source_name
			$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__content_cat`  WHERE `level` >= '3' ORDER BY `left_key` ASC"  );

			for($i=0;$i<count($R);$i++){				
				//$R[$i]["name"] = " ".$Data[$i]["name"];			
				for($j=0;$j<($R[$i]["level"]-2);$j++){
					$R[$i]["name"] = "―".$R[$i]["name"];
				}		

			}

			Oxs::I("field");	
			return $Field["description"].field::Select($Field["system_name"],$R,null,array( "class"=>"oxs_field_value form-control" , "value_name" => "name" ) );			
		}
		
		
	}
 
