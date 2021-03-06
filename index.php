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
		"oxs".$OxsVersion."/",	
		"core/",	
		"admin/core/",
		"admin/local/core/",
		"admin/blocks/" ,
		"admin/local/blocks/",
		"admin/filters/",
		"admin/libs/"
	);
	
	//	Стартуем сессию
	session_start();	

	//	Запускаем приложение
	Oxs::G("application_front")->Init();
	Oxs::G("application_front")->Run();
?>
