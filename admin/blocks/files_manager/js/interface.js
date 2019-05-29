oxs_files_manager_js_interface = function(dialog,Dir,language){

		console.log("Интерфес получен");

		//	Распаковываем форму диалога
		dialog.build();

		js_dir2.checkWritable(Dir,function(Input){			
			
			if(Input.Code==1){
				console.log("Директория доступна для записи");
				//	отображаем диалог
				dialog.show();

				//	Файлы выбраны
				//	Проверяем файлы по размеру и содержимому
				//	Так же подсчитываем колчиество выбранных файлов	
				js_dir2.bind(".oxs_dialog_load_files_zone_input",{change:function(massiv){
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
							dialog.set("Загрузка...<br>файл " + (i+1) + " из " + massiv.length  + " <br><div class=oxs_dialog_load_files_status_bar><div class=oxs_dialog_load_files_status_bar_inner></div></div><div class=oxs_dialog_load_files_status_bar_percent></div>"  );					
							jQuery(".oxs_dialog_load_files_status_bar_inner").css("width",Math.round((e.loaded/e.total) * 100) + "%");
							jQuery(".oxs_dialog_load_files_status_bar_percent").html(Math.round((e.loaded/e.total) * 100) + "%");
						},
						success: function(e){					
							oxs_black_screen.Off();
							oxs_message.show(language.SUCCESS_UPLOAD);
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
				
				files_manager_js_interface=null;
				delete files_manager_js_interface;

			},"files_manager_js_interface");

			}else{
				console.log("Директория НЕ доступна для записи");	
				oxs_black_screen.Off();	
				oxs_message.show(language.DIR_IS_NOT_WRITABLE);
			}
		});

		
}