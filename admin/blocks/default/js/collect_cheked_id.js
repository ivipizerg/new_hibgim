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
  
  	//	Вешаем событие для поиска шифта
  	oxs_events.add("html","keydown",function(){
  		window["oxs_display_shift_on"]=1;
  	});

  	oxs_events.add("html","keyup",function(){
  		window["oxs_display_shift_on"]=0;
  	});
  	///////////////////////////////////


  	window["oxs_display_last_chekbox"]=-1;
	oxs_events.add("[name=oxs_checkBoxMainTableItem]","change",function(e){ 
		
		if(window["oxs_display_shift_on"]){

			if(window["oxs_display_last_chekbox"]<jQuery(this).attr("num")){
				for(i=window["oxs_display_last_chekbox"];i<=jQuery(this).attr("num");i++){
					jQuery("[name=oxs_checkBoxMainTableItem]:eq(" + i + ")").prop('checked', true); 
				}
			}else{
				for(i=jQuery(this).attr("num");i<=window["oxs_display_last_chekbox"];i++){
					jQuery("[name=oxs_checkBoxMainTableItem]:eq(" + i + ")").prop('checked', true); 
				}
			}
		}


		window["oxs_display_last_chekbox"] = jQuery(this).attr("num");

		default_js_collect_cheked_id.collectItems();		
	});	
  });

 

