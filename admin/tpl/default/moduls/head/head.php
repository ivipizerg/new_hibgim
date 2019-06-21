<?php

	function head_modul($Param=NULL){		

		echo Oxs::G("dom")->ShowBase();	

		//	Подключаем необходимые билиотеки:
		echo Oxs::G("dom")->JQ();
		echo Oxs::G("dom")->BS();	
		echo Oxs::G("dom")->Ui();

		Oxs::G("dom")->LoadCSSOnce("admin/tpl/default/css/default.css");
		Oxs::G("dom")->LoadCssOnce("admin/tpl/default/css/block_head.css");
		Oxs::G("dom")->LoadCSSOnce("admin/tpl/default/css/message_window.css");				

		Oxs::G("dom")->LoadCssOnce("admin/tpl/default/css/main_table.css");
		Oxs::G("dom")->LoadCssOnce("admin/tpl/default/css/fields_table.css");			

		//	Создаем обьект истории	
		echo Oxs::G("js.history")->GetObject("H");	

		//	Создаем обьект для работы через аякс
		if(Oxs::G("setting_manager")->getOption("debug_mode")=="1"){
			echo Oxs::G("js.ajaxexec")->GetObject("aj_auth" , array( "start_code" => "application") );
		}else{
			echo Oxs::G("js.ajaxexec")->GetObject("aj_auth" , array( "log" => "off" , "start_code" => "application") );
		}	
		
		echo Oxs::G("js.ajaxexec")->GetObject("aj_no_log" , array( "log" => "off" , "start_code" => "application") );		

		//	Получаем URL и обрабатываем её
		//	Отсекаем все ненужное
		$Request = ltrim(str_replace( Oxs::GetRoot()."admin" , "", $_SERVER['REQUEST_URI']),"/");			

		//	Получаем параметры	
		if(empty($Request)){
			$MainAction = Oxs::G("datablocks_manager:model")->GetDefaultBlock();
		}else{
			$MainAction  = Oxs::G("url")->GetName($Request);	
		}	

		//	Кладем в хранилище так как дальше этой функции макйнЭкшн будет не доступен
		Oxs::G("storage")->add("MainAction",$MainAction);	
		
		//	Обьект хранилище, в нем будут храниться даныне в js фрагментах кода
		Oxs::G("ex_storage")->GetObject(null,"false");

		//	Система устанвоки событий
		Oxs::J("js.oxs_events");
		Oxs::G("js.loader")->GetObject("js.oxs_events",array("notString:false"),"oxs_events");	
		//	Система получения обьектов
		Oxs::G("oxs_obj")->Init(false);	

		echo Oxs::G("message_window")->Init();	
		
	}

?>
