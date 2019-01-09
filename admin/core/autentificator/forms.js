oxs_autentificator_forms = function(){

	this.generate = function(str) {
	  return str.replace(/[xy]/g, function(c) {
	    var r = Math.random() * 16 | 0;
	    return (c == 'x' ? r : (r & 0x3 | 0x8 )).toString(16);
	  });
	}	

	//	проверяем куку и ставим её если нужно
	if ( ! js_cookie.get_cookie ( "antispam" ) ){	
		var a = 	this.generate('xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx');
		js_cookie.set_cookie ( "antispam",a );	

		//	Отправляем куку на сервер для занесения в базу данных
		/*aj_auth.Exec("autentificator:ajax",{ 
			action: "save_cookie" , 
			cookie: a 
		},function(T,Code,Text){
			
			if(Code==1){				
				//	Авторизовалиьс идем в админку
			}else{				
				oxs_message.show(Text);
			}			
		});	*/
	}
}