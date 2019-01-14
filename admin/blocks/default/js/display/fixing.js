oxs_default_js_display_fixing = function(codebox_obj,block_name){  		

 	var _this = this; 	
 
 	oxs_events.add(".oxs_buttons_fixing","click",function(){
 		if(jQuery("[name=oxs_checkBoxMainTableItem]:checked").length==1)
 			default_js_collect_cheked_id.uncheckAll();
 	});	

 }

 

