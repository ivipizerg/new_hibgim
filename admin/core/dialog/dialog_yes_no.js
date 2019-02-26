oxs_dialog_dialog_yes_no = function(uniqueName,farVar){	

	//	Обработка клика yes
	oxs_events.add("[name=oxs_dialog_button_yes_" + uniqueName+"]","click" , function(){
		console.log("Нажата ДА");

		//	Первым делом заносим в farVar true дабы нашь диалог больше не покзаывался
		ex_storage.add(farVar,true,1);

		//	ЗАтем закрываем диалог
		oxs_black_screen.Off();

		//	продолжаем выполнение приостановленного запроса		
		datablocks_manager.ExecBlock(datablocks_manager._lastBlock,ex_storage.get(),datablocks_manager._lastURL);
	} );

	//	Обработка клика No
	oxs_events.add("[name=oxs_dialog_button_no_" + uniqueName+"]","click" , function(){
		console.log("Нажата НЕТ");	

		//	ЗАтем закрываем диалог
		oxs_black_screen.Off();		
	} );
}