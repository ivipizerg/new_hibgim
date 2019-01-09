 oxs_default_js_display_navigation = function(){  	

 	var _this = this; 	
	
	oxs_events.add(".oxs_my_navigation_item","click",function(e){
		ex_storage.add("page",jQuery(this).text(),0); 	
	}); 		
 }

 

