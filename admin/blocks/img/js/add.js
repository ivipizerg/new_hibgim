oxs_img_js_add = function(Name){
	
	var _this = this;
	this.files_list = "";

	oxs_events.clear(".oxs_active");

	//	Удаление
	oxs_events.add("[data-route=img_remove]","click",function(){

		//	Собираем все выбранное
		var data = new Array();
		$(".oxs_img_display_item_selected").each(function(){
			data.push($(this).attr("data-id"));
		});

		aj_auth.Exec("img:remove", { action: "remove" , data: data } ,function(Input){
			oxs_message.show(Input.Text);
			datablocks_manager._ExecBlock("img:display",ex_storage.get(),"admin/img:display.html",true,true);
		});
	});
	
	oxs_events.add("[data-route=img_add]","click",function(){
		aj_auth.Exec("files_manager", {action: "get_form" , type: "img_add" , name: Name } ,function(Input){
			jQuery(".oxs_main_container_dialog").html( Input.Msg );
			
			setTimeout(function(){
				//console.log(Input.Data["form"]);
				window["dialog_" + Name + "_img"].build();
				window["dialog_" + Name + "_img"].set(Input.Data["select"] + "<br>" +  Input.Data["form"]);				
				window["dialog_" + Name + "_img"].show();			
			},50);			
		});
	});

	this.success = function(e){
		this.files_list += e.Data["file_name"] + ",";
	}

	this.end = function(e){	
		//	Отправляем запрос на обработку
		aj_auth.Exec("img:add_end", { action: "save_files" , files: _this.files_list , cat:ex_storage.get("cat") } , function(Input){			
			oxs_message.show(Input.Text);	
			_this.files_list = "";	
			datablocks_manager._ExecBlock("img:display",ex_storage.get(),"admin/img:display.html",true,true);
		});
	}

	this.change = function(){
		ex_storage.add("cat",$("[name=cat]").val(),1);
		_this.files_list = "";		
		window["dialog_" + Name + "_img"].hide();
	}

	jQuery(".oxs_img_display_item").css("cursor","pointer");

	oxs_events.add(".oxs_img_display_item","click",function(){		
		if(!$(this).hasClass("oxs_img_display_item_selected")){
			$(this).css("border","10px solid red").addClass("oxs_img_display_item_selected");
		}else{
			$(this).css("border","none").removeClass("oxs_img_display_item_selected");
		}
	});

	oxs_black_screen.addCode(function(){

			window["dialog_" + Name + "_img"].hide();

			delete window["dialog_" + Name + "_img"];
			window["dialog_" + Name + "_img"] = undefined;

			delete files_manager_js_interface ;
			files_manager_js_interface = undefined;
			
		},"img_js_add");
}