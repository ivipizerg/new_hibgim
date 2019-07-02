<?php

	define("OXS_PROTECT",TRUE);

	class files_manager extends CoreSingleLib{			

		function __construct($Path){
			parent::__construct($Path);
		}
		

		function ajaxExec($Param){

			switch($Param["action"]){
				case "get_form" :
					switch($Param["type"]){
						case "doc_add":
							return Oxs::G("files_manager.form:doc")->get($Param["name"],$Param["page"],$Param["search"]);
						break;
						default: $this->setAjaxCode(-1);
					}
				break;
				default: $this->setAjaxCode(-1);
			}	
		}
	}

?>
 
