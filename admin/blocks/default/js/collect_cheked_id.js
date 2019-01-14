oxs_default_js_collect_cheked_id = function(){  	

 	var _this = this; 	

 	this.uncheckAll = function(){ 		
 		jQuery("[name=oxs_checkBoxMainTableItem]").prop('checked', false); 		
 	}
 	
 	this.clear = function(){ 	
 		ex_storage.remove("oxs_selected_id"); 		
 	} 	


 	this.collectItems = function(){ 		

		ex_storage.add( "oxs_selected_id" , "" , 1 );  	
		
		if(jQuery("[name=oxs_checkBoxMainTableItem]:checked").length!=0){ 		 	

			jQuery("[name=oxs_checkBoxMainTableItem]:checked").each(function(){
				ex_storage.add( "oxs_selected_id" ,  ex_storage.get("oxs_selected_id") + jQuery(this).attr("data-id") + "," , 1 );  
			});

			ex_storage.add( "oxs_selected_id" , ex_storage.get("oxs_selected_id").substring(0, ex_storage.get("oxs_selected_id").length - 1 ) , 1  );  			
		}
 	}

 	//	фнкционал главног очекбокса инвертировать выеделенное
 	oxs_events.add("[name=oxs_checkBoxMainTable]","click",function(){
 		
 		if(jQuery(this).prop('checked')==true){
 			jQuery("[name=oxs_checkBoxMainTableItem]").prop('checked', true); 
 		}else{
 			jQuery("[name=oxs_checkBoxMainTableItem]").prop('checked', false); 
 		}

 		_this.collectItems();
 	}); 

 }

  $(function(){	  		
	oxs_events.add("[name=oxs_checkBoxMainTableItem]","change",function(){ 

		

		default_js_collect_cheked_id.collectItems();		
	});	
  });

 

