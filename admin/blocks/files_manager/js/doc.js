oxs_files_manager_js_doc = function(name_area){	

		window["dialog_" + name_area].build();
		window["dialog_" + name_area].show();
		setTimeout(function(){
			window["dialog_" + name_area].getW().stick("center","center");
		},50);		

		var _this = this;

		var timeout = undefined;

		this.swapPage = function(page){
			console.log(jQuery(".oxs_img_add_box_input").val());
			aj_auth.Exec("files_manager",{ action: "get_form" , type: "doc_add_search" ,  page: page  , search: jQuery(_this.e).val() , name: name  } , function(Input){	
					console.log(Input);
		    		jQuery(".oxs_doc_add_box_inner").html(Input.Msg);	

		    		oxs_events.clear(".oxs_doc_add_item");
		    		oxs_events.add(".oxs_doc_add_item","click",function(e){
						window["ckeditor_" + name_area].b.insertHtml(" <span style='color:blue' class=oxs_file_insert data-id-oxs_file_insert=" + jQuery(this).find(".oxs_doc_add_item_name").attr("data-id") + ">Документ: " + jQuery(this).find(".oxs_doc_add_item_name").text() + "</span> " , 'unfiltered_html');
					});

					oxs_events.clear(".oxs_my_navigation_item");
					oxs_events.add(".oxs_my_navigation_item","click",function(){
						_this.swapPage(jQuery(this).text());
					});
		   	});
		}

		oxs_events.clear("[name=oxs_doc_add_box_input]");

		//	Поиск
		oxs_events.add("[name=oxs_doc_add_box_input]","keyup",function(e){			

			clearTimeout(timeout);

			_this.e = this;

			timeout = setTimeout(function(){					
				_this.swapPage(1);
			},800);
		});

		oxs_events.clear(".oxs_doc_add_item");
		oxs_events.add(".oxs_doc_add_item","click",function(e){
			window["ckeditor_" + name_area].b.insertHtml(" <span style='color:blue' class=oxs_file_insert data-id-oxs_file_insert=" + jQuery(this).find(".oxs_doc_add_item_name").attr("data-id") + ">Документ: " + jQuery(this).find(".oxs_doc_add_item_name").text() + "</span> " , 'unfiltered_html');
		});

		oxs_events.clear(".oxs_my_navigation_item");
		oxs_events.add(".oxs_my_navigation_item","click",function(){
			_this.swapPage(jQuery(this).text());
		});

		oxs_black_screen.addCode(function(){

			delete files_manager_js_doc ;
			files_manager_js_doc = undefined; 

			delete window["dialog_" + name_area];
			window["dialog_" + name_area]=undefined;

		},"files_manager_js_doc");	
}