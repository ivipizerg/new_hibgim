oxs_doc_tags_js_tag_selector = function(Param){	

	var _this = this;
	var popup_status=false;
	var ajax_finish=false;
	var interval_value;
	var LoadingText = $(".oxs_doc_tags_fieldsTyps_add_list_" + Param.prefix).text();

	if(Param.ALREADY_EXIST==undefined) Param.ALREADY_EXIST = "ALREADY_EXIST";
	if(Param.no_tag_search_result==undefined) Param.no_tag_search_result = "no_tag_search_result";

	//	Смотрим пришла ли нам дата
	if(Param.data != undefined ){	
		$(".oxs_doc_tags_fieldsTyps_" + Param.prefix).append( crypto_base64.D(Param.data) );	

		//	Клик на удаление элемента
		///////////////////////////////////////////////////////////
		oxs_events.clear(".oxs_doc_tags_fieldsTyps_add_list_item_selected_" + Param.prefix);
			oxs_events.add(".oxs_doc_tags_fieldsTyps_add_list_item_selected_" + Param.prefix,"click",function(){	
				$(this).remove();
				_this.update_value_data();
			});
		///////////////////////////////////////////////////////////	
	}

	this.update_value_data = function(){
		//	перебираем все дивы и обновляем value 
		t = Array();
		$(".oxs_doc_tags_fieldsTyps_" + Param.prefix + " .oxs_doc_tags_fieldsTyps_add_list_item_selected").each(function(){
			t.push($(this).attr("value"));						
			$("[name = " + Param.prefix + "]").val(JSON.stringify(t));
			//console.log($("[name = " + Param.prefix + "]").val());
		});
	}

	this.AJAX_send = function(){

			aj_auth.Exec("doc_tags:ajax",{ action: "search" , settings: { no_tag_search_result: Param.no_tag_search_result , prefix:Param.prefix , table_name: Param.table_name , field_name:Param.field_name , search_fields: Param.search_fields }, value: $(".oxs_doc_tags_fieldsTyps_input_" + Param.prefix).val() },function(Input){
				$(".oxs_doc_tags_fieldsTyps_add_list_" + Param.prefix).html( Input.Msg );
				ajax_finish=true;				
				
				//	Клик по итему в выпадающем списке
				////////////////////////////////////////////////////////////////////////////////////////////////
				oxs_events.clear(".oxs_doc_tags_fieldsTyps_add_list_item_" + Param.prefix);
				oxs_events.add(".oxs_doc_tags_fieldsTyps_add_list_item_" + Param.prefix,"click",function(){		

					var __this = this;
					var if_esit = false;

					//	Проверим нет ли уже такого элемента 
					////////////////////////////////////////////////////////////
					$(".oxs_doc_tags_fieldsTyps_" + Param.prefix + " .oxs_doc_tags_fieldsTyps_add_list_item_selected").each(function(){

						if( $(this).attr("value") == $(__this).attr("value")){							
							if_esit = true;
							aj_no_log.Exec("doc_tags:ajax",{ action:"language" , code : Param.ALREADY_EXIST } , function(Input){
								oxs_message.show(Input.Msg); 
							});
						}

						t = Array();
						t.push($(this).attr("value"));						
						$("[name = " + Param.prefix + "]").val(JSON.stringify(t));
						//console.log($("[name = " + Param.prefix + "]").val());
					});
					if(if_esit) {
						return;
					}
					///////////////////////////////////////////////////////////

					//	Добавляем элемент в выбранные
					//	Удаляем выбранный элемент из списка предложенных
					$(".oxs_doc_tags_fieldsTyps_" + Param.prefix).append("<div value = \"" + $(this).attr("value") + "\" class=\"oxs_doc_tags_fieldsTyps_add_list_item_selected oxs_doc_tags_fieldsTyps_add_list_item_selected_" + Param.prefix + "\">" + $(this).text() + " ❌</div>" );
					$(this).remove();
					
					//	Клик на удаление элемента
					///////////////////////////////////////////////////////////
					oxs_events.clear(".oxs_doc_tags_fieldsTyps_add_list_item_selected_" + Param.prefix);
					oxs_events.add(".oxs_doc_tags_fieldsTyps_add_list_item_selected_" + Param.prefix,"click",function(){	
						$(this).remove();
						_this.update_value_data();
					});
					///////////////////////////////////////////////////////////

					_this.update_value_data();
				});
				/////////////////////////////////////////////////////////////////////////////////////////////////
			});
	}

	//	Клик по полю ввода
	//	Мы должны проверить открыт ли выпадающий список, если нет то открыть
	oxs_events.add(".oxs_doc_tags_fieldsTyps_" + Param.prefix,"click",function(){		
		if(!popup_status){	
			
			popup_status=true;	
			ajax_finish=false;

			$(".oxs_doc_tags_fieldsTyps_add_list_" + Param.prefix).show();	
			//	Не большой трюк с шириной выпадающег осписка
			$(".oxs_doc_tags_fieldsTyps_" + Param.prefix).css("width",$(".oxs_doc_tags_fieldsTyps_" + Param.prefix).css("width"));
			$(".oxs_doc_tags_fieldsTyps_add_list_" + Param.prefix).css("width",$(".oxs_doc_tags_fieldsTyps_" + Param.prefix).css("width"));

			_this.AJAX_send();
		}
	});

	//	Клик вне обьекта для закрытия списка
	oxs_events.add(document,"mousedown",function(e){	
		if ( $(event.target).closest(".oxs_doc_tags_fieldsTyps_" + Param.prefix).length || $(event.target).closest(".oxs_doc_tags_fieldsTyps_add_list_" + Param.prefix).length ) return;
		
		if(ajax_finish==true){
			
			popup_status=false;						

			$(".oxs_doc_tags_fieldsTyps_add_list_" + Param.prefix).hide();  
			$(".oxs_doc_tags_fieldsTyps_input_" + Param.prefix).val("");	
			$(".oxs_doc_tags_fieldsTyps_input_" + Param.prefix).focus();			
			
			e.stopPropagation();   
		}	
	});

	//	Набор текста
	oxs_events.add(".oxs_doc_tags_fieldsTyps_" + Param.prefix,"keyup",function(){
		$(".oxs_doc_tags_fieldsTyps_add_list_" + Param.prefix).text(LoadingText);	
		clearTimeout(interval_value);
		interval_value=setTimeout(function(){
			_this.AJAX_send();
		},600);
	});

} 
