function oxs_js_window_events(windowobject){	

	var _this=this;		

	//////////////////////////////////////////////////////////
	//	Зажата мышка или нет
	this.mousedown=false;
	//	Кооординаты крусора при зажатии мышки
	this.x; this.y;

	//	Запоминаем исходные размера экрана
	this.ScreenWidth=parseInt(window.innerWidth);
	this.ScreenHeight=parseInt(window.innerHeight); 	

	//	запоминаем Кооржинаты окна в момент отпускания мышки
	this.CenterX=parseInt(windowobject.w.css("left") + windowobject.w.outerWidth()/2);
	this.CenterY=parseInt( windowobject.w.css("top")  + windowobject.w.outerHeight()/2);
	//	Обьект панели для сворачивания по умолчанию
	this.window_bar = undefined;
	/////////////////////////////////////////////////////////		

	//	Событие клика по окну
	this.mouse_click = function(e,T){		
		
		if(!windowobject.move){
			return ;
		} 

		jQuery("html").on("selectstart", function() {return false;} );	
		
		_this.x=e.pageX;
		_this.y=e.pageY;
		_this.mousedown=true;		
	}	

	//	Установить область зажимаемую для перемеения на все окно
	this.SetWindowClickListener = function(){

		if(windowobject.log)console.log("Убиваем с блока " +  windowobject.move_block_name + " ставим на все окно(" + windowobject.wString + ")");

		//	Убиваем слушатель на блок
		if(windowobject.move_block_name!=undefined){
			jQuery("html").off("mousedown",  windowobject.move_block_name);
			jQuery(windowobject.move_block_name).removeClass("move_cursor");	
			jQuery(windowobject.wString).addClass("move_cursor");			
		}

		jQuery("html").on("mousedown",windowobject.wString,function(e){	
			
			if(e.button == 0){
				_this.mouse_click(e,this);
				if(windowobject.log)console.log("Зажали окно" + windowobject.uiid);				
			}	
		});	
	}

	//	Установить область зажимаемую для перемеения на нужный блок
	this.SetBlockClickListener = function(){
		if(windowobject.log)console.log("Убиваем с всего окна (" + windowobject.wString + ") ставим на блок " +  windowobject.move_block_name );

		//	Убиваем слушатель на блок
		jQuery("html").off("mousedown",windowobject.wString);
		jQuery(windowobject.wString).removeClass("move_cursor");	
		jQuery(windowobject.move_block_name).addClass("move_cursor");		

		jQuery("html").on("mousedown",windowobject.move_block_name,function(e){	
			
			if(e.button == 0){
				_this.mouse_click(e,this);
				if(windowobject.log)console.log("Зажали указанынй блок" +  windowobject.move_block_name);			
			}			
		});		
	}	

	this.setWinowBar = function(new_windwo_bar){
		_this.window_bar = new_windwo_bar;
	}	

	this.fold = function(){

		//	Так как мы не можем получить обьект window_bar пока он еще не создан а он в процессе создания вызывает этот обьект
		//	ПОлучим его уже при попытке свернуть окно
		if(this.window_bar==undefined){
			this.window_bar = oxs_window_bar;
		}

		windowobject.w.hide();		
		_this.window_bar.Insert(windowobject);
		if(windowobject.log) console.log("Свернуть окно " + windowobject.wString);
	}

	//	вешаем событие клика на обьект для сворачивания окна
	this.folding = function(){

		//jQuery("html").off("click",windowobject.min_button);

		jQuery("html").on("click",windowobject.min_button,function(){
			//	По клику мы прячем тукщее окно и вызываем в баре инсерт передавая id окна
			//	Вроде все просто
			_this.fold();
		});
	}

	//	Событие отжатия кнопки
	jQuery("html").on("mouseup",function(e){		
			
		_this.mousedown=false;	
		
		jQuery("body").css("cursor","auto");
		jQuery("html").off("selectstart");	
	});			

	jQuery("html").on("mousemove",function(e){		
		
		if(_this.mousedown){

			if(windowobject.heightAlign=="bottom") windowobject.w.css("bottom", parseInt(windowobject.w.css("bottom")) + (_this.y - e.pageY) );
			else windowobject.w.css("top", parseInt(windowobject.w.css("top")) - (_this.y - e.pageY) );			
			
			if(windowobject.widthAlign=="right") windowobject.w.css("right", parseInt(windowobject.w.css("right")) + (_this.x - e.pageX) );
			else windowobject.w.css("left", parseInt(windowobject.w.css("left")) - (_this.x - e.pageX) );

			_this.x=e.pageX;
			_this.y=e.pageY;		
		}
	});	

	//	Событие измеения размерво окна
	jQuery(window).resize(function(ev){			
		windowobject.UserResize(windowobject);
	});
	
}
