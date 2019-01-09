<?php

	function head_modul($Param=NULL){		

		echo Oxs::G("dom")->ShowBase();	

		//	Подключаем необходимые билиотеки:
		echo Oxs::G("dom")->JQ();
		echo Oxs::G("dom")->BS();	

		Oxs::G("dom")->LoadCSSOnce("admin/tpl/auth/css/message_window.css");

		//	Создаем обьект истории	
		echo Oxs::G("js.history")->GetObject();	

		echo Oxs::G("js.ajaxexec")->GetObject("aj_auth" , array( "log" => "off" , "start_code" => "application") );		

		Oxs::G("message_window")->Init();	
	}

?>
