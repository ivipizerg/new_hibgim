 <?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:fieldsTyps");

	class default_tree_fieldsTyps extends default_fieldsTyps{
		
		function __construct($Path){	
			parent::__construct($Path);	
		}

		function tree_parent($Field,$Data){			
			
			Oxs::I("field");	
			//	Получаем список блоков
			$Tree=Oxs::L("DBTree",array("db" => Oxs::G("DBLIB.IDE")->DB() , "table" => "#__".Oxs::G("datablocks_manager")->RealCurrentBlockName));
		
			$UlArray = $Tree->GetTreeEx( array( "Foo" => 	function($DB,$Params){				
				$DB->SetQ("SELECT * FROM (".($DB->GetQ()).") AS T WHERE `status` = '1' ");				
				return $DB;
			} , "Params" => array ("data" => $Data) ) );			
					

			return $Field["description"].field::Select($Field["system_name"], $UlArray , function ($i,$Value,$Param){	
				
				for($j=0;$j<$Value["level"]-1;$j++){
					$Value["name"] = "―".$Value["name"];
				}	

				if($Param == $Value["id"]){
					return array( "string" => "value=".$Value["id"] . " selected" , "value" =>  $Value["name"]); 
				}else{
					return array( "string" => "value=".$Value["id"] , "value" =>  $Value["name"]); 
				}								
			}  ,array( "value" => $Data , "value_name"=>"name" , "class" => "form-control oxs_field_value") );	
		}

		function cat_tree($Field,$Data){			

			$Tree=Oxs::L("DBTree",array("db" => Oxs::G("DBLIB.IDE")->DB() , "table" => "#__".Oxs::G("storage")->get("filter_value")["table"]));

			$UlArray = $Tree->GetTreeEx( array( "Foo" => function ($DB,$Params){		

				$DB->SetQ("SELECT * FROM (".($DB->GetQ()).") AS T WHERE `status` = '1' AND `id` != '1' ");				
				return $DB;

			} , "Params" => array ("data" => $Data) ) );	

			return $Field["description"].field::Select($Field["system_name"], $UlArray , function ($i,$Value,$Param){

				for($j=0;$j<$Field[ Oxs::G("storage")->get("filters_show_level_add_field") ] - Oxs::G("storage")->get("filters_show_level_add_correct") ;$j++){
					$Value["name"] = "―".$Value["name"];
				}	

				if($Param == $Value["id"]){
					return array( "string" => "value=".$Value["id"] . " selected" , "value" =>  $Value["name"]); 
				}else{
					return array( "string" => "value=".$Value["id"] , "value" =>  $Value["name"]); 
				}	
											
			},array( "value" => $Data , "value_name"=>"name" , "class" => "form-control oxs_field_value") );	;
		}

		function cat_childs($Field,$Data){

			$Tree=Oxs::L("DBTree",array("db" => Oxs::G("DBLIB.IDE")->DB() , "table" => "#__".Oxs::G("storage")->get("filter_value")["table"]));

			$UlArray = $Tree->GetChildsEx( Oxs::G("storage")->get("filter_value")["id"] , array( "Foo" => function ($DB,$Params){		

				$DB->SetQ("SELECT * FROM (".($DB->GetQ()).") AS T WHERE `status` = '1' AND `id` != '1' ");				
				return $DB;

			} , "Params" => array ("data" => $Data) ) );	

			return $Field["description"].field::Select($Field["system_name"], $UlArray , function ($i,$Value,$Param){

				for($j=0;$j<$Field[ Oxs::G("storage")->get("filters_show_level_add_field") ] - Oxs::G("storage")->get("filters_show_level_add_correct") ;$j++){
					$Value["name"] = "―".$Value["name"];
				}	

				if($Param == $Value["id"]){
					return array( "string" => "value=".$Value["id"] . " selected" , "value" =>  $Value["name"]); 
				}else{
					return array( "string" => "value=".$Value["id"] , "value" =>  $Value["name"]); 
				}	
											
			},array( "value" => $Data , "value_name"=>"name" , "class" => "form-control oxs_field_value") );	;
		}
		
	}
 
