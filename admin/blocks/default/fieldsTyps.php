 <?php
	if(!defined("OXS_PROTECT"))die("protect");

	class default_fieldsTyps extends BlocksSingleLib{
		
		function __construct($Path){	
			parent::__construct($Path);	
		}

		function text($Field,$Data){			
			Oxs::I("field");	
			if($Field["no_change"]) $attr = " disabled ";
			return $Field["description"].field::Text($Field["system_name"],$Data,array( "attr"=>$attr , "class"=>"form-control oxs_field_value ".$Field["setting"]["class"] , "style" => "margin-top:3px;".$Field["field_style"] , "auto_clear" => $Field["form_name"]) );			
		}

		function textArea($Field,$Data){			
			Oxs::I("field");	
			if($Field["no_change"]) $attr = " disabled ";
			return $Field["description"].field::TextArea($Field["system_name"],$Data,array( "attr"=>$attr , "class"=>"form-control oxs_field_value" , "style" => "margin-top:3px; ".$Field["field_style"] ) );			
		}

		function checkbox($Field,$Data){
			Oxs::I("field");		
			if($Field["no_change"]) $attr = " disabled ";	
			return "<table style='padding:0px; margin:0px;'><tr><td valing=middle style='padding-top:2px;'>".field::Checkbox($Field["system_name"],$Data,array( "attr"=>$attr , "class"=>"form-check-input oxs_field_value" , "style" => "margin-top:0px;margin-right:10px;" ) )."</td><td valing=middle>".$Field["form_name"]."</td></tr></table><i>".$Field["description"]."</i>";				
		}

		function hidden($Field,$Data){			
			Oxs::I("field");	
			return field::hidden($Field["system_name"],$Data,array( "class"=>"oxs_field_value" ) );			
		}		

		function textarea_edited($Field,$Data){				
			Oxs::I("field");	

			//	Подключаем едитор
			Oxs::G("tinymce")->getObject($Field["system_name"]);
			if($Field["no_change"]) $attr = " disabled ";
			return $Field["description"].field::TextArea($Field["system_name"],$Data,array( "attr"=>$attr , "class"=>"form-control oxs_field_value" , "style" => "margin-top:3px; ".$Field["field_style"] ) );			
		}

		function data($Field,$Data){

			//	Обрабатываем дату если она есть
			if(!empty($Data)){				
				$C = Oxs::L("calendar",$Data);
				$Data = $C->GetYear()."-".$C->GetMount()."-".$C->GetDay();
			}

			Oxs::G("BD")->Start();		
			?>
				<script type="text/javascript">

					field_js_data_local_source = function(){
						this.des = function(){
							//	в деструкторе удалим созданный доом обьект так как он видимый
							$(".flatpickr-calendar").remove();
						}
					}

					field_js_data_local = new field_js_data_local_source();
					oxs_obj.add("field_js_data_local");
				
				</script>
			<?php

			return Oxs::G("BD")->getEnd().$Field["description"].field::Data($Field["system_name"],$Data,array( "config" => "
				changeMonth: true,
				changeYear: true,
				dateFormat: \"dd.mm.yy\"
				" , "attr"=>$attr , "class"=>"form-control oxs_field_value ".$Field["setting"]["class"] , "style" => "margin-top:3px;".$Field["field_style"] , "auto_clear" => $Field["form_name"]) );	
		}
	}
 
