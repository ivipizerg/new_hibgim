<?php

	if(!defined("OXS_PROTECT"))die("Wrong start point");

	class JSON_IDE extends SingleLib{

		private $JSON;

		function __construct($Path){
			parent::__construct($Path);
			$this->JSON = Oxs::LoadLib("JSON");
		}

		function JSON(){
			return $this->JSON;
		}

	}

?>
