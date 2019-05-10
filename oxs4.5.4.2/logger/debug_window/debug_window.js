oxs_logger_debug_window = function(Name, header){
		
	var _this = this;

	this.WinObj = "winobj_"  + Name;

	//	Создаем панель если её нет
	if(typeof log_window_bar == "undefined"){
		log_window_bar = new oxs_js_window_window_bar("false");									
	}	

	window[this.WinObj].UserResize = function(Wi){					
		//	Мальца подпарвлям ширину оконца					
		Wi.w.width(document.documentElement.clientWidth);						
	}

	window[this.WinObj].setWindowBar(log_window_bar);

	window[this.WinObj].set("<div class=oxs_debug_window><div class=id_window_" + window[this.WinObj].uiid  + ">Ожидаем аякс запросы...<hr></div><div class='oxs_oxs_debug_window_button " +  this.WinObj + "_fold_button'>__</div></div>");

	window[this.WinObj].stick("left","bottom");
	window[this.WinObj].static();							
	window[this.WinObj].addClass(Name);
	window[this.WinObj].setName(header);
	window[this.WinObj].folding("." + this.WinObj + "_fold_button");
	window[this.WinObj].fold();
	log_window_bar.Window.stick("right","top");

	this.clear = function(){
		window[this.WinObj].set("<div class=oxs_debug_window><div class=id_window_" + window[this.WinObj].uiid  + "></div><div class='oxs_oxs_debug_window_button " +  this.WinObj + "_fold_button'>__</div></div>");
	}

	this.insert = function(info){
		//	мы должны хранить 3 последних запроса по этому доабвляем новый в коцне удаляем первый если их 4 или больше	
		jQuery(".id_window_" + ( window[this.WinObj].uiid ) + ":first" ).before("<div class=id_window_" + ( window[this.WinObj].uiid ) + ">" + info + "<hr></div>");
			
		var count = window[this.WinObj].w.find(".id_window_" +  window[this.WinObj].uiid );
		count = count.length;			
			
		if(count>=4){
			for(i=3;i<=count;i++){
				jQuery( ".id_window_" + ( window[this.WinObj].uiid ) + ":eq(" + i + ")" ).remove();
			}
		}
	}	

}

