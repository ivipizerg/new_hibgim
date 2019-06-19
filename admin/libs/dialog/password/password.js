oxs_dialog_password = function(farVar,dialog){	
		
	window[dialog].build();
	window[dialog].show();	

	oxs_black_screen.addCode(function(){
		    window[dialog].hide();
			window[dialog] = undefined;			
			dialog_password = undefined;

			oxs_events.clear("[name=oxs_dialog_ask_master_password_ok]");
			oxs_events.clear("[name=oxs_dialog_ask_master_password_cancel]");

		},"dialog");

	//	Обработка клика yes
	oxs_events.add("[name=oxs_dialog_ask_master_password_ok]","click" , function(){
		console.log("Нажата ДА");	
		
		ex_storage.add("oxs_masterPassword",$("[name=oxs_dialog_ask_master_password_edit]").val(),1);		
		oxs_black_screen.Off();
		
		//	продолжаем выполнение приостановленного запроса		
		datablocks_manager.ExecBlock(datablocks_manager._lastBlock,ex_storage.get(),datablocks_manager._lastURL);
	} );

	//	Обработка клика No
	oxs_events.add("[name=oxs_dialog_ask_master_password_cancel]","click" , function(){
		console.log("Нажата НЕТ");	

		//	ЗАтем закрываем диалог
		oxs_black_screen.Off();		
	} );
}



