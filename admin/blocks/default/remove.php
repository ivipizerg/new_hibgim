<?php
	if(!defined("OXS_PROTECT"))die("protect");

	class default_remove extends BlocksSingleLibSelectable{	

		private $oxs_remove_dialog;

		function __construct($Path){	
			parent::__construct($Path);			
		}		

		function LoadMyJS(){
			$this->oxs_remove_dialog = Oxs::L("dialog.yes_no");		
		}	

		function ExecBefore(){	
			
			if(parent::ExecBefore()) return TRUE;

			//	Спрашиваем подтверждение
			if( empty($this->getP("oxs_dialog_ask_yes")) ){
				$this->oxs_remove_dialog->AskUser(Oxs::G("languagemanager")->T("areYouShureDelete"),"oxs_dialog_ask_yes");				
				return TRUE;
			}
		}

		function Exec(){

			$Fields = $this->LoadFields();			

			if($this->getIds()!=null){
				for($i=0;$i<count($this->getIds());$i++){
					Oxs::G("DBLIB.IDE")->DB()->Remove("#__".Oxs::G("datablocks_manager")->RealCurrentBlockName , " WHERE `id` = 'oxs:id'" , $this->getIds()[$i]);
				}
			}

			if(Oxs::G("logger")->get("ERROR")){
				$this->SetAjaxCode(-1);
				$this->SetAjaxText( Oxs::G("message_window")->ErrorUl( "ERROR" ) ) ;
			}else{
				//	Код 1 редирект на nextStep
				$this->SetAjaxCode(1);
				//	Куда переходить
				$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName);
				//	Сообщение для всплывашки
				$this->SetAjaxText( Oxs::G("languagemanager")->T( "removeGood" ) );					
			}			
		}			
	}