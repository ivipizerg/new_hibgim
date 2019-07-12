<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:add");

	class news_add extends default_add{
		
		function __construct($Path,$params=null){
			parent::__construct($Path,$params);							
		}		

		function LoadFields(){
			
			$F = Oxs::G("fields:model")->GetFieldsForBlock();

			array_push($F, array(

				"system_name" => "create_data",		
				"type" => "data_time"	,				
				"description" => "Дата создания",	
				"form_name" => "Текущая"				

			));

			array_push($F, array(

				"system_name" => "update_data",		
				"type" => "data_time"	,				
				"description" => "Дата обновления",	
				"form_name" => "Текущая"			

			));

			return $F;
		}	
		
		function Map(){
			return "
				<div style='display:grid;grid-template-columns:auto 400px;grid-column-gap:10px;grid-row-gap:10px;margin-top:10px;'>				
				<div >
					<div style='display:grid;grid-template-columns:auto 300px;grid-column-gap:10px;grid-row-gap:10px;'> 
						<div><oxs:name></div> 
						<div style='padding-top:2px;'><oxs:cat></div></div>	
					<div style='padding-top:10px;'><oxs:text></div>
				</div>
				<div>
					<div style='margin-top:-22px;'><oxs:default></div>
					
				</div>
				</div>
			
			";
		}		
	}