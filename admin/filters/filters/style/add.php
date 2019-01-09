<?php

	define("OXS_PROTECT",TRUE);

	class filters_style_add extends CoreSingleLib{
		
		function __construct($Path){
			parent::__construct($Path);
		}

		function Exec($Command,& $Fields , & $Data){	
			
			$Value= trim(Oxs::G("filters_manager")->EjectValue($Command,"v")[0],"\"");			
			$Fields["field_style"] = $Value;

			if($Value!=NULL){				
				$Fields["field_style"] = $Value;
			}			
		}
	}