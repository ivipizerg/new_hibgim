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
			$field_name = "name";
			$table_name = "#__doc_tags";
			$search_fields =  Oxs::G("crypto.base64")->E(Oxs::G("JSON.IDE")->JSON()->E( Array("name") ));			

			//	Подключаем js обьект для работы с base64
			Oxs::G("oxs_obj")->G("crypto.base64");

			//	Обрабатываем Data
			//$D = Oxs::G("JSON.IDE")->JSON()->GetFromJSON($Data);
			$R = Oxs::G("DBLIB.IDE")->DB()->Exec( "SELECT * FROM `oxs:sql` WHERE `id` != '1' ORDER BY `position` ASC " , $table_name  );
			Oxs::G("BD")->Start();
			for($i=0;$i<count($R);$i++){
		      	echo "<div value = \"" . $R[$i]["id"] . "\" class=\"oxs_doc_tags_fieldsTyps_add_list_item_selected oxs_doc_tags_fieldsTyps_add_list_item_selected_" . $prefix . "\">" . $R[$i][$field_name] .  " ❌</div>";
		    } 

			//	Подклчюаем JS для обработки функционала			//	  префикс  
			Oxs::G("oxs_obj")->G( "doc_tags.js:tag_selector", array( array( "prefix" => $prefix , "data" => Oxs::G("crypto.base64")->E(Oxs::G("BD")->getEnd()) ,  "field_name" => $field_name , "table_name" => $table_name , "search_fields" => $search_fields ) ) , "oxs_doc_tags_fieldsTyps_".$prefix );		

			//	Подключаем нужый CSS
			Oxs::G("templatemanager:css")->loadCss("fields","doc_tag_selector");
			
			$Field["setting"]["class"] = "oxs_doc_tags_fieldsTyps_input oxs_doc_tags_fieldsTyps_input_".$prefix;

			return $Field["description"]."<div class='oxs_doc_tags_fieldsTyps oxs_doc_tags_fieldsTyps_".$prefix."'> ".(
				field::Text("edit_field_".$Field["system_name"],NULL,array("class"=>"form-control ".$Field["setting"]["class"] , "style" => "margin-top:3px;".$Field["field_style"] , "auto_clear" => $Field["form_name"]) ) .
				field::hidden($Field["system_name"],$Data,array( "class"=>"oxs_field_value" ) )
			)."</div><div class='oxs_doc_tags_fieldsTyps_add_list oxs_doc_tags_fieldsTyps_add_list_".$prefix."'  style='display:none;'>".Oxs::G("languagemanager")->T("loading")."</div>";
		}
	}
 
