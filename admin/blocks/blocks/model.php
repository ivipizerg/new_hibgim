<?php

	if(!defined("OXS_PROTECT"))die("protect");

	class blocks_model extends BlocksSingleLib{
		function __construct($Path){
			parent::__construct($Path);
		}

		function GetAboutBlockById($id){
			return Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__blocks` WHERE `id` ='oxs:int'" , $id);
		}

		function GetAboutBlockByName($name){
			return Oxs::GetLib("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__blocks` WHERE `system_name` ='oxs:sql'" , $name);
		}

	}


?>
