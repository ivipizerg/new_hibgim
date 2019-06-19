function oxs_js_window_black_screen(log){

	var _this=this;
	
	this.Code = {};
	this.act = true;


	/////////////////////////////////////////////////
	//	Ведение лога
	if(log=="true") this.log = true;
	else this.log = false;
	
	//	Событие клика на свернутое окошко
	jQuery("html").on("click",".oxs_window_black_screen",function(){		
		if(_this.act)
			_this.Off();

	});	

	this.active = function(){
		_this.act = true;
	}

	this.deActive = function(){
		_this.act = false;
	}

	this.On = function(){
		jQuery(".oxs_window_black_screen").show();
	}

	this.Off = function(){
		jQuery(".oxs_window_black_screen").hide();

		var arr = [];
		for (var key in _this.Code) {
		    // add hasOwnPropertyCheck if needed
		    arr.push(_this.Code[key]);
		}
		
		for (var i=arr.length-1; i>=0; i--) {
		    arr[i](this);
		}
		
	}

	//	Доабвить код для выполнения по клику
 	this.addCode = function(Code,Tag){
 		if(Tag==undefined) Tag = "default";
 		_this.Code[Tag]=Code; 		
 	} 	
	

	this.removeCode = function(Tag,reverse){
		if(Tag!=undefined){
			if( reverse==undefined || reverse==false )_this.Code[Tag]="";
			else{
				for (var key in _this.Code) {
				    // add hasOwnPropertyCheck if needed
				    if(key!=Tag) _this.Code[key]="";
				}
			}			
		}else{
			_this.Code=[];
		}
	}


	jQuery("body").prepend("<div class='oxs_window_black_screen'></div>");
}