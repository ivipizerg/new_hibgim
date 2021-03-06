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

			preg_match('!\d+!', ini_get("post_max_size"), $matches);
			$post_max_size = $matches[0];

			preg_match('!\d+!', ini_get("upload_max_filesize"), $matches);
			$upload_max_filesize = $matches[0];

			if($post_max_size<$upload_max_filesize){
				$MAX_SIZE = $post_max_size;
			}else{
				$MAX_SIZE = $upload_max_filesize;
			}		

			$MU = $this->getP("MAX_UPLOAD");
			$MS = $this->getP("MAX_SIZE");

			if(empty($MU)) $MU = ini_get("max_file_uploads");
			if(empty($MS)) {
				$MS = $MAX_SIZE;
			}else{
				if($MS > $MAX_SIZE){
					$MS = $MAX_SIZE;
				}
			}

			$this->Msg($MS,"MESSAGE");

			//	Создаем обьект для работы с файлами
			Oxs::G("js.dir2")->GetObject( "js_dir2" , array( "window_name" => "aj_auth" , "MAX_UPLOAD" => $MU , "MAX_SIZE" => $MS ));
			Oxs::G("oxs_obj")->add("js_dir2");			

			Oxs::G("oxs_obj")->G("files_manager.js:interface",array( 				
				$name,
				$object,
				$Dir,
				array( 
					"DIR_IS_NOT_WRITABLE" => Oxs::G("message_window")->Error( Oxs::G("languagemanager")->T("DIR_IS_NOT_WRITABLE") ) ,
					"MAX_UPLOAD_COUNT" => Oxs::G("message_window")->Error( Oxs::G("languagemanager")->T("MAX_UPLOAD_COUNT" , $MU) )  , 
					"MAX_SIZE_FILE" => Oxs::G("message_window")->Error( Oxs::G("languagemanager")->T("MAX_SIZE_FILE" , ($MS)."Mb" ) ),
					"DROP_CURSOR" =>  	Oxs::G("languagemanager")->T("DROP_CURSOR" ),
					"SELECT_FILE_TO_DOWNLOAD" => Oxs::G("languagemanager")->T("SELECT_FILE_TO_DOWNLOAD" ),
					"SUCCESS_UPLOAD" => Oxs::G("message_window")->Good( Oxs::G("languagemanager")->T("SUCCESS_UPLOAD" ) )
				)
			));			
			
			return ;
		}

	}


				