<?php

	function head_modul($Param=NULL){		

		echo Oxs::G("dom")->ShowBase();	

		//	Подключаем необходимые билиотеки:
		echo Oxs::G("dom")->JQ();
		echo Oxs::G("dom")->BS();	
		echo Oxs::G("dom")->Ui();
		
		Oxs::G("dom")->loadCssOnce("admin/tpl/default/JS/superfishmenu/superfish.css");
		Oxs::G("dom")->loadCssOnce("admin/tpl/default/JS/superfishmenu/superfish-vertical.css");
		Oxs::G("dom")->LoadCSSOnce("admin/tpl/hibgim/css/default.css");	
		Oxs::G("dom")->LoadCSSOnce("admin/tpl/default/css/message_window.css");	

		//	Создаем обьект для работы через аякс
		if(Oxs::G("setting_manager")->getOption("debug_mode")=="1"){
			echo Oxs::G("js.ajaxexec")->GetObject("ajax" , array( "start_code" => "application_font") );
		}else{
			echo Oxs::G("js.ajaxexec")->GetObject("ajax" , array( "log" => "off" , "start_code" => "application_font") );
		}	
		
		echo Oxs::G("js.ajaxexec")->GetObject("ajax_log_off" , array( "log" => "off" , "start_code" => "application_font") );

		//	Система устанвоки событий
		Oxs::J("js.oxs_events");
		Oxs::G("js.loader")->GetObject("js.oxs_events",array("notString:false"),"oxs_events");

		echo Oxs::G("message_window")->Init();		
	}

?>
