<?php

	define("OXS_PROTECT",TRUE);

	class filters_field_set_add extends CoreSingleLib{
		
		function __construct($Path){
			parent::__construct($Path);
		}

		function Exec($Command,& $Fields , & $Data){	

			//print_r($Command->Params);
			$T=Array();
			if($Command->Params)
			for($i=0;$i<@count($Command->Params);$i++){
				
				for($j=0;$j<@count($Command->Params[$i]);$j++){
					$T[$Command->Params[$i]->Name] = $Command->Params[$i]->Value[0];
				}					
			}			
					
			Oxs::G("storage")->add("filter_value",$T);						
		}
	}