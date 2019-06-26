 <?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:fieldsTyps");

	class content_fieldsTyps extends default_fieldsTyps{
		
		function __construct($Path){	
			parent::__construct($Path);	
		}			
	}
 
