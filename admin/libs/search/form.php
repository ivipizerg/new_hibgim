<?php

	define("OXS_PROTECT",TRUE);

	class search_form extends CoreSingleLib{			

		function __construct($Path){
			parent::__construct($Path);
		}

		function getFotm($Param=null){
			Oxs::I("field");
			echo field::Text("oxs_search",null,array("auto_clear" => "Поиск" , "class" => "form-control" , "attr" => " data-route=".(Oxs::G("storage")->get("MainAction"))." " ));				
		}
	}

?>
 
