<?php

	define("OXS_PROTECT",TRUE);

	Oxs::G("filters.file_setting:add");

	class filters_file_setting_fix_end extends filters_file_setting_add{
		
		function __construct($Path){
			parent::__construct($Path);
		}		

	}