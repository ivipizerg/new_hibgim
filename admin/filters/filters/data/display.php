<?php

	define("OXS_PROTECT",TRUE);

	class filters_data_display extends CoreSingleLib{
		
		function __construct($Path){
			parent::__construct($Path);
		}

		function Exec($Command,& $Fields , & $Data){			

			$m = Oxs::G("filters_manager")->EjectValue($Command,"m")[0];
			
			if($m==NULL){
				$this->Msg( Oxs::G("languagemanager")->T("noM" ),"ERROR.FILTER" );				
				return 0;
			}else{		
				
				if($m==1){
					for($i=0;$i<count($Data);$i++){
						$C = Oxs::L("calendar",$Data[$i][$Fields["system_name"]]);
						$Data[$i][$Fields["system_name"]] = $C->GetDataTime();
					}	
				}

				if($m==2){
					for($i=0;$i<count($Data);$i++){
						$C = Oxs::L("calendar",$Data[$i][$Fields["system_name"]]);
						$Data[$i][$Fields["system_name"]] = $C->GetDay(true)." ".calendar::SGetMountName($C->GetMount(),true)." ".$C->GetYear(); ;
					}	
				}
			}			
			
			return 0;
		}

	}