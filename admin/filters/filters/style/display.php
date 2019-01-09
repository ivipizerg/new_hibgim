<?php

	define("OXS_PROTECT",TRUE);

	class filters_style_display extends CoreSingleLib{
		
		function __construct($Path){
			parent::__construct($Path);
		}

		function Exec($Command,& $Fields , & $Data){	

			//	Ищем параметрв ширина
			$Value= trim(Oxs::G("filters_manager")->EjectValue($Command,"f")[0],"\"");			

			if($Value!=NULL){				
				$Fields["field_style"] = $Value;
			}

			//	Ищем параметрв ширина
			$Value=NULL;
			$Value = trim(Oxs::G("filters_manager")->EjectValue($Command,"d")[0],"\"");			

			if($Value!=NULL){				
				$Fields["data_style"] = $Value;
			}
		}

	}