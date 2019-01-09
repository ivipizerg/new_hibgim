<?php

	if(!defined("OXS_PROTECT"))die("Wrong start point");

	class storage extends SingleLib{		

		private $Data;

		function __construct($Path,$Params=null){
			parent::__construct($Path,$Params);
		}

		function add($Name,$Value,$rewrite=false){
			if(!isset($this->Data[$Name]))
				$this->Data[$Name] = $Value;
			else
				if($rewrite)
					$this->Data[$Name] = $Value;
		}

		function get($Name){			
			return $this->Data[$Name];
		}
		

	}
