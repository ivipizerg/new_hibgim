function oxs_js_window_window_bar(log){

	var _this=this;

	/////////////////////////////////////////////////
	//	Ведение лога
	if(log=="true") this.log = true;
	else this.log = false;	
	
	//	Наше окно
	this.Window = null;
	//////////////////////////////////////////////////	

	//	Создаем блок для окна
	this.addClass = function(bar_class){			
		_this.Window.addClass(bar_class);
	}

	this.removeClass = function(bar_class){
		_this.Window.removeClass(bar_class);
	}

	this.SetName = function(window,name){
		jQuery("[data-oxs_window_bar_item=" + window.uiid + "]").html("" + window.window_name + "");
	}

	this.Insert = function(window){			

		this.Window.show();

		//	Проверим не сворачивались ли мы уже
		if(jQuery("[data-oxs_window_bar_item=" + window.uiid + "]").length==0){
			_this.Window.set(  "<div class=oxs_window_bar_item data-oxs_window_bar_item=" + window.uiid + " > " + window.window_name + "</div><div class=oxs_bar_movier_spacer data-window-bar-spacer=" + window.uiid + "></div>" + _this.Window.get() );
			if(_this.log)console.log("Добавляю в панель окно " + window.uiid);			
		}		
	}

	this.Remove = function(window_id){
		jQuery("[window-id=" + window_id + "]").show();
		jQuery("[data-oxs_window_bar_item=" + window_id + "]").remove();
		jQuery("[data-window-bar-spacer=" + window_id + "]").remove();		
	}

	//	Событие клика на свернутое окошко
	jQuery("html").off("click",".oxs_window_bar_item");
	jQuery("html").on("click",".oxs_window_bar_item",function(){
		_this.Remove(jQuery(this).attr("data-oxs_window_bar_item"));
		//   Шлем событие ресайза
        //   Обычным Jquery Оно не шлеться
		window.dispatchEvent(new Event('resize'));
	});	
	
	this.Window = new oxs_js_window(log);
	this.Window.set("<div class='oxs_bar_movier_style oxs_bar_movier_" + this.Window.uiid + "''>☷</div><div class='oxs_bar_movier_spacer'></div>");		
	this.Window.addClass("oxs_window_bar_style");
	this.Window.stick("left","bottom");	
	this.Window.mobile("." + "oxs_bar_movier_" + this.Window.uiid );

	this.Window.hide();
}