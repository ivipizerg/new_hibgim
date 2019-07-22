<?php
	if(!defined("OXS_PROTECT"))die("protect");	

	class ckeditor extends CoreSingleLib{
		
		function __construct($Path,$params=null){
			parent::__construct($Path,$params);						
		}

		function getObject($Name){
			Oxs::RJ("crypto.base64");
			Oxs::G("dom")->loadJsOnce($this->Path."/ckeditor/ckeditor/ckeditor.js");
			Oxs::RJ("ckeditor:start",Array( $Name , Oxs::G("crypto.base64")->E( Oxs::G("dom")->getBase() )),"ckeditor_".$Name);
			Oxs::G("oxs_obj")->add("ckeditor_start");
		}
	}