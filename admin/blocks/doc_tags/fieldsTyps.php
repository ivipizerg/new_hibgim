 <?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default.tree:fieldsTyps");

	class doc_tags_fieldsTyps extends default_tree_fieldsTyps{
		
		function __construct($Path){	
			parent::__construct($Path);	
		}		

		function tags_selector($Field,$Data){
			
			//	генерируем уникальный префикс обьекта
			$prefix = $Field["system_name"];

			//	Подклчюаем JS для обработки функционала			//	  префикс  
			Oxs::G("oxs_obj")->G( "doc_tags.js:tag_selector", array( $prefix ) , "oxs_doc_tags_fieldsTyps_".$prefix );
			
			//	Создаем обьект для AJAX
			Oxs::G("js.ajaxexec")->GetObject( "oxs_doc_tags_fieldsTyps_ajax_exec_".$prefix , array( "log" => "on" , "start_code" => "application") );			
			Oxs::G("oxs_obj")->add("oxs_doc_tags_fieldsTyps_ajax_exec_".$prefix );		

			//	Подключаем нужый CSS
			Oxs::G("templatemanager:css")->loadCss("fields","doc_tag_selector");
			
			return $Field["description"]."<div contenteditable=\"true\" class='oxs_doc_tags_fieldsTyps oxs_doc_tags_fieldsTyps_".$prefix."'>						
			</div><div class='oxs_doc_tags_fieldsTyps_add_list oxs_doc_tags_fieldsTyps_add_list_".$prefix."'  style='display:none;'>".Oxs::G("languagemanager")->T("loading")."</div>";
		}
	}
 
