<?php

	define("OXS_PROTECT",TRUE);

	class filters_show_level_add extends CoreSingleLib{
		
		function __construct($Path){
			parent::__construct($Path);
		}

		function Exec($Command,& $Fields , & $Data){			

			$Field_name = Oxs::G("filters_manager")->EjectValue($Command,"field")[0];
			
			if($Field_name==NULL){
				$this->Msg( Oxs::G("languagemanager")->T("noField" ),"ERROR.FILTER" );				
				return 0;
			}					

			$Correct = Oxs::G("filters_manager")->EjectValue($Command,"correct")[0];
			if($Correct==NULL)	$Correct = 0;
						
			Oxs::G("storage")->add("filters_show_level_add_field",$Field_name);
			Oxs::G("storage")->add("filters_show_level_add_correct",$Correct);
			
			return 0;
		}

	}