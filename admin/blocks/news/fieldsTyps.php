 <?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:fieldsTyps");

	class news_fieldsTyps extends default_fieldsTyps{
		
		function __construct($Path){	
			parent::__construct($Path);	
		}	

		function cat_tree($Field,$Data){
			return Oxs::G("default.tree:fieldsTyps")->cat_tree($Field,$Data);
		}		
	}
 
