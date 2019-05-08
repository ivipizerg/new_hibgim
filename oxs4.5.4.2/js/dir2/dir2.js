function oxs_js_dir2(aj_name,log,Post_max_size,Upload_max_filesize,Max_file_uploads){
	
	var _this = this;

	Post_max_size = parseInt(Post_max_size) * 1024 * 1024;
	Upload_max_filesize = parseInt(Upload_max_filesize) * 1024 * 1024;	

	this.FilesMassiv = "";	

	this.getLimits = function(){
		return Array(Post_max_size,Upload_max_filesize,Max_file_uploads);
	}

	this.checkFiles = function(File){
		return true;
	}	

	this.choiseMade = function(FilesMassiv){
		return ;
	}

	this.bind = function(oxs_class){

		js_dir2_events.add(oxs_class,"change",function(e){
			if(log)console.log("Файлы выбраны");

			_this.FilesMassiv=e.target.files;		

			_this.checkFiles(_this.FilesMassiv);				

			_this.choiseMade(_this.FilesMassiv);
		});

		js_dir2_events.add(oxs_class,"dragenter",function(e) {
			// 	Действия при входе курсора с файлами  в блок.
			if(log)console.log("Курсор над областью драг дропа ");	
		});

		js_dir2_events.add(oxs_class,'dragover',function(e) {
			// 	Действия при перемещении курсора с файлами над блоком.
			if(log)console.log("Курсор над областью драг дропа находиться");				
		});


		js_dir2_events.add(oxs_class,'dragleave',function(e) {
			 // 	Действия при выходе курсора с файлами за пределы блока.
			 if(log)console.log("Курсор покинул областью драг дропа");	
		});

		js_dir2_events.add(oxs_class,'drop',function(e) { 
			// Действия при «вбросе» файлов в блок.
			if(log)console.log("Курсор над областью драг дропа отпущен");				
		});
	}

	this.saveFile = function(i){			

	    form = new FormData(); // Создаем объект формы.

	    console.log("Сохраняю файл: " + _this.FilesMassiv[i].name);
	    
	    form.append('P', _this.FilesMassiv[i]); // Прикрепляем к форме файл
	    form.append('ssssP', "asd");	  

	    window[aj_name].sendForm("js.dir2",form);
	}

}
