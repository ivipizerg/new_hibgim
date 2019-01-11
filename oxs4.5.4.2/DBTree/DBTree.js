oxs_DBTree = function(){

	var _this = this;	
	var aim = "";		

	this.mode="";
	this.action="";
	this.TMPthis="";

	this.setAim = function(Aim){
		_this.aim = Aim;
	}

	this.getAim = function(){
		return this.aim;
	}	
	

	this.beforeShow = function(e){
		return true;
	}


	this.useMenu = function(){
		
		if(_this.action=="main"){
			_this.MainAction();
		}

		if(_this.action=="sub"){
			_this.subMainAction();
		}
	}

	this.MainAction = function(){
		
		mode = _this.mode;
		t = _this.TMPthis;

		$(t).find("ul:first").show();
			
		if(mode=="right"){

		}

		if(mode=="left"){
			$(t).find("ul:first").offset({left: ($(t).offset().left + $(t).width()) - $(t).find("ul:first").width()});				
		}

		//console.log( ($(this).find("ul:first").offset().left) + ($(this).find("ul:first").width()) );	
		//console.log( ($(this).find("ul:first").position().left) + ($(this).find("ul:first").width()) );

		//	Корректирвока если мы не влазим в экран
		/*if(($(this).find("ul:first").offset().left) + ($(this).find("ul:first").width()) >= window.innerWidth ){

		}*/		

		//console.log(window.innerWidth);
	}

	this.subMainAction = function(){

		mode = _this.mode;
		t = _this.TMPthis;
		
		$(t).find("ul:first").show();
							
		if(mode=="right"){
		}

		if(mode=="left"){
			if($(t).find("ul:first").length!=0 ){
				console.log($(t).find("ul:first").offset().left);
				console.log($(t).find("ul:first").width());
				console.log($(t).width());
				$(t).find("ul:first").offset( { left: ( ($(t).offset().left) - ($(t).find("ul:first").width()) ) } );
				$(t).find("ul:first").offset( { top:  $(t).offset().top  } );								
			}				
		}
	}

	this.useHorisontMenu = function(mode){		

		_this.mode=mode;

		//	Первый UL открыаем, остальыне прячем
		$(_this.aim).show();
		$(_this.aim + " ul ").hide();

		//	Выстраиваем в строку список
		$("ul" + _this.aim + " > li ").css("display","inline-block");		
		$(_this.aim + "  ul ").css("position","absolute");
		$(_this.aim + " ul li ").css("width","160px");
		//	Вешаем событие на основй список
		
		$( _this.aim + " > li ").mouseenter(function(e){	
			_this.action = "main";
			_this.TMPthis = this;
			//console.log("Основной список");
			if(!_this.beforeShow(e)){ console.log("false");  }
			else { console.log("true"); _this.useMenu();}	
		});

		//	Вешаем событие на подсписки
		$( _this.aim + " ul  li ").mouseenter(function(e){
			_this.action = "sub";
			//console.log("Подсписок");
			if(!_this.beforeShow(e)){ console.log("false"); }
			else { console.log("true"); _this.useMenu();}
		});


		//	Вешаем событие закрытия
		$( _this.aim  + " ul ").mouseleave(function(){
			setTimeout(function(){
				$(_this.aim + " ul ").hide();
			},500);
		});
	}
}