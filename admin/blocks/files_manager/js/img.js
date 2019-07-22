oxs_files_manager_js_img = function(name_area){	

		window["dialog_" + name_area].build();
		window["dialog_" + name_area].show();
		setTimeout(function(){
			window["dialog_" + name_area].getW().stick("center","center");
		},50);		

		var _this = this;

		var timeout = undefined;

		this.insertImage = function(t){
			window["ckeditor_" + name_area].b.insertHtml("<img width=400 class='oxs_image_bigable' data-file='" + $(t).attr("data-file") + "' src=\"files/img/" + $(t).attr("data-file") + "\">" , 'unfiltered_html');
		}

		this.swapPage = function(){
			console.log(jQuery(".oxs_img_add_box_input").val());
			aj_auth.Exec("files_manager",{ action: "get_form" , type: "img_add_search" ,  page: jQuery(_this.nav).text() , search: jQuery("[name=oxs_img_add_box_input]").val() , name: name  } , function(Input){	
		    		
		    		jQuery(".oxs_img_add_box_inner").html(Input.Msg);

		    		oxs_events.clear(".oxs_my_navigation_item");
		    		oxs_events.add(".oxs_my_navigation_item","click",function(){
						_this.nav=this;
						_this.swapPage();
					});		

		    		oxs_events.clear(".oxs_img_display_item");
		    		oxs_events.add(".oxs_img_display_item","click",function(e){
						_this.insertImage(this);
					});
		   		});
		}

		oxs_events.clear(".oxs_doc_add_item");
		oxs_events.add(".oxs_doc_add_item","click",function(e){
			window["ckeditor_" + name_area].b.insertHtml(" <span style='color:blue' class=oxs_file_insert data-id-oxs_file_insert=" + jQuery(this).find(".oxs_doc_add_item_name").attr("data-id") + ">Документ: " + jQuery(this).find(".oxs_doc_add_item_name").text() + "</span> " , 'unfiltered_html');
		});

		oxs_events.add("[name=oxs_img_add_box_input]","change",function(){
			aj_auth.Exec("files_manager",{ action: "get_form" , type: "img_add_search" ,  page: 1 , search: jQuery(this).val() , name: name  } , function(Input){	
		    		
		    		jQuery(".oxs_img_add_box_inner").html(Input.Msg);

		    		oxs_events.clear(".oxs_my_navigation_item");
		    		oxs_events.add(".oxs_my_navigation_item","click",function(){
						_this.nav=this;
						_this.swapPage();
					});	

		    		oxs_events.clear(".oxs_img_display_item");
		    		oxs_events.add(".oxs_img_display_item","click",function(e){
						_this.insertImage(this);
					});
		   		});
		});

		oxs_events.clear(".oxs_img_display_item");
		oxs_events.add(".oxs_img_display_item","click",function(e){
			_this.insertImage(this);
		});

		oxs_events.add(".oxs_my_navigation_item","click",function(){
			_this.nav=this;
			_this.swapPage();
		});

		oxs_black_screen.addCode(function(){

			delete files_manager_js_img ;
			files_manager_js_img = undefined; 

			delete window["dialog_" + name_area];
			window["dialog_" + name_area]=undefined;

		},"files_manager_js_img");	
}