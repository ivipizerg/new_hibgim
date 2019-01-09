<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:fix_end");

	class users_fix_end extends default_fix_end{	

		function __construct($Path){	
			parent::__construct($Path);			
		}		

		function ExecBefore(& $Params=null){
			
			//	шифруем пароль			
			$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__users` WHERE `id` = 'oxs:id'" , $Params["fixingId"])[0];

			if(empty($Params["data"]["password"])){
				$Params["data"]["password"] = $R["password"];
			}else{
				$Params["data"]["password"] = sha1($Params["data"]["password"]);

			}

			parent::ExecBefore($Params);	
		}		
			
	}