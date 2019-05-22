<?php
		
	if(!defined("OXS_PROTECT"))die("protect");	

	class settings_cfg_end extends BlocksSingleLib{

		private $oxs_dialog;

		function __construct($Path,$params=null){			
			parent::__construct($Path,$params);
		}	

		function LoadMyJS(){
			
			$this->oxs_dialog = Oxs::L("dialog.password");
			
		}	

		function Exec(){			

			//	Если есть введенный пароль то проверяем его
			if( !empty($this->getP("oxs_masterPassword")) ){				
				if(sha1($this->getP("oxs_masterPassword")) != Oxs::G("cfg")->get("masterPassword")){					

					//	Код 1 редирект на nextStep
					$this->SetAjaxCode(1);
					//	Куда переходить
					$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName);
					//	Сообщение для всплывашки
					$this->SetAjaxText( "Не верный пароль" );			
					return TRUE;
				}else{
					
					if(!Oxs::G("file")->Access("cfg.php")){
						$this->SetAjaxCode(-1);						
						$this->SetAjaxText(Oxs::G("languagemanager")->T("cfgNotWriteable"));
						return TRUE;
					}					
					
					Oxs::G("file")->Write("cfg.php" , $this->getD("cfg_file") );

					if(!Oxs::G("logger")->Get("ERROR")){
						$this->SetAjaxCode(1);
						$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName);
						$this->SetAjaxText(Oxs::G("languagemanager")->T("defaultFixGood"));
					}else{
						$this->SetAjaxCode(-1);				
						$this->SetAjaxText(Oxs::G("message_window")->ErrorUl("ERROR"));
					}

					return TRUE;
				}	
							
			}else{
				$this->oxs_dialog->askPassword("Введите мастер пароль для доступа к файлу конфигурации","oxs_dialog_ask_master_password");
				return TRUE;
			}			
		}
	} 
