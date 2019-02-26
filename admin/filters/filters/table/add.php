<?php

	define("OXS_PROTECT",TRUE);

	class filters_table_add extends CoreSingleLib{
		
		function __construct($Path){
			parent::__construct($Path);
		}

		function Exec($Command,& $Fields , & $Data){	

			$Value= trim(Oxs::G("filters_manager")->EjectValue($Command,"v")[0],"\"");	
			
			if($Value!=NULL){				
				Oxs::G("storage")->add("filters_table_add_value",$Value);
			}			
		}
	}