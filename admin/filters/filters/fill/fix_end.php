<?php

	define("OXS_PROTECT",TRUE);

	Oxs::I("filters.fill:add_end");

	class filters_fill_fix_end extends filters_fill_add_end{
		
		function __construct($Path){
			parent::__construct($Path);
		}	

	}