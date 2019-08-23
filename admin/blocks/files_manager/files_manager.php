<?php

	define("OXS_PROTECT",TRUE);

	class files_manager extends BlocksSingleLib{			

		function __construct($Path){
			parent::__construct($Path);
		}		

		function ajaxExec($Param){

			switch($Param["action"]){
				case "get_form" :
					switch($Param["type"]){
						case "doc_add_ckeditor":
							return Oxs::G("files_manager.form:doc")->get($Param["name"],$Param["page"],$Param["search"]);
						break;
						case "doc_add_search":
							echo  Oxs::G("files_manager.form:doc")->innerArea($Param["page"],$Param["search"]);
						break;

						

						case "img_add":
							return Oxs::G("files_manager.form:img")->get($Param["name"]);
						break;
						case "img_add_search":
							echo  Oxs::G("files_manager.form:img_ckeditor")->innerArea($Param["page"],$Param["search"],$Param["category_list"],$Param["class_img"]);
						break;

						case "img_add_ckeditor":							
							return  Oxs::G("files_manager.form:img_ckeditor")->get($Param["name"],$Param["page"],$Param["search"],$Param["category_list"],$Param["class_img"]);
						break;

						default: $this->setAjaxCode(-2);
					}
				break;
				default: $this->setAjaxCode(-1);
			}	
		}
	}

?>
 
