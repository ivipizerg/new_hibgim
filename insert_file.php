<?php

	//	Создаем защитную перменную
	define("OXS_CMS_PROTECT",true);

	$OxsVersion = "4.5.4.2";

	//	Иницализируем рабочую среду
	////////////////////////////////////////////////////
	include("oxs".$OxsVersion."/oxs_fw.php");

	Oxs::Start();
	Oxs::SetRoot("hibgim/");
	
	Oxs::setSourses(
		"oxs".$OxsVersion."/"		
	);	
	
	Oxs::G("DBLIB.IDE")->Init();	

	$URL = str_replace(Oxs::GetRoot(),"",$_SERVER['REQUEST_URI']);
	$URL = str_replace("/insert_file.php","",$URL);
	$URL = trim($URL,"/");	

	$URL = explode("/",$URL);		

	//	Получаем файл
	switch($URL[0]){
		case "original":

			$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__img` WHERE `id` = 'oxs:id'" , $URL[1] );			

			$IMG = Oxs::L("mimage");

			if(!$R){
				$IMG->setImage("admin/tpl/default/img/image-not-found.png");
			}else{
				$IMG->setImage("files/img/".$R[0]["file"]);
			}			
			
			echo $IMG->Show();

		break;
		case "thumb":
			$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__img` WHERE `id` = 'oxs:id'" , $URL[1] );			

			$IMG = Oxs::L("mimage");

			if(!$R){
				$IMG->setImage("admin/tpl/default/img/image-not-found.png");
			}else{
				$IMG->setImage("files/img/thumbs/".$R[0]["file"]);
			}			
			
			echo $IMG->Show();
		break;
	}
	
	
	
	

