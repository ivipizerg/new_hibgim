<?php

	define("OXS_PROTECT",TRUE);

	class filters_attr_display extends CoreSingleLib{
		
		function __construct($Path){
			parent::__construct($Path);
		}

		function Exec($Command,& $Fields , & $Data){	

			//	Подключаем js
			

			//	Ищем параметрв ширина
			$Value= trim(Oxs::G("filters_manager")->EjectValue($Command,"name")[0],"\"");			

			if($Value!=NULL){				
				$Fields["field_popup_description"] = $Value;
			}

			//	Ищем параметрв ширина
			$Value=NULL;
			$Value = trim(Oxs::G("filters_manager")->EjectValue($Command,"name")[0],"\"");			

			if($Value!=NULL){				
				$Fields["data_popup_description"] = $Value;
			}
		}

	}