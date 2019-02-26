 <?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default.tree:fieldsTyps");

	class docs_fieldsTyps extends default_tree_fieldsTyps{
		
		function __construct($Path){	
			parent::__construct($Path);	
		}			

		function tags_selector($Field,$Data){
			return Oxs::G("doc_tags:fieldsTyps")->tags_selector($Field,$Data);
		}		
	}
 
