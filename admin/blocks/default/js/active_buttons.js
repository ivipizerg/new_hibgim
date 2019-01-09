 oxs_default_js_active_buttons = function(){  	
 	
 	var _this = this;

 	this.Ex = function(Route,Path){
 		var _this = this;	
		datablocks_manager.ExecBlock( Route , ex_storage.get() , Path ); 		
 	}
 }

$(function(){	

	oxs_events.add(".oxs_active","click",function(){ 
		console.log("КЛИК----------------------------------------");
		if(jQuery(this).attr("data-route")!="" & jQuery(this).attr("data-route")!=undefined){
	 		ex_storage.add("mode_string",jQuery(this).attr("data-mode"),1);	 		
	 		default_js_active_buttons.Ex(jQuery(this).attr("data-route"),"admin/" + jQuery(this).attr("data-route") + ".html");
	 	}
	}); 
		 
});
 



 

