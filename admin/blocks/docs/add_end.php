
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:add");

	class docs_add_end extends default_add{		

		function __construct($Path){	
			parent::__construct($Path);			
		}			
		
		function Exec(){			

			//	Обрабатывам файлы
			print_r($this->getP("files_data"));


			//parent::Exec();

			/*if(!Oxs::G("logger")->Get("ERROR")){
				$this->SetAjaxCode(1);

				if($this->getP("mode_string")["mode"]==2){
					$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName.":add");
				}else{
					$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName);
				}
				
				$this->SetAjaxText(Oxs::G("message_window")->Good(Oxs::G("languagemanager")->T("defaultAddGood")));
			}else{
				$this->SetAjaxCode(-1);				
				$this->SetAjaxText(Oxs::G("message_window")->ErrorUl("ERROR"));
			}*/
		}	
	}