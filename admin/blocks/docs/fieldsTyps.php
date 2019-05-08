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

			//	обработчик клика
			Oxs::G("oxs_obj")->G("docs.js:docs_files_events");

			return $Field["description"]."<div class=files_board_tmp_zone></div><div class=docs_files_board_main>
			".$FilesContent."
			<div class=docs_files_board_add_files>Добавить файл</div>
			</div>";
		}	
	}
 
