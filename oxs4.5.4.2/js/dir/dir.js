
var OXS_BACK_PATH="";

function oxs_js_dir_init(_TN,_T,_BackPath,_RootPath,_MyPath){

	this.BackPath=_BackPath;
	this.RootPath=_RootPath;
	this.MyPath=_MyPath;

	this.Class = "";

	this.path=undefined;

	//	название уже сохраненног офайла
	this.real_path = undefined;

	this.selected=false;

	this.TN=_TN;
	this.T=_T;

	var _this=this;

	this.TmpBuffer;

	this.FilesList=Array();

	this.post_max_size=0;
	this.SetPost_max_size = function(val){
		this.post_max_size=parseInt(val);
	}

	this.upload_max_filesize=0;
	this.SetUpload_max_filesize = function(val){
		this.upload_max_filesize=parseInt(val);
	}

	this.max_file_uploads=0;
	this.SetMax_file_uploads = function(val){
		this.max_file_uploads=parseInt(val);
	}

	this.formats=undefined;
	this.SetFormats = function(val){
		this.formats=val;
	}

	this.SetPath = function(P){
		_this.path = P;
	}

	this.GetPath = function(){
		return _this.path
	}

	this.SetRealPath = function(name){
		this.real_path = name;
	}

	this.GetRealPath = function(){
		return this.real_path;
	}

	this.IfSelected = function(){
		return _this.selected;
	}

	this.IfFileExist = function(Path,Foo){	
		dir_ajax.POST( _this.MyPath + "js/dir/ajax_dir.php" ,{ act: "fileexist"  , path: Path , oxs_root : _this.RootPath , my_path: _this.MyPath , back: _this.BackPath } , Foo );
	}

	//	Получить списко файлов в директории
	this.GetList = function(path,Foo){
		console.log("Поулчаю списко файлов директории " + path);
		dir_ajax.Success = Foo;
		dir_ajax.POST(_this.MyPath + "js/dir/ajax_dir.php" ,{ act: "dir"  , path: path , oxs_root : _this.RootPath , my_path: _this.MyPath , back: _this.BackPath });
	};

	//	Проверить директорию на запись
	this.ChekDir = function(path,Foo){
		console.log("Проверяю директорию на запись " + path);
		dir_ajax.Success = Foo;
		dir_ajax.POST(_this.MyPath + "js/dir/ajax_dir.php" ,{ act: "chekdir"  , path: path , oxs_root : _this.RootPath , my_path: _this.MyPath , back: _this.BackPath });
	};

	this.LocalChekFile = function( file, i , oxs_Error){
		return 1;
	}

	//	Проверяет переданный файл на правильность формата
	//	ФОрматы можно передать через запятую
	this.CherkFormat = function(File,Format){

		if(Format==undefined) return 1;

		formatMass = Format.split(",");			
		for(i=0;i<formatMass.length;i++){
			if(File.type.split("/")[1]==formatMass[i]){
				return true;
			}
		}

		return false;
	}

	//	Функция проверки файла
	this.ChekFile=function(files,i){	
		
		if( Math.ceil(files[i].size/1024/1024) > this.post_max_size ) {
			_this.LocalChekFile( files , i  , 'oxs_js_dir: Слишком большой файл (post_max_size): ' + Math.ceil(files[i].size/1024/1024) + "МБ Из " + _this.post_max_size + "МБ" );	
			return 0;
		}

		if( Math.ceil(files[i].size/1024/1024) > this.upload_max_filesize ) {
			_this.LocalChekFile( files , i , 'oxs_js_dir: Слишком большой файл (upload_max_filesize): ' + Math.ceil(files[i].size/1024/1024) + "МБ Из " + _this.upload_max_filesize + "МБ" );	
			return 0;
		}

		if( files.length > this.max_file_uploads ) {
			_this.LocalChekFile( files , i , 'oxs_js_dir: Слишком много файлов (max_file_uploads): ' + files.length() + " Из " + _this.max_file_uploads );	
			return 0;
		}

		if(!_this.CherkFormat(files[i],this.formats)) return _this.LocalChekFile(files,i,'oxs_js_dir: не верный тип файла: "' + files[i]["name"] + '" разрешены только: "' + this.formats + '"' );

		return _this.LocalChekFile(files,i,"empty");		
	};

	//	Проверить может ли браузер сделать наш трюк
	this.ChekBrowser = function(){
		if (window.FormData === undefined) {
		   console.error("Браузер не поддерживает загрузку файлов");
		   return 0;
		}else return 1;
	}

	//	Функция будт автоматический вызвана после процедуры выбора файлов
	this.EndSelect = function(){
		return 1;
	}

	//	Прибананиться к определенному инпуту
	//	Полсе процедуры выбора или перетаскиваняи файлов будет выполнена функция EndSelect()
	this.BindInput = function(Class){

		_this.Class=Class;

		jQuery(Class).bind("change",function(e){

			console.log("Файлы выбраны методом onchange");

			_this.FilesList=e.target.files;

			for(i=0;i<_this.FilesList.length;i++){
			 	if(!_this.ChekFile(_this.FilesList,i)) return 0;
			}
			
			_this.selected = true;
			_this.EndSelect();

		});

		jQuery(Class).bind( // #drop-block блок куда мы будем перетаскивать наши файлы
			    'dragenter',
			    function(e) {
			        // Действия при входе курсора с файлами  в блок.
			    }) .bind(
			    'dragover',
			    function(e) {
			        // Действия при перемещении курсора с файлами над блоком.
			    }).bind(
			    'dragleave',
			    function(e) {
			        // Действия при выходе курсора с файлами за пределы блока.
			    }).bind(
			    'drop',{el:this},
			    function(e) { // Действия при «вбросе» файлов в блок.
			    if (e.originalEvent.dataTransfer.files.length) {

			        console.log("Файлы выбраны методом drag and drop");

			        // Отменяем реакцию браузера по-умолчанию на перетаскивание файлов.
			        e.preventDefault();
			        e.stopPropagation();

			        // e.originalEvent.dataTransfer.files — массив файлов переданных в браузер.
			        // e.originalEvent.dataTransfer.files[i].size — размер отдельного файла в байтах.
			        // e.originalEvent.dataTransfer.files[i].name — имя отдельного файла.
			        // Что какбэ намекает :-)

			       _this.FilesList=e.originalEvent.dataTransfer.files;

			        for(i=0;i<_this.FilesList;i++){
						if(!_this.ChekFile(_this.FilesList,i)) return 0;
					}
					_this.selected = true;
					_this.EndSelect();
				}
		});

	};

	//	Функция прогресса загрузки файла
	// e.loaded — сколько байтов загружено.
	// e.total — общее количество байтов загружаемых файлов.
	this.Progress = function(e,Index,files){
		return 1;
	};

	//	files - тут будет записан массив файла
	//	e - ответ от сервера
	///////////////////////
	this.EndSave = function(file,e){
		console.log(e);
		return 1;
	};


	//	Сохранить файл на сервер
	//	Index - номер файла в массиве
	//	EndSave будет выполнена после процедуры добавления файла
	this.SaveFile = function(Index,path,allFlag){
		
		var Temp=this.FilesList[Index];

		var http = new XMLHttpRequest();
		// Процесс загрузки
	    if (http.upload && http.upload.addEventListener) {
	        http.upload.addEventListener(
	        'progress',
	        function(e) {
	            if (e.lengthComputable) {
	            	_this.Progress(e,Index,_this.FilesList);
	            }
	         },
	        false
	        );

	        http.onreadystatechange = function (e) {
	            // Действия после загрузки файлов
	            if (this.readyState == 4) { // Считываем только 4 результат, так как их 4 штуки и полная инфа о загрузке находится
	                if(this.status == 200) { // Если все прошло гладко
	                	console.log("SaveFile: сервер вернул 200 ОК");
	                	_this.EndSave(Temp,e.target.response);	                	
					_this.SetRealPath(e.target.response);
	                	if(allFlag==1)_this._SaveAllFile(path);
	                } else {
	                    console.log("Есть овтет ошибка");
	                    // Сообщаем об ошибке загрузки либо предпринимаем меры.
	                }
	            }
	        };

	        http.upload.addEventListener(
	        'error',
	        function(e) {
	        	console.log("error");
	            // Паникуем, если возникла ошибка!
	        });
	    }

	    var form = new FormData(); // Создаем объект формы.

	    console.log("Сохраняю файл: " + this.FilesList[Index].name);
	    form.append('file', this.FilesList[Index]); // Прикрепляем к форме файл
	    form.append('act', "save");
	    form.append('path', path);
	    form.append('oxs_root', _this.RootPath);
	    form.append('back', _this.BackPath);
	    form.append('my_path', _this.MyPath);
	    form.append('OXS_TOKEN_NAME', _this.TN);
	    form.append('OXS_TOKEN', _this.T);


	    http.open('POST',_this.MyPath + "js/dir/ajax_dir.php"); // Открываем коннект до сервера.
	    http.send(form); // И отправляем форму, в которой наши файлы. Через XHR.
	};

	this.CurrentFile=-1;

	this._SaveAllFile = function (path){
		this.SaveAllFile(path);
	}

	//	Сохранить все выбранные файлы на сервер по очереди
	this.SaveAllFile = function (path){

		if(!_this.IfSelected()){
			_this.EndSave(undefined,_this.GetRealPath());
			return 1;
		}

		if(path==undefined) path = _this.path;

		this.CurrentFile++;
		if(this.CurrentFile>=this.FilesList.length){ this.CurrentFile=-1; jQuery(_this.Class).val("");  return 1;}
		this.SaveFile(this.CurrentFile,path,1);
		return 1;
	}

	//	Так как тут есть ожидание события все данные поулчаються через
	//	клбек функцию Func
	this.GetThumbs = function(Index,Func){
		var fr = new FileReader();
		var img = new Image();

		fr.onload = function (){
			img.src = fr.result;
			Func(img,_this.FilesList[Index]);
		};

		if (_this.FilesList[Index]) {
		    fr.readAsDataURL(_this.FilesList[Index]);
		} else {
		   img.src = "";
		}

	};

}
