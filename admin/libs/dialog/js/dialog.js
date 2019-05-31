oxs_dialog_js_dialog = function(form,ui_name){	

	console.log("-------------------------------dialog");

	var _this = this;
	this.content = "";

	this.getForm = function(){
		return crypto_base64.D(form);
	}

	this.build = function(){		

		_this.content = decodeURIComponent(_this.getForm());

		window["dialog_window_" + ui_name].set("<div class='oxs_all_dialogs oxs_dialog_" + ui_name + "'>" + (decodeURIComponent(_this.getForm())) + "</div>");						
		window["dialog_window_" + ui_name].stick("center","center");		
		
		oxs_black_screen.addCode(function(){
			window["dialog_window_" + ui_name].destroy();
			window["dialog_window_" + ui_name] = null;
			delete window["dialog_window_" + ui_name];
		},"dialog");
	}

	this.show = function(){
		window["dialog_window_" + ui_name].show();
		oxs_black_screen.On();
	}

	this.hide = function(){
		window["dialog_window_" + ui_name].hide();
	}

	this.set = function(H){
		_this.content = H;
		window["dialog_window_" + ui_name].set("<div class='oxs_all_dialogs oxs_dialog_" + ui_name + "'>" + (H) + "</div>");	
		window["dialog_window_" + ui_name].stick("center","center");
	}

	this.get = function(){
		return _this.content;
	}

}
