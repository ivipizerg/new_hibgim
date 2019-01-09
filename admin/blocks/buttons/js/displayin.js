	oxs_buttons_js_displayin = function(){	

		//	проверяем существует ли боьект на который бум вешать событие
		if($("[name=bid]").length!=0){
			oxs_events.add("[name=bid]","change",function(){
				
				oxs_message.Loading();  
				
				$("[name=displayin]").attr("disabled",true);   

				aj_auth.Exec("buttons:ajax",{action:"getfordisplayin" , id:$(this).val() },function(Output,Code,Text,Data){
					
					oxs_message.LoadingStop();      
					
					$("[name=displayin]").attr("disabled",false); 
					$("[name=displayin]").removeClass("auto_clear_ch"); 
					$("[name=displayin]").val(Output + ":");
				});

			});
		}		
	} 
  		
  	
  		
 
	