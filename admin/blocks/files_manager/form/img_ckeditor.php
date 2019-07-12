<?php

	define("OXS_PROTECT",TRUE);

	class files_manager_form_img_ckeditor extends BlocksSingleLib{			

		function __construct($Path){
			parent::__construct($Path);
		}	

		function innerArea($page,$search){
			
			$postsInPage = 25;			

			$S = Oxs::L("sqlsearch");
			
			Oxs::G("DBLIB.IDE")->DB()->AddQ("SELECT * FROM `#__docs` WHERE `status` = '1'" );
			$DB = $S->search(Oxs::G("DBLIB.IDE")->DB(),$search,array("name","desc","files"));	
			$DB1 = clone($DB);		
			$All  = $DB->Exec();

			$DB1->AddQ( " LIMIT ".(($page*$postsInPage)-$postsInPage.",".($postsInPage)) );
			$Data = $DB1->Exec();

			if(!$All) $All = array("1");

			//	Вставялем разметку
			////////////////////////////////////////////////////////////
			$Nav = Oxs::L("navigation",array(
				"all"=>count($All),
				"interval"=> 5,
				"count"=> $postsInPage,
				"page"=> $page
			));
			////////////////////////////////////////////////////////////


			if(!$Data) return "<div class=oxs_doc_add_box_inner >Ничего не найдено</div><div>".($Nav->show())."</div>";

			for($i=0;$i<count($Data);$i++){

				$Fiels = Oxs::G("JSON.IDE")->JSON()->D($Data[$i]["files"]);				
				$F="";
				for($j=0;$j<count($Fiels);$j++){
					$F .= $Fiels[$j]->name.",";
				}
				$F = rtrim($F,",");
				
				$T .= "<div class=oxs_doc_add_item><div class=oxs_doc_add_item_name data-id=".$Data[$i]["id"].">".$Data[$i]["name"]."</div><div class=oxs_doc_add_item_files>".$F."</div></div>";
			}
			////////////////////////////////////////////////////////////
			
			$this->setAjaxCode(2);
			
			return "<div class=oxs_doc_add_box_inner >".$T."</div><div>".($Nav->show())."</div>";
		}
		
		function get($name,$page,$search){							
			
			Oxs::G("templatemanager:css")->loadCss("file_manager","default");
			Oxs::G("templatemanager:css")->loadCss("file_manager","img");
			Oxs::G("templatemanager:css")->loadCss("dialog","main");		

			$D = Oxs::L("dialog");
			$D->setName("dialog_" . $name);
			$D->addHtml("<div class=oxs_img_add_box style=''><div class=oxs_img_add_box_cat>".(Oxs::G("default:fieldsTyps")->text( array( "system_name" => "oxs_img_add_box_input" , "form_name" => "Категория" ),null))."</div><div classoxs_img_add_box_inner>".($this->innerArea($page,$search))."</div></div>");
			echo $D->build();

			//////////////////////////////////////////////	

			Oxs::G("oxs_obj")->G("files_manager.js:img",array( 				
				$name				
			));	

			$this->setAjaxCode(1);
			return ;
		}

	}


				