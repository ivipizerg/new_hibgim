<?php

	define("OXS_PROTECT",TRUE);

	class search extends CoreSingleLib{			

		function __construct($Path){
			parent::__construct($Path);
		}

		function Init($Param=null){			
			Oxs::G("js.window")->GetObject("oxs_search_window");			
			Oxs::G("oxs_obj")->G("default.js.display:search");			
		}
	}

?>
 
