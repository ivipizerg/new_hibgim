<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:add");

	class docs_add extends default_add{
		
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
				<table class=oxs_fields_table border=0><tr><td><div class=oxs_fields_table_wrap><oxs:files><oxs:death_time></div></td></tr></table>
			</td></tr></table>
			</center>
			";
		}		
	}