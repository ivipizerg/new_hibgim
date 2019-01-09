<?php

if(!defined("OXS_PROTECT"))die("Wrong start point");

class js_history extends SingleLib{

	function __construct($Path,$params=null){
		parent::__construct($Path,$params);
	}

	function GetObject($Name="oxs_history"){

		if($Name=="history"){
			$this->Msg("ЗАпрещенное имя","ERROR");
		}	
		
		Oxs::GetLib("js.loader")->GetObject("js.history",array( str_replace("index.php","","/".Oxs::GetRoot()) ),$Name);
	}
}
