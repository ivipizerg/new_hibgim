<?php

	define("OXS_PROTECT",TRUE);

	class files_manager_form_img extends BlocksSingleLib{			

		function __construct($Path){
			parent::__construct($Path);
		}			

		function get($name){

			$D = Oxs::L("dialog");
			$D->setName("dialog_" . $name."_img");			

			//	Так как форма была оформлена как блок даных вызываем её как блок данных
			//////////////////////////////////////////////////////////////////////
			Oxs::G("datablocks_manager")->Params=Array();
			$this->setP("dir","files/tmp");												//	куда грузим
			$this->setP("multiple","multiple");											//	мультивыбор
			$this->setP("controller","img_js_add");										//	обьект обработчик событий
			$this->setP("name",$name);													//	имя формы(должно быть уникально)
			$this->setP("MAX_UPLOAD",Oxs::G("img_settings:model")->get("max_count"));	//	Кодичестов файлов
			$this->setP("MAX_SIZE",Oxs::G("img_settings:model")->get("max_size"));		//	Размерфайла

			Oxs::G("BD")->Start();

			$Field = Array( "system_name" => "cat" );			
			Oxs::G("storage")->add("filter_value",array( 
				"table" => "img_cat",
				"id" => 4
			));

			Oxs::G("templatemanager:css")->loadCss("file_manager","default");
			Oxs::G("templatemanager:css")->loadCss("dialog","main");		

			echo $D->build();
			echo Oxs::G("files_manager:form")->Exec();	
			///////////////////////////////////////////////////////////////////////		

			$this->setAjaxData("form" , Oxs::G("BD")->getEnd() );
			$this->setAjaxData("select" , Oxs::G("default.tree:fieldsTyps")->cat_childs($Field,null) );
			
			$this->setAjaxCode(1);
			return ;
		}
	}


				