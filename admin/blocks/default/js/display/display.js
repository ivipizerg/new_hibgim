 oxs_default_js_display = function(){  	

 	var _this = this; 	

 	if(ex_storage.get("reset_block")==1){ 		
 		ex_storage.add("page" , 1 , 0);
		ex_storage.remove("searchString" );
		ex_storage.remove("reset_block");
 	} 
 }

