	<?php
	
	define("OXS_PROTECT",TRUE);

	class templatemanager_css extends CoreSingleLib{		
		
		function __construct($_Path,$Params=null){
			parent::__construct($Path,$Params);	
		}	

		function loadCss($dir,$nameFile){			

			//	тут мы смотрим есть откуда брать данные, если мы выполняемся не в аякс запросе данные доступны напряму
			$template_name = @Oxs::G("current")->getP("templateInfo")["templateName"];
			if(empty($template_name)) $template_name = Oxs::G("templatemanager")->GetTemplateName();		

			//	GetDefaultTemplateName тут должно быть CurrentName	
			echo Oxs::G("dom")->LoadCssOnce( "admin/tpl/" . $template_name . "/css/" . $dir . "/" . $nameFile.".css");
			
		}	
	} 


