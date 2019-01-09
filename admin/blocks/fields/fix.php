<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::G("default:fix");
	
	class fields_fix extends default_fix{
		
		function __construct($Path){	
			parent::__construct($Path);					
		}	

		function Map(){
			return Oxs::G("fields:add")->Map();
		}
		
		function ExecBefore(& $Param=null){
			parent::ExecBefore($Param);			
		}		
		
	}