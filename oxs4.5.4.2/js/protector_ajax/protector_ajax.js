function oxs_js_protector_ajax(TokenName,Token,BackPath,RootPath){

	var _this = this;

	this.ParceData = function(Msg){		

		Data = {  };		

		//	Пробуем разждейсонить полученные данные
		try{
			var obj = jQuery.parseJSON(Msg);
		}catch(err){
			console.log("Не смог прпарсить JSON ответ:" + Msg);			
			Data.value = Msg ;  Data.code= 0 ;
			return Data;
		}		

		if(obj.value!=undefined){
			Data.value = obj.value;
		}

		if(obj.code!=undefined){
			Data.code = obj.code;
		}

		if(obj.ErrorText!=undefined){
			Data.ErrorText = obj.ErrorText;
		}

		if(obj.AjaxData!=undefined){
			Data.AjaxData = obj.AjaxData;
		}		

		//	Если есть окно для лога то добалвяем лог
		if(_this.WinObj!=""){			

			//	мы должны хранить 3 последних запроса по этому доабвляем новый в коцне удаляем первый если их 4 или больше	
			jQuery(".id_window_" + ( eval(_this.WinObj).uiid ) + ":first" ).before("<div class=id_window_" + ( eval(_this.WinObj).uiid ) + ">" + obj.logger + "<hr></div>");
			
			var count = eval(_this.WinObj).w.find(".id_window_" +  eval(_this.WinObj).uiid );
			count = count.length;			
			
			if(count>=4){
				for(i=3;i<=count;i++){
					jQuery( ".id_window_" + ( eval(_this.WinObj).uiid ) + ":eq(" + i + ")" ).remove();
				}
			}
		}		

		return Data;
	}

	this.Error = function(){
		return 1;
	}

	this.Success = function(Msg,Code,ErrorText,AjaxData){
		console.log("Код:" + Code);
		console.log("Информация:" +  Msg);
		console.log("Текст:" +  ErrorText);
		console.log("AjaxData:");
		console.log(AjaxData);
		return 1;
	}

	this.POST = function (Path,Data,func){

		if(Path==""){
			throw "oxs_js_protector_ajax: Не указан путь запроса";
		}

		if(Data==undefined){
			Data = {};
		}

		Data.OXS_TOKEN_NAME = TokenName;
		Data.OXS_TOKEN = Token
		Data.OXS_AJAX_ROOT = RootPath;

		_this.WinObj = Data.WinObj; 

		if(func==undefined){
			func = this.Success;
		}			

		jQuery.ajax({
		  url:  Path,
		  type: "POST",
		  data: Data,
		  async : true,
		  success: function(Msg){
			  Data = _this.ParceData(Msg);
			  func(Data["value"],Data["code"],Data["ErrorText"],Data["AjaxData"]);
		  }		  
		});
	}

}
