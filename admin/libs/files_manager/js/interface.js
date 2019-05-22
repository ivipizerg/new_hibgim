oxs_files_manager_js_interface = function(dialog,Dir,language){

	console.log("Интерфес получен");

	//	Распаковываем форму диалога
	jQuery(".files_board_tmp_zone").html(dialog.build());	
	
		
		//	отображаем диалог
		dialog.show();

		js_dir2.checkWritable(Dir,function(Input){
			if(Input.Code==1){
				console.log("Директория доступна для записи");
			}else{
				console.log("Директория НЕ доступна для записи");	
				oxs_black_screen.Off();	
				oxs_message.show(language.DIR_IS_NOT_WRITABLE);
			}
		});

		//	Файлы выбраны
		//	Проверяем файлы по размеру и содержимому
		//	Так же подсчитываем колчиество выбранных файлов	
		js_dir2.selected = function(massiv){

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
					dialog.set("Загрузка... файл " + (i+1) + " из " + massiv.length  + " " + Math.round((e.loaded/e.total) * 100 ) + "%" );
				},
				success: function(e){

				}
			});	
		}

		js_dir2.bind(".oxs_dialog_load_files_zone_input");

	
	

	oxs_black_screen.addCode(function(){
		console.log("Интерфес удален");
		
		files_manager_js_interface=null;
		delete files_manager_js_interface;

		/*js_dir2 = null
		delete js_dir2;*/

	},"files_manager_js_interface");
}