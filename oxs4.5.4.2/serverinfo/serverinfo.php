<?php

	if(!defined("OXS_PROTECT"))die("Wrong start point");

	class serverinfo extends SingleLib{

		function __construct($Path){

			parent::__construct($Path);

		}

		function GetOS(){
			if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			    return 1;
			} else {
			   	return 0;
			}
		}

	
	}
?>
