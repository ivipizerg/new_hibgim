<?php
		
	if(!defined("OXS_PROTECT"))die("protect");	

	class doc_settings_model extends SingleLib{

		function __construct($Path,$params=null){			
			parent::__construct($Path,$params);
		}
		
		function get($name){
			$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__doc_settings` WHERE `system_name` = 'oxs:sql'" , $name);
			if($R){
				return $R[0]["meta"];
			}else{
				return null;
			}
		}
	}