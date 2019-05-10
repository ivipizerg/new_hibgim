oxs_js_ajaxexec = function(Path,Code,SOURCES,WinObj,ajax_object){

	var _this = this;	

	this.parceData = function(Input){
		
		Data = {  };		

		//	Пробуем разждейсонить полученные данные
		try{
			var obj = jQuery.parseJSON(Input);
		}catch(err){
			console.log("Не смог прпарсить JSON ответ:" + Input);			
			Data.Msg = Input ;  Data.code= -1000 ;
			return Data;
		}		

		if(obj.value!=undefined){
			Data.Msg = obj.value;
		}

		if(obj.code!=undefined){
			Data.Code = obj.code;
		}

		if(obj.ErrorText!=undefined){
			Data.Text = obj.ErrorText;
		}

		if(obj.AjaxData!=undefined){
			Data.Data = obj.AjaxData;
		}

		if(obj.logger!=undefined){
			Data.logger = obj.logger;
		}			

		return Data;
	}

	this.Exec = function( Lib , Params , Foo , no_log=false){		

		Param = {};
		Param.oxs_system_ajax_data = {};
		
		Param.P = Params;

		Param.oxs_system_ajax_data.Lib = Lib;
		Param.oxs_system_ajax_data.Code = Code;	
		Param.oxs_system_ajax_data.SOURCES = SOURCES;

		window[ajax_object].POST( Path + "js/ajaxexec/ajax_resiver.php", Param , function(Input){

			//console.log(Input);

			Data = _this.parceData(Input);

			//	Если есть окно для лога то добалвяем лог
			if(WinObj!=""){				
				if(!no_log) window[WinObj].insert(Data.logger);			
			}	

			Foo(Data);

		} );
		
	}

	this.sendForm = function(Lib,form,callbacl_fucntions, no_log=false){
		
		http = new XMLHttpRequest();

		http.upload.addEventListener('progress',
	        function(e) {
	            if (e.lengthComputable) {
	            	callbacl_fucntions.status(e);
	            }
	         },false);

		http.upload.addEventListener('error',
	        function(e) {
	            // Паникуем, если возникла ошибка!
	            callbacl_fucntions.error(e);
	        });

		http.onreadystatechange = function (e) {
			if(this.readyState==4){								
				Data = _this.parceData(e.target.response);

				if(WinObj!=""){				
					if(!no_log) window[WinObj].insert(Data.logger);			
				}

				callbacl_fucntions.success(Data);					
			}       
	    };	   

	    //	Подготовалвиаем необходимые данные дял отпарвки
	    form.append("oxs_system_ajax_data[Lib]" , Lib);
	    form.append("oxs_system_ajax_data[Code]" , Code);
	    form.append("oxs_system_ajax_data[SOURCES]" , SOURCES);	    

	    //	Подготовалвиаем необходимые данные дял отпарвки
	    form.append("oxs_system_ajax_data[OXS_AJAX_ROOT]" , window[ajax_object].getRP());	
	    form.append("oxs_system_ajax_data[OXS_TOKEN_NAME]" , window[ajax_object].getTN());
	    form.append("oxs_system_ajax_data[OXS_TOKEN]" , window[ajax_object].getT()); 

		http.open('POST', Path + "js/ajaxexec/ajax_resiver.php"); // Открываем коннект до сервера.
	    http.send(form); // И отправляем форму, в которой наши файлы. Через XHR.
	}

}
