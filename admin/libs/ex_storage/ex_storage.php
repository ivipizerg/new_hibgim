<?php

	if(!defined("OXS_PROTECT"))die("protect");

	class ex_storage extends CoreSingleLib{	
		
		function __construct($_Path,$Params=null){
			parent::__construct($_Path,$Params);				
		}

		function GetObject($Name="ex_storage"){
			//	Нам необходим обычный сторадж из фреймворка
			echo Oxs::G("storage")->JS("storage","storage");
			$this->JS();			
		}
	}
?>
