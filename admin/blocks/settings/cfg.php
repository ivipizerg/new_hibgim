<?php
		
	if(!defined("OXS_PROTECT"))die("protect");	

	Oxs::G("default:add");

	class settings_cfg extends default_add{

		private $oxs_dialog;

		function __construct($Path,$params=null){			
			parent::__construct($Path,$params);			
		}	

		function LoadMyJS(){
			
			$this->oxs_dialog = Oxs::L("dialog.password");		;

			Oxs::G("js.loader")->GetObject("default.js:active_buttons");
			Oxs::G("js.loader")->GetObject("default.js:add");	
			
		}	

		function map(){
			if(Oxs::G("file")->Access("cfg.php")){
				return "<div style='color:green;'>Файл cfg.php доступен для записи</div>".parent::map();
			}else{
				return "<div style='color:red;'>".Oxs::G("languagemanager")->T("cfgNotWriteable")."</div>".parent::map();
			}			
		}
		

		function LoadFields(){
			return array( 0 => array ("system_name"=>"cfg_file" , "form_name" => "Файл конфигурации " , "filters" => "style /v \"width:700px; height:450px;\"" , "filter_context" => "add" ,  "description" => "Файл конфигурации сайта(ВНИМАНИЕ!!! неверные настройки могут сделать сайт неработоспособным)" ,"type" => "textArea" ) );
		}		
		
		function GetData(& $Param=null){
			return array( 0 => array( "cfg_file" => Oxs::G("file")->Read("cfg.php") ) );
		}

		function ExecBefore(){

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

				}	
							
			}else{
				//	Спрашиваем подтверждение				
				$this->oxs_dialog->askPassword("Введите мастер пароль для доступа к файлу конфигурации","oxs_dialog_ask_master_password");
				return TRUE;				
			}
		}
		
	}