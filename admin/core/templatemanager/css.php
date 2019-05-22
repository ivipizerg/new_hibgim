	<?php
	
	define("OXS_PROTECT",TRUE);

	class templatemanager_css extends CoreSingleLib{		
		
		function __construct($_Path,$Params=null){
			parent::__construct($Path,$Params);	
		}	

		function loadCss($dir,$nameFile){			

			$template_name = Oxs::G("templatemanager")->getTemplateName();	

			//	GetDefaultTemplateName тут должно быть CurrentName	
			echo Oxs::G("dom")->LoadCssOnce( "admin/tpl/" . $template_name . "/css/" . $dir . "/" . $nameFile.".css");
			
		}	
	} 


