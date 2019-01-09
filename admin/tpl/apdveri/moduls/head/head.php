<?php

	function head_modul($Param=NULL){		

		echo Oxs::G("dom")->ShowBase();	

		//	Подключаем необходимые билиотеки:
		echo Oxs::G("dom")->JQ();
		echo Oxs::G("dom")->BS();	
		echo Oxs::G("dom")->Ui();

		Oxs::G("dom")->LoadCSSOnce("admin/tpl/apdveri/css/default.css");		
	
			//	Получаем URL и обрабатываем её
		//	Отсекаем все ненужное
		$Request = ltrim(str_replace( Oxs::GetRoot(), "", $_SERVER['REQUEST_URI']),"/");			

		//	Получаем параметры	
		if(empty($Request)){
			$MainAction = "mainPaige";
		}else{
			$MainAction  = Oxs::G("url")->GetName($Request);	
		}		

		

		//	Кладем в хранилище так как дальше этой функции макйнЭкшн будет не доступен
		Oxs::G("storage")->add("MainAction",$MainAction);	
		echo Oxs::G("storage")->JS("storage","storage");	
	}

?>
