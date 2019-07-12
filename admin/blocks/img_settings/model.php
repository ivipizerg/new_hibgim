<?php
		
	if(!defined("OXS_PROTECT"))die("protect");	

	class img_settings_model extends SingleLib{

		function __construct($Path,$params=null){			
			parent::__construct($Path,$params);
		}
		
		function get($name){
			$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__img_setting` WHERE `system_name` = 'oxs:sql'" , $name);
			if($R){
				return $R[0]["data"];
			}else{
				return null;
			}
		}
	}