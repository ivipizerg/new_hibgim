oxs_docs_js_docs_files_events = function(Data,language){	

	var _this = this;

	this.updateList = function(){		
		//	заполянем данные для передачи при сохранении
		//////////////////////////////////////////////////////
		params = {}; 
		var i=0;
		jQuery("[oxs_data_file_name]").each(function(){				
			params[i++] = { "oroginal_name":this.value , "name" : $(this).attr("oxs_data_file_name") } ;
				
		});	
		ex_storage.add( "files_data" , params , 1 );
		/////////////////////////////////////////////////////			
	}	

	this.addField = function(nameOnFileSystem,name,saved){
		if(saved==undefined) saved = false;
		jQuery(".docs_files_board_add_files_sortable").append("<div style='margin-top:5px;margin-bottom:5px;'><table border=0 width=100%><tr><td width=86%><input type=text class=form-control oxs_data_file_name = \"" + nameOnFileSystem + "\" value=\"" + name + "\" ></td><td width=8% align=center><img class=docs_files_board_add_files_sortable_img width=20 style='' src=" + Data["upDown"] + "> </td><td width=8% align=center><img  class=docs_files_board_add_files_sortable_img_close data_saved=\"" + saved + "\" data_file=\"" + nameOnFileSystem + "\" width=30 style='' src=" + Data["close"] + "> </td></tr></table></div>");
	}

	this.eventStart = function(){
		jQuery(function(){
			
			//	Перемещение обьектов
			jQuery( ".docs_files_board_add_files_sortable" ).sortable({
		    	revert: false,
		    	stop : function(){		     		
		      		_this.updateList();
		    	}
			});

			//	Измнение назвния файлов
			jQuery(".docs_files_board_add_files_sortable input").keyup(function(){
				_this.updateList();
			});

			//	Удаление
			jQuery(".docs_files_board_add_files_sortable_img_close").click(function(){
				_this.a = this;

				console.log(jQuery(this).attr("data_saved"));

				if(jQuery(this).attr("data_saved")=="false"){
					oxs_message.show(language.FILE_DELETE_SUCCESS);
					jQuery(_this.a).parent().parent().parent().remove();
					_this.updateList();
				}else{
					aj_auth.Exec("docs:remove",{ file : jQuery(this).attr("data_file") , id: ex_storage.get("fixingId") },function(Input){	
						console.log(Input);				
						if(Input.Code==1){
							oxs_message.show(language.FILE_DELETE_SUCCESS);
							jQuery(_this.a).parent().parent().parent().remove();
							_this.updateList();
						}else{
							oxs_message.show(language.FILE_DELETE_FAIL);
						}
					});
				}				
			});

		});
	}

	//	Если Data не пуста то заполянем поля	
	if(Data["Data"]!=""){

		_this.eventStart();

		obj = json.D(Data["Data"]);

		//	Бежим по обьекту
		for (key in obj) {		  
		  	_this.addField(obj[key]["name"],obj[key]["original_name"],true);
		}	

		_this.updateList();	
	}
	
	oxs_events.add(".docs_files_board_add_files","click",function(){ 		
		
		ex_storage.add("dir","files/tmp");		
		ex_storage.add("multiple"  , "multiple");
		ex_storage.add("controller"  , "docs_js_docs_files_events");				

		datablocks_manager.ExecBlock("files_manager:form",ex_storage.get(),null,null);
	});


	//	события загрузки
	this.success = function(e){
		if(e.Code!=-1){
			_this.addField(e.Data["file_name"],e.Data["original_file_name"]);
		}
	}

	this.end = function(){
		_this.updateList();
		_this.eventStart();
	}

	/*this.status = function(){

	}*/

	/*this.error = function(){

	}*/
}

