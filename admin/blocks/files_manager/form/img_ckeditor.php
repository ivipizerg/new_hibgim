<?php

	define("OXS_PROTECT",TRUE);

	class files_manager_form_img_ckeditor extends BlocksSingleLib{			

		function __construct($Path){
			parent::__construct($Path);
		}	

		function innerArea($page,$search,$category_list = null,$class_img = "oxs_img_display_item"){
			
			if($class_img==null) $class_img = "oxs_img_display_item";

			$postsInPage = 24;			

			//	Если указан списко категорий то выбираем только указаныне категории
			if($category_list!=null){
				$category_list = implode(" , ",$category_list);
				$category_list = " `cat` IN (".$category_list.") "; 
			}

			if(empty($search) OR $search==-1 ){				
				if($category_list==null){
					Oxs::G("DBLIB.IDE")->DB()->AddQ("SELECT `#__img`.* , `#__img_cat`.`name` AS `cat_name` , `#__img_cat`.`path` AS `cat_path` FROM `#__img` , `#__img_cat` WHERE `#__img`.`cat` = `#__img_cat`.`id`" );	
					$All  = Oxs::G("DBLIB.IDE")->DB()->Exec();

					Oxs::G("DBLIB.IDE")->DB()->AddQ( "SELECT `#__img`.* , `#__img_cat`.`name` AS `cat_name` , `#__img_cat`.`path` AS `cat_path` FROM `#__img` , `#__img_cat` WHERE `#__img`.`cat` = `#__img_cat`.`id` ORDER BY `id` DESC LIMIT ".(($page*$postsInPage)-$postsInPage.",".($postsInPage)) );
					$R = Oxs::G("DBLIB.IDE")->DB()->Exec();
				}else{
					Oxs::G("DBLIB.IDE")->DB()->AddQ("SELECT `#__img`.* , `#__img_cat`.`name` AS `cat_name` , `#__img_cat`.`path` AS `cat_path` FROM `#__img` , `#__img_cat` WHERE `#__img`.`cat` = `#__img_cat`.`id` and ".$category_list );	
					$All  = Oxs::G("DBLIB.IDE")->DB()->Exec();

					Oxs::G("DBLIB.IDE")->DB()->AddQ( "SELECT `#__img`.* , `#__img_cat`.`name` AS `cat_name` , `#__img_cat`.`path` AS `cat_path` FROM `#__img` , `#__img_cat` WHERE `#__img`.`cat` = `#__img_cat`.`id` and ".$category_list." ORDER BY `id` DESC LIMIT ".(($page*$postsInPage)-$postsInPage.",".($postsInPage)) );
					$R = Oxs::G("DBLIB.IDE")->DB()->Exec();
				}				

			}else{				
				Oxs::G("DBLIB.IDE")->DB()->AddQ("SELECT `#__img`.* , `#__img_cat`.`name` AS `cat_name` , `#__img_cat`.`path` AS `cat_path` FROM `#__img` , `#__img_cat` WHERE `#__img`.`cat` = `#__img_cat`.`id` and `cat` = 'oxs:id'" , $search );	
				$All  = Oxs::G("DBLIB.IDE")->DB()->Exec();

				Oxs::G("DBLIB.IDE")->DB()->AddQ( "SELECT `#__img`.* , `#__img_cat`.`name` AS `cat_name` , `#__img_cat`.`path` AS `cat_path` FROM `#__img` , `#__img_cat` WHERE `#__img`.`cat` = `#__img_cat`.`id` and `cat` = 'oxs:id' ORDER BY `id` DESC LIMIT ".(($page*$postsInPage)-$postsInPage.",".($postsInPage)) , $search );
				$R = Oxs::G("DBLIB.IDE")->DB()->Exec();								
			}			

			
			if(!$All) $All = array("1");

			//	Вставялем разметку
			////////////////////////////////////////////////////////////
			$Nav = Oxs::L("navigation",array(
				"all"=>count($All),
				"interval"=> 5,
				"count"=> $postsInPage,
				"page"=> $page,
				"Foo" => function($i,$Data,$obj){
					return "<div class='oxs_my_navigation_item oxs_active oxs_active_style' data-route=\"".(Oxs::G("datablocks_manager")->RealCurrentBlockName).":display\">".$i."</div>";
				}
			));
			////////////////////////////////////////////////////////////


			if(!$R) return "<div class=oxs_img_add_box_inner >Ничего не найдено</div><div>".($Nav->show())."</div>";

			for($i=0;$i<count($R);$i++){
				
				$T .= "<div class='".$class_img."' data-file=\"".$R[$i]["file"]."\" data-id=\"".$R[$i]["id"]."\" style='cursor:pointer;margin:5px;display: inline-block; width:70px;height:70px;background-image: url(\"".$R[$i]["cat_path"]."/thumbs/".$R[$i]["file"]."\");background-size:cover;background-position: center center'></div>";;
			}
			////////////////////////////////////////////////////////////
			
			$this->setAjaxCode(2);
			
			return "".$T."<div>".($Nav->show())."</div>";
		}
		
		function get($name,$page,$search,$category_list = null,$class_img = "oxs_img_display_item"){	
			

			Oxs::G("templatemanager:css")->loadCss("file_manager","default");
			Oxs::G("templatemanager:css")->loadCss("file_manager","img");
			Oxs::G("templatemanager:css")->loadCss("dialog","main");	
			Oxs::G("dom")->LoadCssOnce("admin/tpl/default/css/main_table.css");

			$D = Oxs::L("dialog");
			$D->setName("dialog_" . $name);
		
			Oxs::G("storage")->add("filter_value",array( 
				"table" => "img_cat"
			));					

			$D->addHtml("<div class=oxs_img_add_box style=''><div class=oxs_img_add_box_cat>".(Oxs::G("default.tree:fieldsTyps")->cat_tree( array( "system_name" => "oxs_img_add_box_input" , "form_name" => "Категория" , "cat_list" => $category_list ,  "add_option" => array("name" => "Все категории" , "id" => -1 ) ),null))."</div><div class=oxs_img_add_box_inner>".($this->innerArea($page,$search,$category_list,$class_img))."</div></div>");
			echo $D->build();

			//////////////////////////////////////////////	
			Oxs::G("oxs_obj")->G("files_manager.js:img",array( 				
				$name				
			));	

			$this->setAjaxCode(1);
			return ;
		}

	}


				