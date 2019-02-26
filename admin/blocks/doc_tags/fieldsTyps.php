 <?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default.tree:fieldsTyps");

	class doc_tags_fieldsTyps extends default_tree_fieldsTyps{
		
		function __construct($Path){	
			parent::__construct($Path);	
		}		

		function tags_selector(){
			Oxs::G("js.loader")->GetObject("doc_tags.js:tag_selector");
			Oxs::G("templatemanager:css")->loadCss("fields","doc_tag_selector");
			return "<div></div>";
		}
	}
 
