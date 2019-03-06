oxs_autentificator_forms_events = function(){

	 jQuery("html").on("keydown","[name = login] , [name = password]",function(e){

          //   Вход по интеру
          if(e.keyCode==13){
              jQuery("[name=enter]").click();       
         }

         //    ескейп
         if(e.keyCode==27){
               //auth_window.hide();
               //auth_window.hide_bg();

         }
     });

	jQuery("html").on("click","[name=enter]",function(){	

		oxs_message.Loading();
	
		aj_auth.Exec("autentificator:ajax",{ 
			action: "try_enter" , 
			login: jQuery("[name=login]").val() , 
			password: jQuery("[name=password]").val(),
			cookie: js_cookie.get_cookie("antispam")
		},function(T){

			oxs_message.LoadingStop();

			oxs_message.show(T.Text);	

			if(T.Code==1){	
				//	Обновляем страничку
				setTimeout(function(){
					location.reload(true);
				},500);				
			}	

		});	
	});
}