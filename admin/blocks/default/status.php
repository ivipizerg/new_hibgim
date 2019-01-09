<?php
	if(!defined("OXS_PROTECT"))die("protect");

	class default_status extends BlocksSingleLibSelectable{		

		function __construct($Path){	
			parent::__construct($Path);			
		}	

		function Exec(& $Param=null){
			
			if($this->getIds()!=null){
				for($i=0;$i<count($this->getIds());$i++){
					
					//	Получаем текущюу запись
					$Current = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__oxs:sql` WHERE `id` = 'oxs:id'" , Oxs::G("datablocks_manager")->RealCurrentBlockName , $this->getIds()[$i] );

					if($Current[0]["status"]==1){
						Oxs::G("DBLIB.IDE")->DB()->Update("#__".Oxs::G("datablocks_manager")->RealCurrentBlockName,array(
							"status" => 0
						)," WHERE `id` = 'oxs:id'" , $this->getIds()[$i]);
					}else{
							Oxs::G("DBLIB.IDE")->DB()->Update("#__".Oxs::G("datablocks_manager")->RealCurrentBlockName,array(
							"status" => 1
						)," WHERE `id` = 'oxs:id'" , $this->getIds()[$i]);
					}
				}
			}	


			if(Oxs::G("logger")->Get("ERROR")){
				//	Код 1 редирект на nextStep
				$this->SetAjaxCode(-1);			
				//	Сообщение для всплывашки
				$this->SetAjaxText(  Oxs::G("message_window")->ErrorUl( "ERROR" )  );	
				return TRUE;
			}

			//	Код 1 редирект на nextStep
			$this->SetAjaxCode(1);
			//	Куда переходить
			$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName.":display");
			//	Сообщение для всплывашки
			$this->SetAjaxText( Oxs::G("message_window")->Good(Oxs::G("languagemanager")->T("statusChangeGood")) );	

		}		
	}