<?php

	define("OXS_PROTECT",TRUE);

	class files_manager_form extends BlocksSingleLib{			

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
		function Exec(){

			$Dir = $this->getP("dir");
			$object =$this->getP("controller");			
			$name = $this->getP("name");

			//	Очищаем темп *сутки
			Oxs::G("file")->ClearOldFiles($Dir,60*60*24);				

			Oxs::G("BD")->Start();	

			Oxs::G("dom")->UI();		
			
			Oxs::G("templatemanager:css")->loadCss("file_manager","default");
			Oxs::G("templatemanager:css")->loadCss("dialog","main");		

			//	Выводим основу
			////////////////////////////////////////////////////////////
			echo "<div class='oxs_dialog_load_files_zone oxs_dialog_load_files_zone_".$name."' ><input ".$this->getP("multiple")." class=oxs_dialog_load_files_zone_input type=file><div class=oxs_dialog_load_files_zone_text>".Oxs::G("languagemanager")->T("SELECT_FILE_TO_DOWNLOAD")."</div></div>";	
			////////////////////////////////////////////////////////////

			//	Диалог для отображения прогресса
			//////////////////////////////////////////////

			$D = Oxs::L("dialog");
			$D->setName("dialog_" . $name);
			echo $D->build();

			//////////////////////////////////////////////

			//	Создаем обьект для работы с файлами
			Oxs::G("js.dir2")->GetObject( "js_dir2" , array( "window_name" => "aj_auth" ));
			Oxs::G("oxs_obj")->add("js_dir2");
			
			if(ini_get("post_max_size")>ini_get("upload_max_filesize")){
				$MAX_SIZE = ini_get("post_max_size"); 
			}else{
				$MAX_SIZE = ini_get("upload_max_filesize");
			}				
			
			Oxs::G("oxs_obj")->G("files_manager.js:interface",array( 				
				$name,
				$object,
				$Dir,
				array( 
					"DIR_IS_NOT_WRITABLE" => Oxs::G("message_window")->Error( Oxs::G("languagemanager")->T("DIR_IS_NOT_WRITABLE") ) ,
					"MAX_UPLOAD_COUNT" => Oxs::G("message_window")->Error( Oxs::G("languagemanager")->T("MAX_UPLOAD_COUNT" , ini_get("max_file_uploads")) )  , 
					"MAX_SIZE_FILE" => Oxs::G("message_window")->Error( Oxs::G("languagemanager")->T("MAX_SIZE_FILE" , $MAX_SIZE ) ),
					"DROP_CURSOR" =>  	Oxs::G("languagemanager")->T("DROP_CURSOR" ),
					"SELECT_FILE_TO_DOWNLOAD" => Oxs::G("languagemanager")->T("SELECT_FILE_TO_DOWNLOAD" ),
					"SUCCESS_UPLOAD" => Oxs::G("message_window")->Good( Oxs::G("languagemanager")->T("SUCCESS_UPLOAD" ) )
				)
			));			
			
			return ;
		}

	}


				