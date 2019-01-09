
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default.tree:position");

	class buttons_position extends default_tree_position{		
		
		function __construct($Path){	
			parent::__construct($Path);					
		}

		function Exec(){	

			//	Информация о меняемом элементе
			$CurrentID = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__oxs:sql` WHERE `id` = 'oxs:id'" , Oxs::G("datablocks_manager")->RealCurrentBlockName  , $this->getP("currentId") )[0];
			//	Получаем элемент ниже которого мы хотим быть
			$changeId = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__oxs:sql` WHERE `id` = 'oxs:id'" , Oxs::G("datablocks_manager")->RealCurrentBlockName  , $this->getP("changeId") )[0];

			//	Если блокнейм разные занчит нам не льязих пермещеать
			if($CurrentID["bid"] != $changeId["bid"]){
				$this->SetAjaxCode(1);
				$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName);		
				
				$this->SetAjaxText(
					Oxs::G("message_window")->Error( 
						Oxs::G("languagemanager")->T("positionTreeChangeErrorWrongBlocksNames")  
					)
				);	

				return TRUE;
			}		

			parent::Exec();	
		}
	}