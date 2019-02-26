	<?php
	
	define("OXS_PROTECT",TRUE);

	class templatemanager_css extends CoreSingleLib{		
		
		function __construct($_Path,$Params=null){
			parent::__construct($Path,$Params);	
		}	

		function loadCss($dir,$nameFile){
			
			echo Oxs::G("templatemanager")->getTemplateName() . "/" . $nameFile;
			echo Oxs::G("dom")->LoadCssOnce( Oxs::G("templatemanager")->getTemplateName() . "/" . $nameFile );
			
		}	
	} 


