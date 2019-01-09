
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	class default_position extends BlocksSingleLib{		
		
		function __construct($Path){	
			parent::__construct($Path);					
		}

		function Exec(){	

			if( empty( $this->getP("currentId") ) ||  !Oxs::G("cheker")->id($this->getP("currentId"))){
				$this->SetAjaxCode(1);
				$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName);
				$this->SetAjaxText(Oxs::G("message_window")->Error(Oxs::G("languagemanager")->T("positionChangeErrorcurrentId")));
				return TRUE;
			}

			if( empty($this->getP("changeId")) ||  !Oxs::G("cheker")->id($this->getP("changeId"))  ){
				$this->SetAjaxCode(1);
				$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName);
				$this->SetAjaxText(Oxs::G("message_window")->Error(Oxs::G("languagemanager")->T("positionChangeErrorСhangeId")));
				return TRUE;
			}

			//	Информация о меняемом элементе
			$CurrentID = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__oxs:sql` WHERE `id` = 'oxs:id'" , Oxs::G("datablocks_manager")->RealCurrentBlockName  , $this->getP("currentId") )[0];
			//	Получаем элемент ниже которого мы хотим быть
			$changeId = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__oxs:sql` WHERE `id` = 'oxs:id'" , Oxs::G("datablocks_manager")->RealCurrentBlockName  , $this->getP("changeId") )[0];

			if($CurrentID["position"]==$changeId["position"]){
				$this->SetAjaxCode(-1);
				$this->SetAjaxText(Oxs::G("message_window")->Error(Oxs::G("languagemanager")->T("positionChangeErrorCurrentIdAschangeId")));
				return TRUE;
			}

			//	Тащим вниз
			if($CurrentID["position"] < $changeId["position"]){
				//	Уменьшаем все позиции на 1 выше той под котороую мы хотим встать до той на котороый стоял меняемый элемент
				Oxs::G("DBLIB.IDE")->DB()->Update("#__".Oxs::G("datablocks_manager")->RealCurrentBlockName,array(
					"~sql:position" => " `position` - 1 "
				) , " WHERE `position` <= 'oxs:int' and `position` > 'oxs:id'", $changeId["position"] , $CurrentID["position"]);	

				//	Меняю мой id на id элемента ниже кторого мы хотим стать
				Oxs::G("DBLIB.IDE")->DB()->Update("#__".Oxs::G("datablocks_manager")->RealCurrentBlockName,array(
					"position" => $changeId["position"]
				) , " WHERE `id` = 'oxs:id'", $CurrentID["id"]);	
			}
			
			//	Тащим вверх
			if($CurrentID["position"] > $changeId["position"]){
				//	Уменьшаем все позиции на 1 выше той под котороую мы хотим встать до той на котороый стоял меняемый элемент
				Oxs::G("DBLIB.IDE")->DB()->Update("#__".Oxs::G("datablocks_manager")->RealCurrentBlockName,array(
					"~sql:position" => " `position` + 1 "
				) , " WHERE `position` > 'oxs:int' and `position` <= 'oxs:id'", $changeId["position"] , $CurrentID["position"]);

				//	Меняю мой id на id элемента ниже кторого мы хотим стать
				Oxs::G("DBLIB.IDE")->DB()->Update("#__".Oxs::G("datablocks_manager")->RealCurrentBlockName,array(
					"position" => $changeId["position"] + 1 
				) , " WHERE `id` = 'oxs:id'", $CurrentID["id"]);		
			}		
			

			if(Oxs::G("logger")->Get("ERROR")){
				$this->SetAjaxCode(-1);				
				$this->SetAjaxText(Oxs::G("message_window")->ErrorUl("ERROR"));			
			}else{
				$this->SetAjaxCode(1);
				$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName);
				$this->SetAjaxText(Oxs::G("message_window")->Good(Oxs::G("languagemanager")->T("DefaultpositionChangeGood")));
			}
		}
	}