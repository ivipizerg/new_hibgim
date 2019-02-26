<?php

	define("OXS_PROTECT",TRUE);

	class filters_rename_root_display extends CoreSingleLib{
		
		function __construct($Path){
			parent::__construct($Path);
		}

		function Exec($Command,& $Fields , & $Data){	

			$Value = Oxs::G("filters_manager")->EjectValue($Command,"v")[0];
			$field = Oxs::G("filters_manager")->EjectValue($Command,"f")[0];			
			
			if($field==NULL){
				$field="name";
			}					

			for($i=0;$i<count($Data);$i++){				
				if($Data[$i]["id"]==1){
					if(!empty($Value))$Data[$i][$field] = $Value;
					else $Data[$i]=NULL;		
				}
			}	
			
			return 0;
		}

	}