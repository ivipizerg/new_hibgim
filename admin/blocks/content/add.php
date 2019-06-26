<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:add");

	class content_add extends default_add{
		
		function __construct($Path,$params=null){
			parent::__construct($Path,$params);							
		}		
		
		function Map(){
			return "
				<oxs:text>
				<oxs:default>
			
			
			";
		}		
	}