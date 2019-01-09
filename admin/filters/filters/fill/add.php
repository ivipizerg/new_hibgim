<?php

	define("OXS_PROTECT",TRUE);

	class filters_fill_add extends CoreSingleLib{
		
		function __construct($Path){
			parent::__construct($Path);
		}

		function Exec($Command,& $Fields , & $Data){	
			$Fields["form_name"] = $Fields["form_name"]." (обязательно для заполнения)";	
		}

	}