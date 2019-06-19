oxs_dialog_yes_no = function(farVar,dialog){	
	
	console.log(dialog);	

	window[dialog].build();
	window[dialog].show();	

	oxs_black_screen.addCode(function(){
		    window[dialog].hide();
			
			window[dialog]=undefined;
			dialog_yes_no=undefined;

			oxs_events.clear("[name=oxs_dialog_button_no_dialog_yes_no]");
			oxs_events.clear("[name=oxs_dialog_button_yes_dialog_yes_no]");

		},"dialog");

	//	Обработка клика yes
	oxs_events.add("[name=oxs_dialog_button_yes_dialog_yes_no]","click" , function(){
		console.log("Нажата ДА");

		//	Первым делом заносим в farVar true дабы нашь диалог больше не покзаывался
		ex_storage.add(farVar,true,1);

		//	ЗАтем закрываем диалог
		oxs_black_screen.Off();

		//	продолжаем выполнение приостановленного запроса		
		datablocks_manager.ExecBlock(datablocks_manager._lastBlock,ex_storage.get(),datablocks_manager._lastURL);
	} );

	//	Обработка клика No
	oxs_events.add("[name=oxs_dialog_button_no_dialog_yes_no]","click" , function(){
		console.log("Нажата НЕТ");	
		//	ЗАтем закрываем диалог
		oxs_black_screen.Off();		
	} );
}



