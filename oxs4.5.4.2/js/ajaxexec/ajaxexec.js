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

	this.sendForm = function(Lib,form){
		
		http = new XMLHttpRequest();

		http.onreadystatechange = function (e) {
			if(this.readyState==4){
				console.log(this.status);
					
				Data = _this.parceData(e.target.response);		

				if(Data.code==-1000){
					if(WinObj!=""){	
						window[WinObj].insert(Data.Msg);
						console.log(Data.Msg);
					}					
				}else{
					if(WinObj!=""){	
						window[WinObj].insert(Data.logger);
						console.log(Data);
					}
				}				
			}       
	    };	   

	    form.append( 'form' , 1 );
	    form.append( 'Lib' , Lib );
	    form.append( 'Code' , Code );
	    form.append( 'SOURCES' , SOURCES );	   

	    form.append( 'TN' , window[ajax_object].getTN() );
	    form.append( 'T' , window[ajax_object].getT() );
	    form.append( 'RP' , window[ajax_object].getRP() );

		http.open('POST', Path + "js/ajaxexec/ajax_resiver.php"); // Открываем коннект до сервера.
	    http.send(form); // И отправляем форму, в которой наши файлы. Через XHR.
	}

}
