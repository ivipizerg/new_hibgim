<?php

if(!defined("OXS_CMS_PROTECT"))die("protect");

class autentificator_controller extends CoreSingleLib{	

	function __construct($Path){
		parent::__construct($Path);									
	}	

	function logOut($login,$password,$cookie=NULL){
		
		if(Oxs::G("usermanager")->CurrentUser->IfAuth()){
			Oxs::G("usermanager")->CurrentUser->logOut();
		}

		$this->SetAjaxCode(1);
	}	

	function TryLogin($login,$password,$cookie=NULL){
		
		if($cookie==NULL){
			$this->SetAjaxText(Oxs::G("languagemanager")->T("auth_error"));	
			$this->SetAjaxCode(0);
			return ;
		}

		//	Антиспам система
		if(!Oxs::G("autentificator.antispam")->Check($cookie)){
			$this->SetAjaxText(Oxs::G("languagemanager")->T("antispam_attention"));	
			$this->SetAjaxCode(0);
			return ;
		}

		//	Прошли антиспам регестрируем попытку авторизации
		Oxs::G("autentificator.antispam")->RegisterTry($cookie);

		if(Oxs::G("usermanager")->CheckPassword($login,$password) == 0){

			if(Oxs::G("logger")->Get("ERROR")!=NULL){							
				$this->SetAjaxText(Oxs::G("languagemanager")->T("auth_fatal_error") . "<br>" .Oxs::G("logger")->GetString("ERROR"));	
			}else{				
				$this->SetAjaxText(Oxs::G("languagemanager")->T("auth_error"));	
			}

			$this->SetAjaxCode(0);
			
		} else{			
			$this->SetAjaxText(Oxs::G("languagemanager")->T("auth_good"));	
			//	Тут мы прошли все защиты и пароль был верный, вобещм все ОК
			//	Подгружаем всю инфу и запихываем в текущего юзера
			Oxs::G("usermanager")->CurrentUser->SetData(Oxs::G("usermanager")->LoadUserData());
			//	Устанавлвиаем аутентификацию в 1
			Oxs::G("usermanager")->CurrentUser->SetAuth(1);
			//	Записываем в базу время входа юзера
			Oxs::G("usermanager")->CurrentUser->SaveEnterTime();
			$this->SetAjaxCode(1);
		}
	}
}

?>