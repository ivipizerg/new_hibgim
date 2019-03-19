oxs_doc_tags_js_tag_selector = function(prefix){	

	var _this = this;
	var popup_status=false;
	var ajax_finish=false;
	var interval_value;
	var LoadingText = $(".oxs_doc_tags_fieldsTyps_add_list_" + prefix).text();

	this.AJAX_send = function(){

			window["oxs_doc_tags_fieldsTyps_ajax_exec_" + prefix].Exec("doc_tags:ajax",{settings: {prefix:prefix , table_name: "#__doc_tags" , field_name:"name" , search_fields: Array("name") }, value:$(".oxs_doc_tags_fieldsTyps_" + prefix).html() },function(Input){
				$(".oxs_doc_tags_fieldsTyps_add_list_" + prefix).html( Input.Msg );
				ajax_finish=true;

				oxs_events.clear(".oxs_doc_tags_fieldsTyps_add_list_item_" + prefix);
				//	Клик по итему в выпадающем списке
				oxs_events.add(".oxs_doc_tags_fieldsTyps_add_list_item_" + prefix,"click",function(){
						
					$(".oxs_doc_tags_fieldsTyps_" + prefix).append($(this).text());
				});
			});
	}

	//	Клик по полю ввода
	//	Мы должны проверить открыт ли выпадающий список, если нет то открыть
	oxs_events.add(".oxs_doc_tags_fieldsTyps_" + prefix,"click",function(){		
		if(!popup_status){
			
			console.log("Показыаем");		
			
			popup_status=true;	
			ajax_finish=false;

			$(".oxs_doc_tags_fieldsTyps_add_list_" + prefix).show();	
			//	Не большой трюк с шириной выпадающег осписка
			$(".oxs_doc_tags_fieldsTyps_" + prefix).css("width",$(".oxs_doc_tags_fieldsTyps_" + prefix).css("width"));
			$(".oxs_doc_tags_fieldsTyps_add_list_" + prefix).css("width",$(".oxs_doc_tags_fieldsTyps_" + prefix).css("width"));

			_this.AJAX_send();
		}
	});

	//	Клик вне обьекта для закрытия списка
	oxs_events.add(document,"mousedown",function(e){	
		if ( $(event.target).closest(".oxs_doc_tags_fieldsTyps_" + prefix).length || $(event.target).closest(".oxs_doc_tags_fieldsTyps_add_list_" + prefix).length ) return;
		
		if(ajax_finish==true){
			
			popup_status=false;	
			
			console.log("Прячем");			

			$(".oxs_doc_tags_fieldsTyps_add_list_" + prefix).hide();   	 

			e.stopPropagation();   
		}	
	});

	//	Набор текста
	oxs_events.add(".oxs_doc_tags_fieldsTyps_" + prefix,"keyup",function(){
		$(".oxs_doc_tags_fieldsTyps_add_list_" + prefix).text(LoadingText);	
		clearTimeout(interval_value);
		interval_value=setTimeout(function(){
			_this.AJAX_send();
		},1000);
	});

} 
