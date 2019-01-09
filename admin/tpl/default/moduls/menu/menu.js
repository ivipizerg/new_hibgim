
	
 	//	Добавленные коды будут вызваны обратно порядку их добавления то есть последний всегда defalt
 	jQuery(".oxs_active_menu").bind("click",function(){ 	
	 	
	 	var _this = this; 		
	 	
	 	//	Ставим параметр ресет блок что бы сбросить все необходимые занчения
	 	ex_storage.add("reset_block" , 1 ); 	

	 	datablocks_manager.ExecBlock( jQuery(_this).attr("data-route"), storage.get() , "admin/" + jQuery(_this).attr("data-route") + ".html" ); 
	 	
 	}); 	
 
 

 
