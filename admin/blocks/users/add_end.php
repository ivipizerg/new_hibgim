
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:add_end");

	class users_add_end extends default_add_end{	

		function __construct($Path){	
			parent::__construct($Path);			
		}		
		
		function Exec(& $Params=null){			

			//	шифруем пароль
			$Params["data"]["password"] = sha1($Params["data"]["password"]);

			parent::Exec($Params);			
		}		
	}