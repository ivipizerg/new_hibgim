oxs_default_tree_js_position = function(codebox_obj,block_name){  		

 	var _this = this; 	

 	this.IfDrop = false; 	
	this.Parent = false;
	this.IDTimeout;
	this._change=false;

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
			_this._change=true;
		},

		sort: function(e,ui){	
			_this.Parent = false;
			$(ui.placeholder).html("<td colspan=\"" + (jQuery(".oxs_smatr_table tbody tr:first td").length-1) + "\"><div style='width:100%;height:1px;border-top:1px solid red;'></div></td>");
	 			
			clearTimeout(this.IDTimeout); 			
			this.IDTimeout = setInterval(function(){
				_this.Parent = true;
				console.log("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1");
				$(ui.placeholder).html("<td colspan=\"" + (jQuery(".oxs_smatr_table tbody tr:first td").length-1) + "\"><div style='width:100%;height:1px;border-top:1px solid blue;'></div></td>"); 	
			},1000);
		},

		stop: function(e,ui){
			$(ui.item).show().css("opacity","1");
			var CurrentId = jQuery(ui.item).find("td").attr("data-id");
			var CurrentObject = jQuery(ui.item);
			var PrevObject = jQuery(ui.item).prev();
			console.log("ID текущеей записи " + jQuery(ui.item).find("td").attr("data-id"));
			console.log("ID верхней записи " + jQuery(PrevObject).find("td").attr("data-id") ) ;
			console.log("Родитель: " + _this.Parent);	 			
			jQuery(this).find(".oxs_drag_zone").html("");
			_this.IfDrop = false;		 			

			ex_storage.add( "currentId" , jQuery(ui.item).find("td").attr("data-id") , 1 );
			ex_storage.add( "changeId" ,  jQuery(PrevObject).find("td").attr("data-id") , 1 );
			ex_storage.add( "parentMode" ,   _this.Parent   , 1 );

			if(_this._change){
				//	Выполняем вызов
				datablocks_manager.ExecBlock( ex_storage.get("block_name") + ":position",ex_storage.get(),"admin/"+ ( ex_storage.get("block_name") + ":position") + ".html");	 			
			}

			clearTimeout(this.IDTimeout); 
			_this.Parent = false;
			_this._change=false;

		},

		start: function(e,ui){ 	
			jQuery(ui.item).show().css("opacity","0.3"); 	
			$(ui.placeholder).html("<td colspan=\"" + (jQuery(".oxs_smatr_table tbody tr:first td").length-1) + "\"><div style='width:100%;height:1px;border-top:1px solid red;'></div></td>"); 	
			$(ui.placeholder).show();	
			_this.IfDrop = true;

			//	Стартурем опредлелятор задержки
			this.IDTimeout = setInterval(function(){
				_this.Parent = true;
				console.log("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!2");
				$(ui.placeholder).html("<td colspan=\"" + (jQuery(".oxs_smatr_table tbody tr:first td").length-1) + "\"><div style='width:100%;height:1px;border-top:1px solid blue;'></div></td>"); 	
			},1000);

			_this._change=false;
		}
	}); 	 

	//	Подсветка	
	oxs_events.add(".oxs_smatr_table tr","mouseenter",function(){
		jQuery(this).find(".oxs_drag_zone").html("☷");
	});

	//	Подсветка	
	oxs_events.add(".oxs_smatr_table tr","mouseleave",function(){
		jQuery(this).find(".oxs_drag_zone").html("");
	});	
 }

 

