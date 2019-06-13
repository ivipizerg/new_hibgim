oxs_files_manager_js_interface = function(dialog,obj,Dir,language){

		console.log("Интерфес получен");

		var _this = this;		

		//	Распаковываем форму диалога
		dialog.build();			
		
		//	отображаем диалог
		dialog.show();

		//	Файлы выбраны
		//	Проверяем файлы по размеру и содержимому
		//	Так же подсчитываем колчиество выбранных файлов	
		js_dir2.bind(".oxs_dialog_load_files_zone_input",{

			change:function(massiv){
				//	смотрим колчиестов вбыранных файлов
				limits = js_dir2.getLimits();			
						
				//	Проверяем количество
				if(massiv.length>limits[2]){
					oxs_black_screen.Off();	
					oxs_message.show(language.MAX_UPLOAD_COUNT);
					return ;
				}

				//	Проверяем размер
				for(i = 0; i<massiv.length ; i++){
					if( massiv[i].size > limits[0] || massiv[i].size > limits[1]){
						oxs_black_screen.Off();	
						oxs_message.show(language.MAX_SIZE_FILE);
						return ;
					}
				}

				console.log("Файлы проверены, можем сохранять");		
				
				js_dir2.saveAllFiles(Dir,{
					
					status: function(e,i){	

						if(window[obj].status!=undefined)
						if(window[obj].status(e,i)==false){
							return ;
						}

						dialog.set("Загрузка...<br>файл " + (i+1) + " из " + massiv.length  + " <br><div class=oxs_dialog_load_files_status_bar><div class=oxs_dialog_load_files_status_bar_inner></div></div><div class=oxs_dialog_load_files_status_bar_percent></div>"  );					
						jQuery(".oxs_dialog_load_files_status_bar_inner").css("width",Math.round((e.loaded/e.total) * 100) + "%");
						jQuery(".oxs_dialog_load_files_status_bar_percent").html(Math.round((e.loaded/e.total) * 100) + "%");
					},
					
					success: function(e){	

						if(window[obj].success!=undefined)
						if(window[obj].success(e)==false){
							return ;
						}	

						if(e.Code==-1){							
							oxs_black_screen.Off();								
							oxs_message.show(language.DIR_IS_NOT_WRITABLE);
							return false;
						}						
					},					
					
					error: function(e){
						if(window[obj].error!=undefined)
						if(window[obj].error(e)==false){
							return ;
						}										
					},
					
					end: function(e){							

						if(window[obj].end!=undefined)
						if(window[obj].end(e)==false){
							return ;
						}	

						if(e==null){
							oxs_message.show(language.SUCCESS_UPLOAD);								
							oxs_black_screen.Off();
						}																					
					}
				});				
			},
			dragenter: function(){	
				a = jQuery(".oxs_dialog_load_files_zone");
				a.removeClass("oxs_dialog_load_files_zone");
				a.addClass("oxs_dialog_load_files_zone_hover");
				jQuery(".oxs_dialog_load_files_zone_text").text(language.DROP_CURSOR);
			},
			dragleave: function(){
				jQuery(".oxs_dialog_load_files_zone_text").text(language.SELECT_FILE_TO_DOWNLOAD);
				a = jQuery(".oxs_dialog_load_files_zone_hover");
				a.addClass("oxs_dialog_load_files_zone");
				a.removeClass("oxs_dialog_load_files_zone_hover");
			}
		});	

		oxs_black_screen.addCode(function(){
			console.log("Интерфес удален");		

			_dialog = undefined;
			delete _dialog;

			files_manager_js_interface = undefined;
			delete files_manager_js_interface;

			js_dir2 = undefined
			delete js_dir2;

		},"files_manager_js_interface");
		
}