<?php

	define("OXS_PROTECT",TRUE);

	Oxs::I("filters.fill:add");
	
	class filters_fill_fix extends filters_fill_add{
		
		function __construct($Path){
			parent::__construct($Path);
		}		

	}