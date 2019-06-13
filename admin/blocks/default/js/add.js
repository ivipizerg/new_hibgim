	oxs_default_js_add = function(){	

	} 
  		
  	oxs_events.add(".oxs_active","click",function(){ 	

		params = {}; 		

		jQuery(".oxs_fields_table .oxs_field_value").each(function(E){
			//	Если есть класс auto_clear_ch занчит поле пустое, там значенеи посдказка
			if(jQuery(this).hasClass("auto_clear_ch")){
				params[jQuery(this).attr("name")] = null;
			}
			else {
				//	Чекбокс так просто не отдаст све значение
				if(jQuery(this).attr("type")=="checkbox"){
					if(jQuery(this).prop("checked")){	
						params[jQuery(this).attr("name")] = "1";	
					}
					else{	
						params[jQuery(this).attr("name")] = "0";
					}
				}else{
					params[jQuery(this).attr("name")] = jQuery(this).val();
				}
			}
		}); 

		ex_storage.add( "data" , params , 1 );		
	});	
  		
 
	