<?php
		
	if(!defined("OXS_PROTECT"))die("protect");

	//	Наследуемся от стандартного блока вывода
	Oxs::I("default:add");

	class blocks_add extends default_add{

		function __construct($Path,$params=null){			
			parent::__construct($Path,$params);
		}	

		function Map(){
			return "<table width = 1000 border = 0 class=oxs_fields_table>
				<tr>
					<td width=50%>
						<div class=oxs_fields_table_wrap><oxs:name></div>
					</td>
					<td>
						<div class=oxs_fields_table_wrap><oxs:section></div>
					</td>
				</tr>
				<tr>
					<td>
						<div class=oxs_fields_table_wrap><oxs:description></div>
					</td>
					<td>
						<div class=oxs_fields_table_wrap><oxs:access></div>
					</td>
				</tr>
				<tr>
					<td>
						<div class=oxs_fields_table_wrap><oxs:system_name></div>
					</td>
					<td>
						<div class=oxs_fields_table_wrap><oxs:defaultAction></div>
					</td>
				</tr>
				<tr>
					<td>
						<div class=oxs_fields_table_wrap><oxs:pid></div>
					</td>	
					<td>
						<div class=oxs_fields_table_wrap><oxs:type></div>
					</td>					
				</tr>
			</table>";
		}
		
	}