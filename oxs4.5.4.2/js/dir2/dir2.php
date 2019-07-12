<?php

if(!defined("OXS_PROTECT"))die("Wrong start point");

class js_dir2 extends SingleLib{	

	function __construct($Path,$params=null){
		parent::__construct($Path,$params);			
	}

	function AjaxExec($Params=null){

		//	Ищем свободное имечко
		$Name = Oxs::G("file")->GetFreeName($_FILES["OXS_DIR2_FILE"]["name"],$_POST["OXS_DIR2_FILE_PATH"]."/");

		Oxs::G("BD")->Start();
		print_r($_FILES);

		$this->Msg(Oxs::G("BD")->getEnd(),"MESSAGE");

		//	Копируем
		Oxs::G("file")->copy($_FILES["OXS_DIR2_FILE"]["tmp_name"],$_POST["OXS_DIR2_FILE_PATH"]."/".$Name);

		//	Проверяем скопировался ли
		if(Oxs::G("logger")->Get("FILE.ERROR")){
			//	Есть ошибка
			$this->setAjaxCode(-1);
		}else{
			//	Сохраняем имя сохраненного файла
			$this->setAjaxData("file_name",$Name);
			$this->setAjaxData("original_file_name",$_FILES["OXS_DIR2_FILE"]["name"]);
			$this->setAjaxCode(1);
		}		
	}

	
	function GetObject( $Name="js_dir",$Params=null ){
		
		if(empty($Params["log"]))$Params["log"]=true;	

		Oxs::GetLib("dom")->jQuery();		

		//	Обькт для отправки запросов
		Oxs::G("js.ajaxexec")->GetObject("aj_dir2",array( "window_name" => $Params["window_name"] ));

		//	События
		Oxs::G("js.loader")->GetObject("js.oxs_events",null,"js_dir2_events");	

		if(ini_get("post_max_size")>ini_get("upload_max_filesize")){
			$MAX_SIZE = ini_get("post_max_size"); 
		}else{
			$MAX_SIZE = ini_get("upload_max_filesize");
		}

		$MU = $Params["MAX_UPLOAD"];
		$MS = $Params["MAX_SIZE"];	

		if(empty($MU)) $MU = ini_get("max_file_uploads");
		if(empty($MS)) $MS = $MAX_SIZE;	

		Oxs::G("js.loader")->GetObject(
			"js.dir2",
			array(
				"aj_dir2",
				"notString:".$Params["log"],
				$MS,
				$MU			
			),
			$Name);
		
	}
}