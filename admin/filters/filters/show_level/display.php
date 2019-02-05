<?php

	define("OXS_PROTECT",TRUE);

	class filters_show_level_display extends CoreSingleLib{
		
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

			for($i=0;$i<count($Data);$i++){				
				$Data[$i]["name"] = " ".$Data[$i]["name"];			
				for($j=0;$j<($Data[$i][$Field_name] + $Correct);$j++){
					$Data[$i]["name"] = "―".$Data[$i]["name"];
				}	

				$Data[$i]["name"] = $Data[$i]["name"];	

			}
			
			return 0;
		}

	}