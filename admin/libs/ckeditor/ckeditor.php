<?php
	if(!defined("OXS_PROTECT"))die("protect");	

	class ckeditor extends CoreSingleLib{
		
		function __construct($Path,$params=null){
			parent::__construct($Path,$params);						
		}

		function getObject($Name){			
			Oxs::G("dom")->loadJsOnce($this->Path."/ckeditor/ckeditor/ckeditor.js");
			Oxs::RJ("ckeditor:start",$Name,"ckeditor_".$Name);
			Oxs::G("oxs_obj")->add("ckeditor_start");
		}
	}