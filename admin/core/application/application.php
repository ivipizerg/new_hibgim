<?php

	if(!defined("OXS_PROTECT"))die("protect");

	class application extends CoreSingleLib{
		
		private $HTML;			

		function __construct($Path,$params=null){
			parent::__construct($Path,$params);
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
		
			//	Защита вторизацией
			if(!Oxs::G("usermanager")->CurrentUser->IfAuth()){	
				Oxs::G("templatemanager")->ChoiseTemplate("auth");
			}else{
				Oxs::G("templatemanager")->ChoiseDefaultTemplate();	
			}

			echo Oxs::G("templatemanager")->ShowTemplate();	

			if(Oxs::G("setting_manager")->getOption("debug_mode")=="1" && Oxs::G("usermanager")->CurrentUser->IfAuth()){
				echo Oxs::ShowLog();	
			}	
		}
	}

?>
