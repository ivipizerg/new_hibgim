<?php

if(!defined("OXS_PROTECT"))die("Wrong start point");

class js_dir2 extends SingleLib{	

	function __construct($Path,$params=null){
		parent::__construct($Path,$params);			
	}

	function AjaxExec($Params=null){

		/*if($Params["action"] == "checkWritable"){
			if(Oxs::G("file")->ifWritable($Params["path"])){
				$this->SetAjaxCode(1);			
			}else{
				$this->SetAjaxCode(0);
			}
			return ;
		}*/

		/*if(!Oxs::G("file")->ifWritable($Params["path"])){
			$this->SetAjaxCode(0); return ;			
		}*/	

		//	Ищем свободное имечко
		$Name = Oxs::G("file")->GetFreeName($_FILES["OXS_DIR2_FILE"]["name"],$_POST["OXS_DIR2_FILE_PATH"]."/");

		//	Копируем
		Oxs::G("file")->copy($_FILES["OXS_DIR2_FILE"]["tmp_name"],$_POST["OXS_DIR2_FILE_PATH"]."/".$Name);


		//	Проверяем скопировался ли
		if(Oxs::G("logger")->Get("FILE.ERROR")){
			//	Есть ошибка
			$this->setAjaxCode(-1);
		}else{
			//	Сохраняем имя сохраненного файла
			$this->setAjaxData("file_name",$Name);
			$this->setAjaxData("first_name_file_name",$_POST["OXS_DIR2_FILE_PATH"]);
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

		Oxs::G("js.loader")->GetObject(
			"js.dir2",
			array(
				"aj_dir2",
				"notString:".$Params["log"],
				ini_get("post_max_size"),
				ini_get("upload_max_filesize"),
				ini_get("max_file_uploads")			
			),
			$Name);
		
	}
}