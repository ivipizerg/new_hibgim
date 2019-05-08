<?php

	define("OXS_PROTECT",TRUE);

	class files_manager_form extends CoreSingleLib{			

		function __construct($Path){
			parent::__construct($Path);
		}		
		

		//	Параметры
		//	dir - куда помещяем файлы 
		//	multy - *true/false - мультизагрузка файлов
		//	drag - *true/false - использовать драг дроп
		//	formats - разрешенные расширения для закачки( если не заполнить ничего закачено не будет)
		//	mime - типы для закачки( если не заполнить ничего закачено не будет)
		//	size - огранчиение размера(по умолчанию размер из php ini)	
		function formLoadFiles($Dir,$Params=null){

			//	Создаем окно
			$name = $Params["object_controller"] . "_" . uniqid();
			Oxs::G("js.window")->GetObject( $name );

			//	Диалог
			Oxs::I("dialog");
			$D = new _dialog($name);
			$D->Css("admin/tpl/default/css/dialog.css");
			$D->addHtml("<div class=oxs_dialog_load_files_zone><input ".$Params["multiple"]." class=oxs_dialog_load_files_zone_input type=file>".Oxs::G("languagemanager")->T("SELECT_FILE_TO_DOWNLOAD")."</div>");
			

			//	Создаем обьект для работы с файлами
			Oxs::G("js.dir2")->GetObject( "js_dir2" , array( "window_name" => "aj_auth" ));
			Oxs::G("oxs_obj")->add("js_dir2");

			//	Подгружаем интерфейс
			Oxs::G("oxs_obj")->G("crypto.base64");
			Oxs::G("oxs_obj")->G("files_manager.js:interface",array( 
				"notString:".$name,
				Oxs::G("crypto.base64")->E($D->build()),
				$Dir
			));

			return ;
		}

	}

?>
 
