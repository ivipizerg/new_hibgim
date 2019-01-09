oxs_settings_cfg_file_edit = function(){	

	//	Дефалтный обработчик должен пробежать по всем полям , собрать занчения value 
	//	и запихнуть в параметры дял передачи в скрипт обработчик	
	codebox_global_buttons.AddCode(function(){			

		codebox_global_buttons.ParamMass = {};

		jQuery(".oxs_fields_table .oxs_field_value").each(function(E){
			//	Если есть класс auto_clear_ch занчит поле пустое, там значенеи посдказка
			if(jQuery(this).hasClass("auto_clear_ch")){
				codebox_global_buttons.AddParam(jQuery(this).attr("name"),null);
			}
			else {
				//	Чекбокс так просто не отдаст све значение
				if(jQuery(this).attr("type")=="checkbox"){
					if(jQuery(this).prop("checked")){						
						codebox_global_buttons.AddParam(jQuery(this).attr("name"),"on");
					}
					else{						
						codebox_global_buttons.AddParam(jQuery(this).attr("name"),"off");
					}
				}else{
					codebox_global_buttons.AddParam(jQuery(this).attr("name"),jQuery(this).val());
				}
			}
		}); 		

	},"click","add");	
	
} 
