<?php

	define("OXS_PROTECT",TRUE);

	class filters_boolean_display extends CoreSingleLib{
		
		function __construct($Path){
			parent::__construct($Path);
		}

		function Exec($Command,& $Fields , & $Data){	
			
			$Mode = Oxs::G("filters_manager")->EjectValue($Command,"mode")[0];
			
			if($Mode==NULL){
				$this->Msg("Не найден параметр mode" , "ERROR");
				return 0;
			}			

			for($i=0;$i<count($Data);$i++){				
				
				if($Mode==1){
					if($Data[$i][$Fields["system_name"]]=="1"){
						$Data[$i][$Fields["system_name"]] = Oxs::G("languagemanager")->T("yes");
					}else{
						$Data[$i][$Fields["system_name"]] = Oxs::G("languagemanager")->T("no");
					}
				}
			}
			return 0;
		}

	}