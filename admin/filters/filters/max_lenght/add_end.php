<?php

	define("OXS_PROTECT",TRUE);

	class filters_max_lenght_add_end extends CoreSingleLib{
		
		function __construct($Path){
			parent::__construct($Path);
		}

		function Exec($Command,& $Fields , & $Data){			

			$V = Oxs::G("filters_manager")->EjectValue($Command,"v")[0];
			
			if($V==NULL){				
				$this->Msg( Oxs::G("languagemanager")->T("noV"),"ERROR.FILTER" );
				return 0;
			}else{		
				
				if(strlen($Data[$Fields["system_name"]])>$V){
					$this->Msg( Oxs::G("languagemanager")->T("soLongData",$Fields["name"],$V ),"ERROR.FILTER" );
				}
			}			
			
			return 0;
		}

	}