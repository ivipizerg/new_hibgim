<?php

	define("OXS_PROTECT",TRUE);

	class filters_test_display extends CoreSingleLib{
		
		function __construct($Path){
			parent::__construct($Path);
		}

		function Exec($Command,& $Fields , & $Data){	
			$Fields[0]["name"] = "Хуй";		
			return 0;
		}

	}