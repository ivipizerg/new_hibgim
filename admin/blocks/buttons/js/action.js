	oxs_buttons_js_action = function(){	

		//	проверяем существует ли боьект на который бум вешать событие
		if($("[name=bid]").length!=0){
			oxs_events.add("[name=bid]","change",function(){
				
				oxs_message.Loading(); 

				$("[name=action]").attr("disabled",true);   

				aj_auth.Exec("buttons:ajax",{action:"getforaction" , id:$(this).val() },function(Output,Code,Text,Data){
					
					oxs_message.LoadingStop();      
					
					$("[name=action]").attr("disabled",false); 
					$("[name=action]").removeClass("auto_clear_ch"); 
					$("[name=action]").val(Output + ":");
				});

			});
		}		
	} 
  		
  	
  		
 
	