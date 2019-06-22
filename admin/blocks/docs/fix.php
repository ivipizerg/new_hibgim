<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:fix");

	class docs_fix extends default_fix{
		
		function __construct($Path){	
			parent::__construct($Path);					
		}	

		function loadMyCss(){
			Oxs::G("templatemanager:css")->loadCss("fields","docs");
			return ;
		}
		
		function Map(){
			return Oxs::G("docs:add")->Map();
		}				
	}