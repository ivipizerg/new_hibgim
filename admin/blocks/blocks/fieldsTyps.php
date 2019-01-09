 <?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:fieldsTyps");
	
	class blocks_fieldsTyps extends default_fieldsTyps{
		
		function __construct($Path,$params=null){	
			parent::__construct($Path,$params);	
		}

		function block_parent($Field,$Data){

			Oxs::I("field");	
			//	Получаем список блоков
			$Tree=Oxs::L("DBTree",array("db" => Oxs::G("DBLIB.IDE")->DB() , "table" => "#__blocks"));

			function Foo_blocks_fields($DB,$Params){				
				$DB->SetQ("SELECT * FROM (".($DB->GetQ()).") AS T WHERE `status` = '1' ");				
				return $DB;
			}

			$UlArray = $Tree->GetTreeEx(array( "Foo" => Foo_blocks_fields , "Params" => array ("data" => $Data) ) );

			//	Строим список
			function Foo_blocks_fields_1($i,$Value,$Param){	
				
				for($j=0;$j<$Value["level"]-1;$j++){
					$Value["name"] = "―".$Value["name"];
				}	

				if($Param == $Value["id"]){
					return array( "string" => "value=".$Value["id"] . " selected" , "value" =>  $Value["name"]); 
				}else{
					return array( "string" => "value=".$Value["id"] , "value" =>  $Value["name"]); 
				}								
			}		

			return $Field["description"].field::Select($Field["system_name"],$UlArray , Foo_blocks_fields_1  ,array( "value" => $Data , "value_name"=>"name" , "class" => "form-control oxs_field_value") );	
		}
		
		function blocks_list($Field,$Data){
			Oxs::I("field");

			if(!Oxs::G("cheker")->Int($Data)){
				$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__blocks` WHERE `system_name` = 'oxs:sql'" , $Data );
				$Data = $R[0]["id"];
			}			

			//	Получаем список блоков
			$Tree=Oxs::L("DBTree",array("db" => Oxs::G("DBLIB.IDE")->DB() , "table" => "#__blocks"));

			function Foo_blocks_fields($DB,$Params){
				$DB->SetQ("SELECT * FROM (".($DB->GetQ()).") AS T WHERE `status` = '1' and `system_name` != 'ROOT'");
				return $DB;
			}

			$UlArray = $Tree->GetTreeEx(array( "Foo" => Foo_blocks_fields ));				

			if($Field["no_change"]) $attr = " disabled ";

			return $Field["description"].field::Select($Field["system_name"],$UlArray , null  ,array( "attr" => $attr , "value" => $Data , "value_name"=>"name" , "class" => "form-control oxs_field_value") );	 
		}

		function blocks_list_names($Field,$Data){
			Oxs::I("field");

			if(!Oxs::G("cheker")->Int($Data)){
				$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__blocks` WHERE `system_name` = 'oxs:sql'" , $Data );
				$Data = $R[0]["id"];
			}			

			//	Получаем список блоков
			$Tree=Oxs::L("DBTree",array("db" => Oxs::G("DBLIB.IDE")->DB() , "table" => "#__blocks"));

			function Foo_blocks_fields($DB,$Params){
				$DB->SetQ("SELECT * FROM (".($DB->GetQ()).") AS T WHERE `status` = '1' and `system_name` != 'ROOT'");
				return $DB;
			}

			$UlArray = $Tree->GetTreeEx(array( "Foo" => Foo_blocks_fields ));				

			if($Field["no_change"]) $attr = " disabled ";

			return $Field["description"].field::Select($Field["system_name"],$UlArray , null  ,array( "attr" => $attr , "value" => $Data , "value_name"=>"name" , "class" => "form-control oxs_field_value") );	 
		}
		
	}
 
