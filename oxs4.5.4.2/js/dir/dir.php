<?php

if(!defined("OXS_PROTECT"))die("Wrong start point");

class js_dir extends SingleLib{	

	function __construct($Path,$params=null){
		parent::__construct($Path,$params);			
	}

	
	function GetObject($Name="js_dir"){
		
		Oxs::GetLib("dom")->jQuery();		
		
		Oxs::GetLib("js.protector_ajax")->GetObject("dir_ajax");

		$Pr=Oxs::LoadLib("protector");
		$Pr->SetToken("js_protector_dir");

		Oxs::G("js.loader")->GetObject(
			"js.dir",
			array(
				"js_protector_dir",
				$Pr->GetToken("js_protector_dir"),
				Oxs::GetBack(),
				Oxs::GetRoot(),
				$this->Path,
				ini_get("post_max_size"),
				ini_get("upload_max_filesize"),
				ini_get("max_file_uploads")
			),
			$Name);
		
	}
}