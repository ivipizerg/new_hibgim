 <?php
	if(!defined("OXS_PROTECT"))die("protect");

	class default_fieldsTyps extends BlocksSingleLib{
		
		function __construct($Path){	
			parent::__construct($Path);	
		}

		function text($Field,$Data){			
			Oxs::I("field");	
			if($Field["no_change"]) $attr = " disabled ";
			return $Field["description"].field::Text($Field["system_name"],$Data,array( "attr"=>$attr , "class"=>"form-control oxs_field_value ".$Field["setting"]["class"] , "style" => "margin-top:3px;".$Field["field_style"] , "auto_clear" => $Field["form_name"]) );			
		}

		function textArea($Field,$Data){			
			Oxs::I("field");	
			if($Field["no_change"]) $attr = " disabled ";
			return $Field["description"].field::TextArea($Field["system_name"],$Data,array( "attr"=>$attr , "class"=>"form-control oxs_field_value" , "style" => "margin-top:3px; ".$Field["field_style"] ) );			
		}

		function checkbox($Field,$Data){
			Oxs::I("field");		
			if($Field["no_change"]) $attr = " disabled ";	
			return "<table style='padding:0px; margin:0px;'><tr><td valing=middle style='padding-top:2px;'>".field::Checkbox($Field["system_name"],$Data,array( "attr"=>$attr , "class"=>"form-check-input oxs_field_value" , "style" => "margin-top:0px;margin-right:10px;" ) )."</td><td valing=middle>".$Field["form_name"]."</td></tr></table><i>".$Field["description"]."</i>";				
		}

		function hidden($Field,$Data){			
			Oxs::I("field");	
			return field::hidden($Field["system_name"],$Data,array( "class"=>"oxs_field_value" ) );			
		}		

		function textarea_editor($Field,$Data){				
			Oxs::I("field");	
			if($Field["no_change"]) $attr = " disabled ";
			return $Field["description"].field::Text($Field["system_name"],$Data,array( "attr"=>$attr , "class"=>"form-control oxs_field_value" , "style" => "margin-top:3px;" , "auto_clear" => $Field["form_name"]) );		
		}

		function data($Field,$Data){
			return $Field["description"].field::Data($Field["system_name"],$Data,array( "config" => "
				changeMonth: true,
				changeYear: true,
				dateFormat: \"yy.mm.dd\"
				" , "attr"=>$attr , "class"=>"form-control oxs_field_value ".$Field["setting"]["class"] , "style" => "margin-top:3px;".$Field["field_style"] , "auto_clear" => $Field["form_name"]) );	
		}
	}
 
