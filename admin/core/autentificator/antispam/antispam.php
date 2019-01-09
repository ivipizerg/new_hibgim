<?php

if(!defined("OXS_CMS_PROTECT"))die("protect");

class autentificator_antispam extends CoreSingleLib{	

	function __construct($Path){
		parent::__construct($Path);										
	}	

	function RegisterTry($C){
		$CC = Oxs::L("calendar");		
		Oxs::G("DBLIB.IDE")->DB()->Insert("#__users_login_try",array(
			"ip" => $_SERVER['REMOTE_ADDR'],
			"cookie" => $C,
			"data_try" => $CC->get("getUnix")
		));	
	}

	function Check($C){

		//	Очищаем все записи старше 10 секунд
		Oxs::G("autentificator.antispam:controller")->ClearOldPost();
		
		//	Очищаем баны 
		Oxs::G("autentificator.antispam:controller")->ClearBans();

		//	Проверяем остались ли мы в бане
		if(Oxs::G("autentificator.antispam:controller")->CheckBan()){
			return false;
		}

		// Делаем выборку из базы записей с текущим ip 
		//	Если их больше 5 и время первого минус время последнего меньше 5 секунд
		//	Баним
		if(!Oxs::G("autentificator.antispam:controller")->CheckIp()){
			//echo "Не прошли ip";
			return false;
		}else if(!Oxs::G("autentificator.antispam:controller")->CheckCookie($C)){
			//echo "Не прошли rerb";
			return false;
		}

		return true;
	}

	
}

?>