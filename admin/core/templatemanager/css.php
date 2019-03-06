	<?php
	
	define("OXS_PROTECT",TRUE);

	class templatemanager_css extends CoreSingleLib{		
		
		function __construct($_Path,$Params=null){
			parent::__construct($Path,$Params);	
		}	

		function loadCss($dir,$nameFile){
			
			//	GetDefaultTemplateName тут должно быть CurrentName	
			echo Oxs::G("dom")->LoadCssOnce( "admin/tpl/" . Oxs::G("current")->getP("templateInfo")["templateName"] . "/css/" . $dir . "/" . $nameFile.".css");
			
		}	
	} 


