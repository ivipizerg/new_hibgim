<?php
	if(!defined("OXS_PROTECT"))die("protect");	

	class tinymce extends CoreSingleLib{
		
		function __construct($Path,$params=null){
			parent::__construct($Path,$params);						
		}

		function getObject($Name){
			Oxs::G("dom")->loadJsOnce($this->Path."/tinymce/tinymce.js");
			Oxs::RJ("tinymce:tinymce_start",$Name);
		}
	}