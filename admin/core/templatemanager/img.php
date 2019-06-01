	<?php
	
	define("OXS_PROTECT",TRUE);

	class templatemanager_img extends CoreSingleLib{		
		
		function __construct($_Path,$Params=null){
			parent::__construct($Path,$Params);	
		}	

		function load($dir,$nameFile){			

			$template_name = Oxs::G("templatemanager")->getTemplateName();	

			//	GetDefaultTemplateName тут должно быть CurrentName	
			return  "admin/tpl/" . $template_name . "/img/" . $dir . "/" . $nameFile;
			
		}	
	} 


