<?php

	define("OXS_PROTECT",TRUE);

	class files_manager_form_doc extends BlocksSingleLib{			

		function __construct($Path){
			parent::__construct($Path);
		}	

		
		function get($name,$page,$search){				

			$postsInPage = 25;

			Oxs::G("BD")->Start();				
			
			Oxs::G("templatemanager:css")->loadCss("file_manager","default");
			Oxs::G("templatemanager:css")->loadCss("file_manager","doc");
			Oxs::G("templatemanager:css")->loadCss("dialog","main");		


			//	получаем данные для заполнения
			$Data = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__docs` WHERE `status` = '1'  ORDER BY `position` DESC " ."LIMIT ".(($page*$postsInPage)-$postsInPage.",".($postsInPage)) . "" );

			for($i=0;$i<count($Data);$i++){
				$T .= "<div class=oxs_doc_add_item>".$Data[$i]["name"]."</div>";
			}
			 

			//	Диалог для отображения прогресса
			//////////////////////////////////////////////

			$D = Oxs::L("dialog");
			$D->setName("dialog_" . $name);
			$D->addHtml("<div class=oxs_doc_add_box style=''>".$T."</div>");
			echo $D->build();

			//////////////////////////////////////////////	

			Oxs::G("oxs_obj")->G("files_manager.js:doc",array( 				
				$name				
			));			
			$this->setAjaxCode(1);
			return ;
		}

	}


				