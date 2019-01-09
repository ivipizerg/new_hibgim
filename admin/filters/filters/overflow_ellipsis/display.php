<?php

	define("OXS_PROTECT",TRUE);

	class filters_overflow_ellipsis_display extends CoreSingleLib{
		
		function __construct($Path){
			parent::__construct($Path);
		}

		function Exec($Command,& $Fields , & $Data){	

			//	Ищем параметрв ширина
			$Value= trim(Oxs::G("filters_manager")->EjectValue($Command,"v")[0],"\"");			

			if($Value==NULL){				
				$Value=80;
			}			

			for($i=0;$i<count($Data);$i++){				
				$Data[$i][ $Fields["system_name"]] = mb_strimwidth($Data[$i][ $Fields["system_name"]],0,$Value,"...");
			}	
			
			return 0;
		}

	}