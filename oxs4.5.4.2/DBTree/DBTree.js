oxs_DBTree = function(){

	var _this = this;	
	var aim = "";	
	var subAim = null;		

	this.setAim = function(Aim){
		_this.aim = Aim;
	}

	this.getAim = function(){
		return this.aim;
	}

	this.setSubAim = function(subAim){
		_this.subAim = subAim;
	}	

	//	Если указан subAim то нам нужно из этйо суб цели вйти на пункт списка
	//	для верных расчетов
	this.subAimCalculate = function(t){
		return $(t).parent();		
	}

	this.beforeShow = function(e,t){
		return true;
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
		
		$( _this.aim + " > li " + _this.subAim).mouseenter(function(e){

			var __this = _this.subAimCalculate(this);
			
			console.log("Основной список");

			if(!_this.beforeShow(e,__this)){ console.log("false"); return ; }
			else { console.log("true");}	

			$(__this).find("ul:first").show();
			
			if(mode=="right"){

			}

			if(mode=="left"){
				$(__this).find("ul:first").offset({left: ($(__this).offset().left + $(__this).width()) - $(__this).find("ul:first").width()});				
			}

			//console.log( ($(this).find("ul:first").offset().left) + ($(this).find("ul:first").width()) );	
			//console.log( ($(this).find("ul:first").position().left) + ($(this).find("ul:first").width()) );

			//	Корректирвока если мы не влазим в экран
			/*if(($(this).find("ul:first").offset().left) + ($(this).find("ul:first").width()) >= window.innerWidth ){

			}*/		

			//console.log(window.innerWidth);			
		});

		//	Вешаем событие на подсписки
		$( _this.aim + " ul  li " + _this.subA ).mouseenter(function(e){

			console.log("Подсписок");	

			var __this = _this.subAimCalculate(this);

			if(!_this.beforeShow(e,__this)){ console.log("false"); return ; }
			else { console.log("true");}	
			
			$(__this).find("ul:first").show();
							
			if(mode=="right"){
			}

			if(mode=="left"){
				if($(__this).find("ul:first").length!=0 ){
					console.log($(__this).find("ul:first").offset().left);
					console.log($(__this).find("ul:first").width());
					console.log($(__this).width());
					$(__this).find("ul:first").offset( { left: ( ($(__this).offset().left) - ($(__this).find("ul:first").width()) ) } );
					$(__this).find("ul:first").offset( { top:  $(__this).offset().top  } );								
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