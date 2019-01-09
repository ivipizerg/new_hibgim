<?php

	define("OXS_PROTECT",TRUE);

	class filters_integer_add_end extends CoreSingleLib{
		
		function __construct($Path){
			parent::__construct($Path);
		}

		function Exec($Command,& $Fields , & $Data){			

			if(!Oxs::G("cheker")->Int($Data[$Fields["system_name"]])){
				$this->SetAjaxCode(-1);				
				$this->SetAjaxText( Oxs::G("languagemanager")->T( "notInteger" , $Fields["name"] ) );
			}			

			$min = Oxs::G("filters_manager")->EjectValue($Command,"min")[0];
			if(empty($min))	{
				$min = 0;
				if($Data[$Fields["system_name"]]<$min){
					$this->SetAjaxCode(-1);				
					$this->SetAjaxText( Oxs::G("languagemanager")->T( "integerSoSmal" , $Fields["name"] ) );
				}	
			}			

			$max = Oxs::G("filters_manager")->EjectValue($Command,"max")[0];
		
			if($max!=NULL){
				if($Data[$Fields["system_name"]]>$max){
					$this->SetAjaxCode(-1);				
					$this->SetAjaxText( Oxs::G("languagemanager")->T( "integerSoBig" , $Fields["name"] ) );
				}				
			}
			
			return 0;
		}

	}