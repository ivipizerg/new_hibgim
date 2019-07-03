oxs_files_manager_js_doc = function(name_area){	

		window["dialog_" + name_area].build();
		window["dialog_" + name_area].show();

		var _this = this;

		var timeout = undefined;

		//	Поиск
		oxs_events.add("[name=oxs_doc_add_box_input]","keyup",function(e){			

			clearTimeout(timeout);

			_this.e = this;

			timeout = setTimeout(function(){					

				aj_auth.Exec("files_manager",{ action: "get_form" , type: "doc_add_search" ,  page: 1 , search: jQuery(_this.e).val() , name: name  } , function(Input){	
					console.log(Input);
		    		jQuery(".oxs_doc_add_box_inner").html(Input.Msg);	
		   		});

			},800);
		
		});

		oxs_events.add(".oxs_doc_add_item","click",function(e){
			ckeditor_start.b.insertHtml(jQuery(this).text());
		})

		oxs_black_screen.addCode(function(){

			delete files_manager_js_doc ;
			files_manager_js_doc = undefined; 

			delete window["dialog_" + name_area];
			window["dialog_" + name_area]=undefined;

		},"files_manager_js_doc");	
}