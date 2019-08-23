<?php

	if(!defined("OXS_PROTECT"))die("protect");

	class events extends SingleLib{

		private $Tpl;

		function __construct($_Path,$Params=null){
			parent::__construct($Path,$Params);
		}

		function showEvents($type="all",$page=1){

			

			return "События";
		}
	}

?>
