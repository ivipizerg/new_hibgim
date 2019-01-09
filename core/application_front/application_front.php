<?php

	if(!defined("OXS_PROTECT"))die("protect");

	class application_front extends SingleLib{

		private $Tpl;

		function __construct($_Path,$Params=null){
			parent::__construct($Path,$Params);
		}

		function Init(){
			//	Активируем защитную перменную
			define("OXS_CMS_PROTECT",true);
			//	Инициализиуем базу данных
			Oxs::G("DBLIB.IDE")->Init("cfg.php");	

			//	Менеджер языка	
			//	Указываем русский язык 
			Oxs::G("languagemanager")->SetLanguage("ru");		

			//	Глобальный часовой пояс с севрера
			Oxs::I("calendar");			
			Oxs::G("storage")->add("UTC",calendar::GetServerUtc());
		}

		function AjaxExec(){
			$this->Init();
		}

		function Run(){

			//	Защита вторизацией Если сайт закрыт на ремонт
			if( !Oxs::G("usermanager")->CurrentUser->IfAuth() && Oxs::G("setting_manager")->get("enable_site")!=1 ){				
				Oxs::G("templatemanager")->ChoiseTemplate( "auth" , array("mode" => "front") );
			}else{
				Oxs::G("templatemanager")->ChoiseDefaultTemplate("front");				
			}	

			echo Oxs::G("templatemanager")->ShowTemplate();	
			
			if(Oxs::G("setting_manager")->get("debug_mode")=="да" && Oxs::G("usermanager")->CurrentUser->IfAuth() ){
				echo Oxs::ShowLog();	
			}	
		}
	}

?>
