<?php

	define("OXS_PROTECT",TRUE);

	class filters_fill_add_end extends CoreSingleLib{
		
		function __construct($Path){
			parent::__construct($Path);
		}

		function Exec($Command,& $Fields , & $Data){			

			if(empty($Data[$Fields["system_name"]])){				
				$this->Msg(Oxs::G("languagemanager")->T( "notFill" , $Fields["name"] ),"ERROR.FILTER");	
			}			
			
			return 0;
		}

	}