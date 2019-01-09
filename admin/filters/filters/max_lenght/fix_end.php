<?php

	define("OXS_PROTECT",TRUE);

	Oxs::I("filters.max_lenght:add_end");

	class filters_max_lenght_fix_end extends filters_max_lenght_add_end{
		
		function __construct($Path){
			parent::__construct($Path);
		}			

	}