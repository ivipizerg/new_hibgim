oxs_default_js_display_fix = function(){  	
	var _this = this;  	

	$(function(){

		//	Не использовать on!!! будет накопредние событий
		oxs_events.add(".oxs_smatr_table tbody td:not(.oxs_no_click)","mousedown",function(e){ 	  		
			if(e.button == 0) _this.T  = new Date();
		}); 	

		//	Не использовать on!!! будет накопредние событий
		oxs_events.add(".oxs_smatr_table tbody td:not(.oxs_no_click)","mouseup",function(e){
			
			if(e.button != 0) return ;	

			now = new Date(); 		
			
			if( (now - _this.T) <= 100 ){	
		 		ex_storage.add("fixingId",jQuery(this).attr("data-id"),2);  
		 		datablocks_manager.ExecBlock( ex_storage.get("block_name") + ":fix", ex_storage.get() ,"admin/"+ ( ex_storage.get("block_name") + ":fix") + ".html");  		
			} 		
		});
 	});
}

 

 

