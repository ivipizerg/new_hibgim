oxs_settings_cfg_file_edit = function(uniqueName,farVar){	

	//	Обработка клика yes
	oxs_events.add("[name=oxs_dialog_ask_master_password_ok_" + uniqueName+"]","click" , function(){
		console.log("Нажата ДА");	
		
		ex_storage.add("oxs_masterPassword",$("[name=oxs_dialog_ask_master_password_edit_" + uniqueName+"]").val(),1);		
		oxs_black_screen.Off();
		
		//	продолжаем выполнение приостановленного запроса		
		datablocks_manager.ExecBlock(datablocks_manager._lastBlock,ex_storage.get(),datablocks_manager._lastURL);
	} );

	//	Обработка клика No
	oxs_events.add("[name=oxs_dialog_ask_master_password_cancel_" + uniqueName+"]","click" , function(){
		console.log("Нажата НЕТ");	

		//	ЗАтем закрываем диалог
		oxs_black_screen.Off();		
	} );
	
	
} 
