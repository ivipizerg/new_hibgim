 <?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default.tree:fieldsTyps");

	class docs_fieldsTyps extends default_tree_fieldsTyps{
		
		function __construct($Path){	
			parent::__construct($Path);	
		}			

		function tags_selector($Field,$Data){
			return Oxs::G("doc_tags:fieldsTyps")->tags_selector($Field,$Data);
		}

		function files_board($Field,$Data){

			Oxs::G("BD")->Start();

			//	Необходим для сортировки
			Oxs::G("dom")->UI();
			Oxs::J("JSON:json",null,"json");

			//	обработчик клика
			Oxs::G("oxs_obj")->G("docs.js:docs_files_events", array( 
				array( 
					"upDown" => Oxs::G("templatemanager:img")->load("file_manager","up_dpwn.png"),
					"close" => Oxs::G("templatemanager:img")->load("file_manager","close.jpg")  ,
					"Data" => addslashes ($Data)
				) ,
				array(
					"FILE_DELETE_SUCCESS" => Oxs::G("message_window")->Good(Oxs::G("languagemanager")->T("FILE_DELETE_SUCCESS")),
					"FILE_DELETE_FAIL" => Oxs::G("message_window")->Error(Oxs::G("languagemanager")->T("FILE_DELETE_FAIL"))
				)
			));			

			return Oxs::G("BD")->getEnd().$Field["description"]."<div class=files_board_tmp_zone></div>
			<div class=docs_files_board_main>
				<div class=docs_files_board_add_files>Добавить файл</div>
				<div class=docs_files_board_add_files_sortable></div>
			</div>";
		}	
	}
 
