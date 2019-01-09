<?php

if(!defined("OXS_CMS_PROTECT"))die("protect");

class autentificator_antispam_controller extends CoreSingleLib{	

	function __construct($Path){
		parent::__construct($Path);										
	}	

	function BanCurrentIP(){	
		$C = Oxs::L("calendar");	
		Oxs::G("DBLIB.IDE")->DB()->Insert("#__ip_bans",array(
			"ip" => $_SERVER['REMOTE_ADDR'],
			"dataunban" => $C->get("getUnix") + 60
		));		
	}

	function BanCurrentCookie($C){
		$CC = Oxs::L("calendar");	
		Oxs::G("DBLIB.IDE")->DB()->Insert("#__cookie_bans",array(
			"cookie" => $C,
			"dataunban" => $CC->get("getUnix") + 60
		));		
	}

	function ClearOldPost(){
		$C = Oxs::L("calendar");
		Oxs::G("DBLIB.IDE")->DB()->Exec("DELETE FROM `#__users_login_try` WHERE `data_try` < 'oxs:sql'" , ($C->get("getUnix")- 10) );		
	}

	function ClearBans(){
		$C = Oxs::L("calendar");
		Oxs::G("DBLIB.IDE")->DB()->Exec("DELETE FROM `#__ip_bans` WHERE `dataunban` <= 'oxs:sql'",$C->get("getUnix"));		
	}

	function CheckBan(){
		$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__ip_bans` WHERE `ip` = 'oxs:sql'" , $_SERVER['REMOTE_ADDR']);
		if($R) return true;
		else return false;
	}

	function CheckIp(){
		// Делаем выборку из базы записей с текущим ip 
		//	Если их больше 5 и время первого минус время последнего меньше 5 секунд
		//	Баним
		$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__users_login_try` WHERE `ip` = 'oxs:sql'" , $_SERVER['REMOTE_ADDR']);	

		//	Записей нет возвращаем тру можно логиниться
		if(!$R) return true;
		else{

			if(count($R)>5){
				//	Записей больше
				$this->BanCurrentIP();
				return false;
			}else 
				//	Записей меньеш 5 разрешаем логиниться
				return true;
		}
	}

	function CheckCookie($C){
		// Делаем выборку из базы записей с текущим ip 
		//	Если их больше 5 и время первого минус время последнего меньше 5 секунд
		//	Баним
		$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__users_login_try` WHERE `cookie` = 'oxs:sql'" , $C);	

		//	Записей нет возвращаем тру можно логиниться
		if(!$R) return true;
		else{

			if(count($R)>5){
				//	Записей больше
				$this->BanCurrentCookie($C);
				return false;
			}else 
				//	Записей меньеш 5 разрешаем логиниться
				return true;
		}
		return true;
	}
	
}

?>