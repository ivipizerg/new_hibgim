<?php

	define("OXS_PROTECT",TRUE);

	class filters_no_display_display extends CoreSingleLib{
		
		function __construct($Path){
			parent::__construct($Path);
		}

		function Exec($Command,& $Fields , & $Data){
			$Fields = null;;			
			return 0;
		}

	}