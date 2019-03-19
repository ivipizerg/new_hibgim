	<?php
	
	define("OXS_PROTECT",TRUE);

	class templatemanager_js extends CoreSingleLib{		
		
		function __construct($_Path,$Params=null){
			parent::__construct($Path,$Params);	
		}	

		function loadJs($dir,$nameFile){
			
			//	тут мы смотрим есть откуда брать данные, если мы выполняемся не в аякс запросе данные доступны напряму
			$template_name =  @Oxs::G("current")->getP("templateInfo")["templateName"];
			if(empty($template_name)) $template_name = Oxs::G("templatemanager")->GetTemplateName();

			//	GetDefaultTemplateName тут должно быть CurrentName	
			echo Oxs::G("dom")->LoadJsOnce( "admin/tpl/" . $template_name . "/JS/" . $dir . "/" . $nameFile.".js");
			
		}	
	} 


 
