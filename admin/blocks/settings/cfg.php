<?php
		
	if(!defined("OXS_PROTECT"))die("protect");

	//	Наследуемся от стандартного блока вывода
	Oxs::I("default:add");

	class settings_cfg extends default_add{

		function __construct($Path,$params=null){			
			parent::__construct($Path,$params);			
		}	

		function map(){
			if(Oxs::G("file")->Access("cfg.php")){
				return "<div style='color:green;'>Файл cfg.php доступен для записи</div>".parent::map();
			}else{
				return "<div style='color:red;'>".Oxs::G("languagemanager")->T("cfgNotWriteable")."</div>".parent::map();
			}			
		}
		

		function LoadFields(){
			return array( 0 => array ("system_name"=>"cfg_file" , "form_name" => "Файл конфигурации " , "filters" => "style /v \"width:700px; height:450px;\"" , "filter_group" => "add" ,  "description" => "Файл конфигурации сайта(ВНИМАНИЕ!!! неверные настройки могут сделать сайт неработоспособным)" ,"type" => "textArea" ) );
		}		
		
		function GetData(& $Param=null){
			return array( 0 => array( "cfg_file" => Oxs::G("file")->Read("cfg.php") ) );
		}

		function ExecBefore(){

			//	Если пусто выводим фомру
			if(empty($Params["masterPassword"])){
				Oxs::G("show_form")->ShowForm(Oxs::G("settings:cfg_forms")->GetMasterPasswordForm());
				return TRUE;
			}

			//	если не равны выводим ошибку
			if($Params["masterPassword"]!=Oxs::G("cfg")->get("masterPassword")){	
				$this->SetAjaxCode(-1);						
				$this->SetAjaxText(Oxs::G("languagemanager")->T("enterMasterPasswordWrong"));
				$this->AddAjaxData("clear","masterPassword");					
				return TRUE;
			}

			//	Если все ок нам нужно крыть окно
			?>
				<script type="text/javascript">
					oxs_black_screen.Off();	
				</script>
			<?php
			
		}
		
	}