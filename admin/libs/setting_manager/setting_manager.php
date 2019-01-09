<?php

	define("OXS_PROTECT",TRUE);

	class setting_manager extends CoreSingleLib{

		function __construct($Path){
			parent::__construct($Path);
		}

		function get($Name,$FilePriritet=true){
			
			if($FilePriritet){
				//	Если существует возвращаем, если нет возращаем null
				if(Oxs::G("cfg")->isExist($Name,"cfg.php"))
					return Oxs::G("cfg")->Get($Name,"cfg.php");
				else{
					
					$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT `value` FROM `#__settings` WHERE `system_name` = 'oxs:sql'" , $Name);
					if(!$R) 
							return null;
					else
						return $R[0]["value"];
				}
			}else{
				//	смотрим в базе данных, если там нет данных смотрим в файле
				$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT `value` FROM `#__settings` WHERE `system_name` = 'oxs:sql'" , $Name);
				
				if(!$R){
					if(Oxs::G("cfg")->isExist($Name,"cfg.php"))
						return Oxs::G("cfg")->Get($Name,"cfg.php");
					else
						return null;
				}else{
					return $R[0]["value"];
				}
			}
		}		
	}

?>
