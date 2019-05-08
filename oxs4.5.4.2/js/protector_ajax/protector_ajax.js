function oxs_js_protector_ajax(TokenName,Token,RootPath){

	var _this = this;

	this.getTN = function(){
		return TokenName;
	}

	this.getT = function(){
		return Token;
	}

	this.getRP = function(){
		return RootPath;
	}		

	this.Error = function(){
		return 1;
	}

	this.Success = function(Input){
		console.log("Ответ:" + Input.Code);	
		return 1;
	}

	this.POST = function (Path,Data,func){

		if(Path==""){
			throw "oxs_js_protector_ajax: Не указан путь запроса";
		}

		if(Data==undefined){
			Data = {};			
		}

		if(Data.oxs_system_ajax_data==undefined){
			Data.oxs_system_ajax_data={};
		}		

		Data.oxs_system_ajax_data.OXS_TOKEN_NAME = TokenName;
		Data.oxs_system_ajax_data.OXS_TOKEN = Token
		Data.oxs_system_ajax_data.OXS_AJAX_ROOT = RootPath;	

		if(func==undefined){
			func = this.Success;
		}			

		jQuery.ajax({
		  url:  Path,
		  type: "POST",
		  data: Data,
		  async : true,
		  success: function(Input){			  
			  func(Input);
		  }		  
		});
	}

}
