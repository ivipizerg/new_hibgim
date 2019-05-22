	<?php
	
	define("OXS_PROTECT",TRUE);

	class templatemanager_js extends CoreSingleLib{		
		
		function __construct($_Path,$Params=null){
			parent::__construct($Path,$Params);	
		}	

		function loadJs($dir,$nameFile){
			
			
			$template_name = Oxs::G("templatemanager")->getTemplateName();

			//	GetDefaultTemplateName тут должно быть CurrentName	
			echo Oxs::G("dom")->LoadJsOnce( "admin/tpl/" . $template_name . "/JS/" . $dir . "/" . $nameFile.".js");
			
		}	
	} 


 
