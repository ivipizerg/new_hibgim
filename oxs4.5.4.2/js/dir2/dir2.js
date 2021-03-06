function oxs_js_dir2(aj_name,log,max_size,Max_file_uploads){	

	var _this = this;

	max_size = parseInt(max_size) * 1024 * 1024;	
	Max_file_uploads = parseInt(Max_file_uploads);	

	this.FilesMassiv = "";	

	this.getLimits = function(){
		return Array(max_size,Max_file_uploads);
	}

	//	Проверить на запись диреткорию
	/*this.checkWritable = function(Path,callback_f){
		window[aj_name].Exec("js.dir2",{action:"checkWritable",path:Path},function(Input){
			callback_f(Input);
		});
	}*/

	this.bind = function(oxs_class,events_object){

		//	Очистим собятия если они уже были
		js_dir2_events.clear(oxs_class,"change");
		js_dir2_events.clear(oxs_class,"dragenter");
		js_dir2_events.clear(oxs_class,"dragover");
		js_dir2_events.clear(oxs_class,"dragleave");
		js_dir2_events.clear(oxs_class,"drop");
		/////////////////////////////////////////////////////////////		

		js_dir2_events.add(oxs_class,"change",function(e){
			if(log)console.log("Файлы выбраны");
			_this.FilesMassiv=e.target.files;	
			if(events_object.change!=undefined)events_object.change(_this.FilesMassiv);
		});

		js_dir2_events.add(oxs_class,"dragenter",function(e) {
			// 	Действия при входе курсора с файлами  в блок.
			if(log)console.log("Курсор над областью драг дропа ");	
			if(events_object.dragenter!=undefined) events_object.dragenter();
		});

		js_dir2_events.add(oxs_class,'dragover',function(e) {
			// 	Действия при перемещении курсора с файлами над блоком.
			if(log)console.log("Курсор над областью драг дропа находиться");	
			if(events_object.dragover!=undefined)events_object.dragover();			
		});


		js_dir2_events.add(oxs_class,'dragleave',function(e) {
			// 	Действия при выходе курсора с файлами за пределы блока.
			if(log)console.log("Курсор покинул областью драг дропа");
			if(events_object.dragleave!=undefined) events_object.dragleave();
		});

		js_dir2_events.add(oxs_class,'drop',function(e) { 
			// Действия при «вбросе» файлов в блок.
			if(log)console.log("Курсор над областью драг дропа отпущен");
			if(events_object.drop!=undefined)events_object.drop();				
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

	    		if(callbakcs.success!=undefined){
	    			if(callbakcs.success(e)==false) { if(callbakcs.end!=undefined) callbakcs.end(e); return; }
	    		}
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
			if(callbakcs.end!=undefined)callbakcs.end(null);
			return;
		}
		_this.saveFile(Path,_this.i++,callbakcs,true);
	}
}
