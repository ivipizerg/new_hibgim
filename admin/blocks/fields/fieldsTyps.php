 <?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("blocks:fieldsTyps");
	
	class fields_fieldsTyps extends blocks_fieldsTyps{
		
		function __construct($Path){	
			parent::__construct($Path);	
		}		

		function fileds_type($Field,$Data){		
			Oxs::I("field");
			if($Field["no_change"]) $attr = " disabled ";	
			return $Field["description"].field::Select($Field["system_name"],array(
				array( "id" => "text" , "value" => "text" ),
				array( "id" => "tinytext" , "value" => "tinytext" ),
				array( "id" => "tinyint" , "value" => "tinyint" ),
				array( "id" => "int" , "value" => "int" ),
				array( "id" => "boolean" , "value" => "boolean" )
			) , NULL , array( "class"=>"form-control oxs_field_value" , "attr" => $attr , "value" => $Data) );
		}		
	}
 
