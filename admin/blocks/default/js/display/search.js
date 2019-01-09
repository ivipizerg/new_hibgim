 oxs_default_js_display_search = function(){  	

 	var _this = this; 	

 	_this.WorkerAction = "display";

 	this.active = 1;

 	oxs_search_window.static(); 	
	oxs_search_window.stick("center","bottom");		
							
	aj_no_log.Exec("search:ajax",{action:"getform"},function(Output,Code,Text,Data){
		oxs_search_window.set("<div class=oxs_search_form >" + Output + "</div>");
		oxs_search_window.stick();	
	});
							
	oxs_search_window.fadeOut();

	//	Очищаем поиск
	//storage.AddParam("searchString","");								 	

 	this.Foo = function(e){	 		

 		if(!_this.active) return ;

 		//	Если юзер что то где то водит то нам не стоит перехватывать клавишы
		if(jQuery("input:focus").length!=0 && jQuery("input:focus").attr("name")!="oxs_search") return;

 		//	Исключаем контолы шифры альты и прочую нечисть
 		if( e.keyCode==9 || e.keyCode==20 || e.keyCode==16 || e.keyCode==17  || e.keyCode==18 || e.keyCode==91  || e.keyCode==93 || e.keyCode==39 || e.keyCode==37 || e.keyCode==40 || e.keyCode==38) return;

 		if(_this.WorkerAction!=ex_storage.get("block_action")) return;

		if(oxs_search_window.isHiden()){
			oxs_search_window.fadeIn();
			oxs_search_window.stick();			
		}		

		//	Нам должно быть подготовлено окно 
	 	//	oxs_window_search в него и помещаем все необходимое	 	
		jQuery("[name=oxs_search]").focus();

        //   Вход по интеру
        if(e.keyCode==13){ 
        	console.log(jQuery("[name=oxs_search]").val());
            ex_storage.add("searchString",jQuery("[name=oxs_search]").val(),0); 
 			datablocks_manager.ExecBlock( ex_storage.get("block_name") + ":display", ex_storage.get() ,"admin/" + ex_storage.get("block_name") + ":display" + ".html");  		  
        }

        //    ескейп
        if(e.keyCode==27){
            //auth_window.hide();
            //auth_window.hide_bg();
			oxs_search_window.fadeOut(function(){
				jQuery("[name=oxs_search]").val("");
			});			
        }
 	}
 	
 	
	 	
	oxs_events.add("html","keydown",this.Foo);	 	
	 	
	oxs_events.add("html","click",function(e){	 				
	 		
		if(!oxs_search_window.isHiden()){
			if( !jQuery("[name=oxs_search]").is(e.target) )
				jQuery("[name=oxs_search]").css("opacity","0.4");
		}

	});

	oxs_events.add("html","focus",function(){
		if(!oxs_search_window.isHiden()){
			jQuery("[name=oxs_search]").css("opacity","1");
		}	
	});

	this.Destruct = function(){		
		oxs_search_window.hide();
	}
 }

 

