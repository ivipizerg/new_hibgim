<?php

	class dialog_yes_no extends CoreMultiLib{

		function __construct($_Path,$Params=null){						
			parent::__construct($_Path,$Params);				
		}		

		function AskUser($Text,$farVar){

			$name = "dialog_yes_no";

			$D = Oxs::L("dialog");
			$D->setName("dialog_window_yes_no");
			$D->addText($Text);
			$D->addBr();
			$D->addBr();			
			$D->addButton(Oxs::G("languagemanager")->T("yes"),"oxs_dialog_button_yes_dialog_yes_no",array("style" => "width:70px;"));
			$D->addHtml("&nbsp;&nbsp;");
			$D->addButton(Oxs::G("languagemanager")->T("no"),"oxs_dialog_button_no_dialog_yes_no",array("style" => "width:70px;"));	
			
			Oxs::G("BD")->Start();
			Oxs::G("templatemanager:css")->loadCss("dialog","main");	
			echo $D->build();
			$this->js( "yes_no" , $name ,array( $farVar , $D->getObjectName() ) );						

			$this->SetAjaxCode(2);			
			$this->SetAjaxData("dialog",Oxs::G("BD")->getEnd());
		}	
			
	}