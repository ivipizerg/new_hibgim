<?php

	if(!defined("OXS_PROTECT"))die("Wrong start point");

	class crypto_base64 extends SingleLib{	

		function __construct($_Path,$Params=null){
			parent::__construct($Path,$Params);			
		}	

		function E($text){
			return base64_encode($text);
		}

		function D($base64code){ 
			return base64_decode($base64code);
		}

	} 	
		