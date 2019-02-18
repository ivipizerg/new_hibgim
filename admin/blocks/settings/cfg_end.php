<?php
		
	if(!defined("OXS_PROTECT"))die("protect");	

	class settings_cfg_end extends BlocksSingleLib{

		private $oxs_dialog;

		function __construct($Path,$params=null){			
			parent::__construct($Path,$params);
		}	

		function LoadMyJS(){
			
			$this->oxs_dialog = Oxs::L("dialog");
			
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
				//	Спрашиваем подтверждение
				if( empty($this->getP("oxs_dialog_ask_master_password")) ){

					$D  = new _dialog($this->oxs_dialog->uniqueName);			
					$D->addText("Введите мастер пароль для доступа к файлу конфигурации");
					$D->addBr();
					$D->addBr();
					$D->addPassword("oxs_dialog_ask_master_password_edit_".$this->oxs_dialog->uniqueName,null,"Введите мастер пароль",array( "style" => "width:300px;"  ));				
					$D->addBr();			
					$D->addButton(Oxs::G("languagemanager")->T("ok"),"oxs_dialog_ask_master_password_ok_".$this->oxs_dialog->uniqueName,array("style" => "width:70px;"));
					$D->addHtml("&nbsp;&nbsp;");
					$D->addButton(Oxs::G("languagemanager")->T("cancel"),"oxs_dialog_ask_master_password_cancel_".$this->oxs_dialog->uniqueName,array("style" => "width:70px;"));
					$D->Css("admin/tpl/default/css/dialog.css");			
					$D->js( "settings:cfg_file_edit");				

					$this->oxs_dialog->buildDialog($D);
					
					return TRUE;
				}
			}			
		}
	} 
