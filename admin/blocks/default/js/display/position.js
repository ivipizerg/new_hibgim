oxs_default_js_display_position = function(){  	

 	var _this = this; 

 	this.IfDrop = false; 	
	//this.Parent = false;
	this.IDTimeout;	

 	if(jQuery( ".oxs_smatr_table tbody" ).length!=0)
	 	jQuery( ".oxs_smatr_table tbody" ).sortable({
	 		
	 		handle: ".oxs_drag_zone", 		

	 		axis: "y",		
	 		opacity: 1, 	
	 		helper: "clone", 	
	 		opacity : 0.3,	

	 		placeholder: "oxs_smatr_table-placeholder",
	 		
	 		change: function(e,ui){ 
	 			$(ui.placeholder).html("<td colspan=\"" + (jQuery(".oxs_smatr_table tbody tr:first td").length-1) + "\"><div style='width:100%;height:1px;border-top:1px solid red;'></div></td>"); 	
	 			$(ui.placeholder).show();	
	 		},

	 		sort: function(e,ui){	 			
	 			
	 			//_this.Parent = false;
	 			$(ui.placeholder).html("<td colspan=\"" + (jQuery(".oxs_smatr_table tbody tr:first td").length-1) + "\"><div style='width:100%;height:1px;border-top:1px solid red;'></div></td>");	 			
	 			
	 		},

	 		stop: function(e,ui){
	 			$(ui.item).show().css("opacity","1");
	 			var CurrentId = jQuery(ui.item).find("td").attr("data-id");
	 			var CurrentObject = jQuery(ui.item);
	 			var PrevObject = jQuery(ui.item).prev();
	 			console.log("ID текущеей записи " + jQuery(ui.item).find("td").attr("data-id"));
	 			console.log("ID верхней записи " + jQuery(PrevObject).find("td").attr("data-id") ) ;
	 			//console.log("Родитель: " + _this.Parent);	 			
	 			jQuery(this).find(".oxs_drag_zone").html("");
	 			_this.IfDrop = false;	
	 			
	 			ex_storage.add(  "currentId" , jQuery(ui.item).find("td").attr("data-id") , 1 );
	 			ex_storage.add(  "changeId" ,  jQuery(PrevObject).find("td").attr("data-id") , 1 ); 

	 			//	Выполняем вызов
	 			datablocks_manager.ExecBlock( ex_storage.get("block_name") + ":position", ex_storage.get() ,"admin/"+ ( ex_storage.get("block_name") + ":position") + ".html");	 			
	 		},

	 		start: function(e,ui){ 	
	 			jQuery(ui.item).show().css("opacity","0.3"); 	
	 			$(ui.placeholder).html("<td colspan=\"" + (jQuery(".oxs_smatr_table tbody tr:first td").length-1) + "\"><div style='width:100%;height:1px;border-top:1px solid red;'></div></td>"); 	
	 			$(ui.placeholder).show();	
	 			_this.IfDrop = true;	 			
	 		}
	 	});

	 	//	Подсветка
	 	//	Не использовать on!!! будет накопредние событий
	 	oxs_events.add(".oxs_smatr_table tr","mouseenter",function(){
	 		jQuery(this).find(".oxs_drag_zone").html("☷");
	 	});

	 	//	Подсветка
	 	//	Не использовать on!!! будет накопредние событий
	 	oxs_events.add(".oxs_smatr_table tr","mouseleave",function(){
	 		jQuery(this).find(".oxs_drag_zone").html("");
	 	});	

 	//	POSITION
 	//////////////////////////////////////////////
 	
 }

 

