oxs_files_manager_js_interface = function(window_name,formData,Dir){

	console.log("Интерфес получен");
	
	window_name.set(crypto_base64.D(formData));
	window_name.stick("center","center");
	window_name.show();

	//	Вешаем обработчики зоны выбора файлов
	//	Проверяем папку на запись
	/*if(js_dir.ChekDir(Dir,function(){
		console.log("Папка " + Dir + " доступна для записи");
	}))*/

	//	Ждем милипульку что бы код формы успел распокаваться иначе не забиндимся
	setTimeout(function(){

		js_dir2.checkFiles = function(File){
			return ;		
		}
		
		js_dir2.choiseMade = function(massiv){
			console.log("Выбрали");		
			js_dir2.saveFile(0);	
		}

		js_dir2.bind(".oxs_dialog_load_files_zone_input");

	},10);
	

	oxs_black_screen.addCode(function(){
		console.log("Интерфес удален");
		
		files_manager_js_interface=null;
		delete files_manager_js_interface;

		js_dir2 = null
		delete js_dir2;


	},"files_manager_js_interface");
}