function oxs_js_dir2(aj_name,log,Post_max_size,Upload_max_filesize,Max_file_uploads){
	
	var _this = this;

	Post_max_size = parseInt(Post_max_size) * 1024 * 1024;
	Upload_max_filesize = parseInt(Upload_max_filesize) * 1024 * 1024;	
	Max_file_uploads = parseInt(Max_file_uploads);	

	this.FilesMassiv = "";	

	this.getLimits = function(){
		return Array(Post_max_size,Upload_max_filesize,Max_file_uploads);
	}

	this.selected = function(FilesMassiv){
		return ;
	}

	this.checkWritable = function(Path,callback_f){
		window[aj_name].Exec("js.dir2",{action:"checkWritable",path:Path},function(Input){
			callback_f(Input);
		});
	}

	this.bind = function(oxs_class){

		js_dir2_events.add(oxs_class,"change",function(e){
			if(log)console.log("Файлы выбраны");
			_this.FilesMassiv=e.target.files;	
			_this.selected(_this.FilesMassiv);
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

	this.saveFile = function(Path,i,callbakcs,next=false){			

	    form = new FormData(); // Создаем объект формы.
	    console.log("Сохраняем файл номер: " + _this.i);	
	    console.log("Название: " + _this.FilesMassiv[i].name);
	    
	    form.append('OXS_DIR2_FILE', _this.FilesMassiv[i]); // Прикрепляем к форме файл
	    form.append("OXS_DIR2_FILE_PATH" , Path);
	   
	    window[aj_name].sendForm("js.dir2",form,{
	    	
	    	success: function(e){
	    		if(callbakcs.success!=undefined)callbakcs.success(e);
	    		if(next)_this.saveAllFiles(Path,callbakcs,false);	    		    
	    	},

	    	status: function(e){
	    		if(callbakcs.status!=undefined)callbakcs.status(e,i);	    		
	    	},

	    	error: function(e){
	    		if(callbakcs.error!=undefined)callbakcs.error(e);	    
	    	}
	    });
	}
	
	//	Сохранить все файлы по очереди
	////////////////////////////////////////////////////////////
	this.i=0;
	this.saveAllFiles = function(Path,callbakcs,first=true){	
		if(first){ _this.i = 0; }
		if(callbakcs==undefined) callbakcs = {};	
		if( _this.i >= _this.FilesMassiv.length){
			if(callbakcs.end!=undefined)callbakcs.end();
			return;
		}
		_this.saveFile(Path,_this.i++,callbakcs,true);
	}
}
