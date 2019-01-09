oxs_default_js_collect_cheked_id = function(){  	

 	var _this = this; 	

 	//	ckearStore = false - только снять выделение
 	//	ckearStore = true - снять выделение и очистить сторе
 	this.clear = function(ckearStore){
 		if(ckearStore==undefined) ckearStore = false;

 		jQuery("[name=oxs_checkBoxMainTableItem]").removeAttr("checked");

 		if(!ckearStore){
 			ex_storage.remove("oxs_selected_id");
 		}
 	} 	
 }

  $(function(){	
  	//	Собираем нажатые ячейки если они есть
	//////////////////////////////////////////////////	

	oxs_events.add("[name=oxs_checkBoxMainTableItem]","change",function(){ 

		ex_storage.add( "oxs_selected_id" , "" , 1 );  	
		
		if(jQuery("[name=oxs_checkBoxMainTableItem]:checked").length!=0){ 		 	

			jQuery("[name=oxs_checkBoxMainTableItem]:checked").each(function(){
				ex_storage.add( "oxs_selected_id" ,  ex_storage.get("oxs_selected_id") + jQuery(this).attr("data-id") + "," , 1 );  
			});

			ex_storage.add( "oxs_selected_id" , ex_storage.get("oxs_selected_id").substring(0, ex_storage.get("oxs_selected_id").length - 1 ) , 1  );  			
		}
	});

	////////////////////////////////////////////////// 		
  });

 

