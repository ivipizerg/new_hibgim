<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:fix");

	class docs_fix extends default_fix{
		
		function __construct($Path){	
			parent::__construct($Path);					
		}	

		function loadMyCss(){
			Oxs::G("templatemanager:css")->loadCss("fields","docs");
			return ;
		}
		
		function Map(){
			return "
			<center>
			<table border=0><tr><td>
				<oxs:default>
			</td><td valign=top>
				<table class=oxs_fields_table border=0><tr><td><div class=oxs_fields_table_wrap><oxs:files></div></td></tr></table>
			</td></tr></table>
			</center>
			";
		}				
	}