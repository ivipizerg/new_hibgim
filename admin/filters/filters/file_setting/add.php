<?php

	define("OXS_PROTECT",TRUE);

	class filters_file_setting_add extends CoreSingleLib{
		
		function __construct($Path){
			parent::__construct($Path);
		}

		function Exec($Command,& $Fields , & $Data){	

			//	Ищем параметрв 
			$format= trim(Oxs::G("filters_manager")->EjectValue($Command,"format")[0],"\"");			

			if($format!=NULL){				
				$Fields["file_setting"]["format"] = $format;
			}

			//	Ищем параметрв 
			$max_size= trim(Oxs::G("filters_manager")->EjectValue($Command,"max_size")[0],"\"");			

			if($max_size!=NULL){				
				$Fields["file_setting"]["max_size"] = $max_size;
			}

			$min_height= trim(Oxs::G("filters_manager")->EjectValue($Command,"min_height")[0],"\"");			

			if($min_height!=NULL){				
				$Fields["file_setting"]["min_height"] = $min_height;
			}

			$min_width= trim(Oxs::G("filters_manager")->EjectValue($Command,"min_width")[0],"\"");			

			if($min_width!=NULL){				
				$Fields["file_setting"]["min_width"] = $min_width;
			}

			$middle_height= trim(Oxs::G("filters_manager")->EjectValue($Command,"middle_height")[0],"\"");			

			if($middle_height!=NULL){				
				$Fields["file_setting"]["middle_height"] = $middle_height;
			}

			$middle_width= trim(Oxs::G("filters_manager")->EjectValue($Command,"middle_width")[0],"\"");			

			if($middle_width!=NULL){				
				$Fields["file_setting"]["middle_width"] = $middle_width;
			}

			$big_height= trim(Oxs::G("filters_manager")->EjectValue($Command,"big_height")[0],"\"");			

			if($big_height!=NULL){				
				$Fields["file_setting"]["big_height"] = $big_height;
			}

			$big_width= trim(Oxs::G("filters_manager")->EjectValue($Command,"big_width")[0],"\"");			

			if($big_width!=NULL){				
				$Fields["file_setting"]["big_width"] = $big_width;
			}
		}

	}