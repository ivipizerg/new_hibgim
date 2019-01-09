oxs_DBTree = function(){

	var _this = this;	
	var aim = aim;	

	this.setAim = function(Aim){
		_this.aim = Aim;
	}

	this.getAim = function(){
		return this.aim;
	}

	this.useHorisontMenu = function(mode){		

		//	Первый UL открыаем, остальыне прячем
		$(_this.aim).show();
		$(_this.aim + " ul ").hide();

		//	Выстраиваем в строку список
		$("ul" + _this.aim + " > li ").css("display","inline-block");		
		$(_this.aim + "  ul ").css("position","absolute");
		$(_this.aim + " ul li ").css("width","160px");
		//	Вешаем событие на основй список
		$( _this.aim + " > li ").mouseenter(function(){		
			
			//console.log("Основной список");	

			$(this).find("ul:first").show();
			
			if(mode=="right"){

			}

			if(mode=="left"){
				$(this).find("ul:first").offset({left: ($(this).offset().left + $(this).width())  - $(this).find("ul:first").width()});				
			}

			//console.log( ($(this).find("ul:first").offset().left) + ($(this).find("ul:first").width()) );	
			//console.log( ($(this).find("ul:first").position().left) + ($(this).find("ul:first").width()) );

			//	Корректирвока если мы не влазим в экран
			/*if(($(this).find("ul:first").offset().left) + ($(this).find("ul:first").width()) >= window.innerWidth ){

			}*/		

			//console.log(window.innerWidth);			
		});

		//	Вешаем событие на подсписки
		$( _this.aim + " ul  li ").mouseenter(function(){

			//console.log("Подсписок");	
			
			$(this).find("ul:first").show();
							
			if(mode=="right"){
			}

			if(mode=="left"){
				if($(this).find("ul:first").length!=0 ){
					console.log($(this).find("ul:first").offset().left);
					console.log($(this).find("ul:first").width());
					console.log($(this).width());
					$(this).find("ul:first").offset( { left: ( ($(this).offset().left) - ($(this).find("ul:first").width()) ) } );
					$(this).find("ul:first").offset( { top:  $(this).offset().top  } );								
				}				
			}
		});


		//	Вешаем событие закрытия
		$( _this.aim  + " ul ").mouseleave(function(){
			setTimeout(function(){
				$(_this.aim + " ul ").hide();
			},500);
		});
	}
}