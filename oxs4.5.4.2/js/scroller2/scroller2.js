function oxs_js_scroller2_init(){	

	var _this = this;

	this.class="";
	this.item_class="";
	this.line_class="";
	this.count_visible_elemnts=0;
	this.noscroll=false;
									//	количестов видимых элементов
	this.Init = function(Class , count_visible_elemnts){
		if(Class[0]=="." || Class[0]=="#"){
			this.class=Class.slice(1);
		}


		this.count_visible_elemnts = count_visible_elemnts
		this.item_class = this.class + "_items";
		this.line_class = this.class + "_line";

		jQuery(Class + " div").addClass(this.item_class);
		jQuery(Class + " div").wrapAll("<div class=" + this.line_class + " />");


		//	Стили самой коробки
		jQuery(Class).css("position","relative").css("overflow","hidden").css("border","1px solid black");

		//	Стили для ползающего блока
		jQuery("." + this.class + "_line").css("position","relative").css("white-space","nowrap").css("left", "0px");	

		//	Стили для итемов
		jQuery("." + this.class + "_items").css("display","inline-block").css("width","40px").css("height","40px").css("border","1px solid red");;
		
		//	Расчитываем ширину бокса
		jQuery(Class).css("width", jQuery("." + this.class + "_items").outerWidth() * this.count_visible_elemnts ) ;

		//	Проверяем не слишком ли мало итемов для отображения
		if(count_visible_elemnts>=jQuery("." + this.item_class).size()){
			this.noscroll=true;
			return ;
		}

		//	Клонируем count_elements элементов в конец
		for(i=0;i<=this.count_visible_elemnts;i++){
			Tmp = jQuery("." + this.item_class + " :eq("+ i +")").clone();
			Tmp.removeClass(this.item_class);
			jQuery("." + this.line_class + " div :last").after(Tmp);
		}

		
		//	Клонируем count_elements элементов в начало
		start = jQuery("." + this.class + "_items").size();
		end = start - this.count_visible_elemnts - 1 ;

		for(i=start;i>=end;i--){
			Tmp = jQuery("." + this.item_class + " :eq("+ i +")").clone();
			Tmp.removeClass(this.item_class);
			jQuery("." + this.line_class + " div :first").before(Tmp);
		}

		start = jQuery("." + this.item_class).outerWidth() *  (this.count_visible_elemnts + 1 ) ;
		jQuery("." + this.line_class).animate( { left : ( -start ) },0);			
	}	
	
	this.leftt_flag = true;
	this.left = function(){
		
		if(this.noscroll==true) return ;
		
		if(this.leftt_flag == true){this.leftt_flag=false;}
		else return;

		shift = parseInt( jQuery("." + this.line_class).css("left") ) - jQuery("." + this.item_class).outerWidth();
		speed = 250;
		jQuery("." + this.line_class).stop().animate( { left :shift },speed , function () {
			if( Math.abs(shift) >= Math.abs(jQuery("." + _this.class + "_items").outerWidth() * (jQuery("." + _this.class + "_items").size() + 1) ) ){
				console.log("!");
				shift = -jQuery("." + _this.item_class).outerWidth();
				speed = 0;
				jQuery("." + _this.line_class).css(  "left"  , shift);						
			}
			_this.leftt_flag = true;
		});
	}

	this.right_flag = true;
	this.right = function(){
		
		if(this.noscroll==true) return ;
		
		if(this.right_flag == true){this.right_flag=false;}
		else return;

		shift = parseInt( jQuery("." + this.line_class).css("left") ) + jQuery("." + this.item_class).outerWidth();
		speed = 250;

		jQuery("." + this.line_class).animate( { left :shift },speed, function(){
			if( shift >= 0){
				console.log("!");
				shift = jQuery("." + _this.item_class).outerWidth() *  jQuery("." + _this.item_class).size();
				speed = 0;
				console.log(shift);
				jQuery("." + _this.line_class).css(  "left"  , -shift);				
			}
			_this.right_flag = true;
		});	
	}
	
}