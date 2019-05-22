<?php

	class dialog_password extends CoreMultiLib{			
		

		function __construct($_Path,$Params=null){						
			parent::__construct($_Path,$Params);				
		}		

		function askPassword($Text,$farVar){	

			$name = "dialog_password";

			$D = Oxs::L("dialog");
			$D->addText("Введите мастер пароль для доступа к файлу конфигурации");
			$D->addBr();
			$D->addBr();
			$D->addPassword("oxs_dialog_ask_master_password_edit",null,"Введите мастер пароль",array( "style" => "width:300px;"  ));			
			$D->addBr();			
			$D->addButton(Oxs::G("languagemanager")->T("ok"),"oxs_dialog_ask_master_password_ok",array("style" => "width:70px;"));
			$D->addHtml("&nbsp;&nbsp;");
			$D->addButton(Oxs::G("languagemanager")->T("cancel"),"oxs_dialog_ask_master_password_cancel",array("style" => "width:70px;"));	
			
			Oxs::G("BD")->Start();
			Oxs::G("templatemanager:css")->loadCss("dialog","main");	
			echo $D->build();
			$this->js( "password" , $name ,array( $farVar , "notString:".$D->getObjectName() ) );				

			$this->SetAjaxCode(2);			
			$this->SetAjaxData("dialog",Oxs::G("BD")->getEnd());
		}	
			
	}