function oxs_js_window(log){	

	var _this=this;
	
	////////////////////////////////////////////////////////////	
	//	Уникальный номер окна
	this.uiid = 0;
	//	Обьект окна
	this.w;
	//	Строка для получения обьекта
	this.wString;
	//	Обьект обработчика событий окна
	this.wcontroller;
	//	Параметры выравнивания
	this.value1="center";
	this.value2="center";
	//	Включение отключение лога	
	if(log=="true") this.log = true;
	else this.log = false;
	//	Подвижное или статичное
	this.move=true;
	//	Названия блока за который таскать
	this.move_block_name=undefined;
	//	Кнопка для сворачивания
	this.min_button=undefined;
	//	Название окна
	this.window_name=undefined;	
	//	Ориентир выравнивания по гирине
	this.widthAlign="center";
	//	Ориентир выранивания по высоте
	this.heightAlign="center";	
	//	Фалаг скрытости
	this.isHide = true;
	/////////////////////////////////////////////////////////////	

	//	Поместить в окно информацию
	this.set = function(Data){
		if(this.log)console.log("Вставка" , Data);
		this.w.html(Data);	
		window.dispatchEvent(new Event('resize')); 
		jQuery(window).resize();		
	}	

	this.get = function(){
		return this.w.html();
	}

	this.destroy=function(){
		this.w.remove();
	}

	this.setName = function(name){
		_this.window_name = name;
			
		if(typeof oxs_window_bar != 'undefined'){			
			oxs_window_bar.SetName(this,name);
		}
	}
	
	//	Указать шиирну окна
	this.setWidth = function(Value){
		this.w.css("width",Value);
		jQuery(window).resize();
	}

	//	Указать высоту окна
	this.setHeight = function(Value){
		this.w.css("height",Value);
		jQuery(window).resize();
	}

	//	Доабвить класс
	this.addClass = function(calss_name){
		this.w.addClass(calss_name);
	}

	//	Установить ориентир по ширине
	this.setWidthAlign = function(align){
		this.widthAlign = align;		
		//jQuery(window).resize();
	}

	//	Установить ориентир по высоте
	this.setHeightAlign = function(align){
		this.heightAlign = align;
		//jQuery(window).resize();
	}

	//	Удалить класс
	this.removeClass = function(calss_name){
		this.w.removeClass(calss_name);
	}	

	//	Прилепить окно к части жкрана
	this.stick = function(value1,value2){
		
		//	Сохраняем параметр или подгружаем
		if(value1==undefined) value1 = this.value1;
		else this.value1 = value1;

		//	Сохраняем параметр или подгружаем
		if(value2==undefined) value2 = this.value2;
		else this.value2 = value2;

		this.setWidthAlign(value1);
		this.setHeightAlign(value2);

		if(this.log)console.log("Равняюсь " + value1 + " " + value2);

		//	Высота онка 
		var ww=parseInt(window.innerWidth);
		//	Ширина окна
		var hw=parseInt(window.innerHeight);
		
		/*console.log("Ширина окна " + ww);
		console.log("Высота окна " + hw);*/

		//	лево право цент
		if(value1=="left" ){		
			this.w.css("right", "auto" );		
			this.w.css("left", 0 );			
		}

		if(value1=="center" ){
			//console.log( ww/2 , ( this.w.width() ) ,  this.w.html() );
			this.w.css("right", "auto" );	
			this.w.css("left", ww/2 - (this.w.outerWidth()/2) );			
		}

		if(value1=="right" ){
			//console.log(parseInt(this.w.outerWidth()));
			this.w.css("left", "auto" );	
			this.w.css("right", 0 );			
		}

		//	Вернх низ центр
		if(value2=="top" ){	
			this.w.css("bottom", "auto" );			
			this.w.css("top", 0 );
		}

		if(value2=="center" ){	
			this.w.css("bottom", "auto" );			
			//console.log( hw/2 , ( this.w.outerHeight() ) ,  this.w.html() );
			this.w.css("top", hw/2 - (this.w.outerHeight()/2) );
		}

		if(value2=="bottom" ){		
			//console.log("Высота блока " + this.w.outerHeight());
			this.w.css("top", "auto" );		
			this.w.css("bottom", 0 );
		}

		/*console.log("После выравнивания слева  " + (ww/2 - (this.w.outerWidth()/2)));
		console.log("После выравнивания сверху  " + (hw/2 - (this.w.outerHeight()/2)));*/
	
	} 

	this.setWindowBar = function(new_windowbar){
		_this.wcontroller.setWinowBar(new_windowbar);
	}

	//	Окно можно свернуть при
	this.folding = function(Block_name){
		_this.min_button=Block_name;		

		//	Вешаем обработчик события
		_this.wcontroller.folding();
	}

	//	Свернуть окно
	this.fold = function(){		
		_this.wcontroller.fold();
	} 

	//	Развернуть окно
	this.unfold = function(){

	}

	//	Окно на передний план
	this.first = function(){

	}

	//	Сделать окно статичным
	this.static = function(){
		this.move = false;	
	}	

	//	Сдлеать подвижным
	//	Если не передать Block_name таскать можно за все оконо
	//	Если передать Block_name таскаться будет только за него
	this.mobile = function(Block_name){

		if(Block_name==undefined) {
			this.move_block_name = undefined;
			this.wcontroller.SetWindowClickListener();	
		}
		else {
			this.move_block_name = Block_name;
			this.wcontroller.SetBlockClickListener();	
		}

		this.move = true;	
	}	

	//	Скрыто ли окно
	this.isHiden = function(){
		return _this.isHide;
	}

	//	Скрыть окно
	this.hide = function(Sec){
		_this.isHide = true;
		_this.w.hide(Sec);
	}

	//	Показать окно
	this.show = function(Sec){
		_this.isHide = false;
		_this.w.show(Sec);
	}

	//	Скрыть окно
	this.fadeOut = function(Sec){
		_this.isHide = true;
		_this.w.fadeOut(Sec);
	}

	//	Показать окно
	this.fadeIn = function(Sec){
		_this.isHide = false;
		_this.w.fadeIn(Sec);
	}	

	//	Калбек на ресайз ДО
	this.UserResize = function(this_Window){
		return;
	}	

	//	Получаем uuid
	this.uiid = jQuery(".oxs_window").length + 1;

	//	Создаем блок для окна
	jQuery("body").prepend("<div class='oxs_window' window-id='" + (this.uiid) + "'></div>");
	
	//	Получаем обьект окна
	this.wString = "[window-id="+this.uiid+"]";
	this.w = jQuery(this.wString);

	//	Цепляем обработчик
	this.wcontroller = new oxs_js_window_events(this);
	
	//this.set("<h1 style='border: 1px solid red'>Test</h1>");	
	this.stick();
	this.hide();	
	
	//	Делаем окно по умолчанию перемещаемым
	this.mobile();
	this.setName("Окно № " + this.uiid);		

	if(this.log)console.log("Создаю окно uiid = " + this.uiid);	
}
