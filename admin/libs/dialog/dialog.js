oxs_dialog = function(){

	var _this = this;	

	dialog_window.stick("center","center");
	dialog_window.hide();
	dialog_window.addClass("dialog_window");
	dialog_window.static();

	this.b_close = "";
	this.b_route = "";

	this.show = function(Data){			

		oxs_black_screen.addCode(function(){
			dialog_window.hide();		
			oxs_events.clear(_this.b_close,"click");	
			oxs_events.clear(_this.b_route,"click");		
		});

		oxs_black_screen.On();																										
		dialog_window.w.stop().fadeIn(500);
		dialog_window.set("<div class=oxs_dialog_window_text>" + Data + "</div>");
		dialog_window.stick("center","center");
		dialog_window.show();
	}

	this.hide = function(){
		dialog_window.hide();
		oxs_black_screen.Off();				
	}

	this.setCloseEvent = function(Class){

		//	Запоминаем текущий класс что бя снят ьс него событие в дальнейшем
		this.b_close = Class;

		tmp = function(){					
			sys_dialog.hide();			
		}		

		oxs_events.add(Class,"click",tmp);
	}

	this.setRoute = function(Class){	

		this.b_route = Class;

		oxs_events.add(Class,"click",function(){ 			
	 		ex_storage.add( jQuery(this).attr("name") , "true" , 1 );
	 		default_js_active_buttons.Ex(jQuery(this).attr("data-route"),"admin/" + jQuery(this).attr("data-route") + ".html");
	 		sys_dialog.hide();			
	 	} );
	}	
}