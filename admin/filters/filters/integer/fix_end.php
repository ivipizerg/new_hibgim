<?php

	define("OXS_PROTECT",TRUE);

	Oxs::I("filters.integer:add_end");

	class filters_integer_fix_end extends filters_integer_add_end{
		
		function __construct($Path){
			parent::__construct($Path);
		}	

	}