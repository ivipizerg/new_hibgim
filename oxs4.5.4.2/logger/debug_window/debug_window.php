<?php

	if(!defined("OXS_PROTECT"))die("Wrong start point");

	class logger_debug_window extends SingleLib{

		function __construct($Path,$params=null){
			parent::__construct($Path,$params);
		}

		function Init($Name,$Header=null){				

			$WinObj = "winobj_" . $Name;
			$logWinObj = "logwinobj_" . $Name;
			
			Oxs::GetLib("js.window")->GetObject($WinObj);
			Oxs::G("logger")->Css();

			Oxs::G("js.loader")->GetObject( "logger.debug_window", array ( $Name , $Header ), $logWinObj );	

			return $logWinObj;
		}				

	}
