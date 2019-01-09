 <?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("blocks:fieldsTyps");
	
	class users_fieldsTyps extends blocks_fieldsTyps{
		
		function __construct($Path){	
			parent::__construct($Path);	
		}	

		function user_password($Field,$Data){			
			
			Oxs::I("field");	

			if(!empty($Data)) $Data=null;
			
			if($Field["no_change"]) $attr = " disabled ";
			return $Field["description"].field::Text($Field["system_name"],$Data,array( "attr"=>$attr , "class"=>"form-control oxs_field_value" , "style" => "margin-top:3px;" , "auto_clear" => $Field["form_name"]) );			
		}
		
	}
 
