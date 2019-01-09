<?php

	define("OXS_PROTECT",TRUE);

	class filters_no_change_fix extends CoreSingleLib{
		
		function __construct($Path){
			parent::__construct($Path);
		}

		function Exec($Command,& $Fields , & $Data){	
			
			$Fields["no_change"] = true;
			
			return 0;
		}

	}