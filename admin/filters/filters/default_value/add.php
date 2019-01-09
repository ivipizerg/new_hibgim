<?php

	define("OXS_PROTECT",TRUE);

	class filters_default_value_add extends CoreSingleLib{
		
		function __construct($Path){
			parent::__construct($Path);
		}

		function Exec($Command,& $Fields , & $Data){	
			
			$V = Oxs::G("filters_manager")->EjectValue($Command,"v")[0];
			
			if($V==NULL){
				$this->Msg("Не найден параметр v" , "ERROR");
				return 0;
			}			

			$Data[$Fields["system_name"]] = $V;

			return 0;
		}

	}