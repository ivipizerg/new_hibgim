<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:fix");

	class content_fix extends default_fix{
		
		function __construct($Path,$params=null){
			parent::__construct($Path,$params);							
		}		

		function LoadFields(){	
			return Oxs::G("content:add")->LoadFields() ;
		}	

		function GetData(){
			$Data = parent::GetData();
			$Data[0]["update_data"]="";	
			return $Data;
		}
		
		function Map(){
			return Oxs::G("content:add")->Map();
		}		
	}