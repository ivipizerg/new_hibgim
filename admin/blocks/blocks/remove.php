<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::G("default:remove");

	class blocks_remove extends default_remove{				

		function __construct($Path){	
			parent::__construct($Path);			
		}	

		function Exec(& $Param=null){	
			
			$Tree=Oxs::L("DBTree",array("db" => Oxs::G("DBLIB.IDE")->DB(), "table" => "#__blocks"));	

			if($this->getIds()!=null){
				
				for($i=0;$i<count($this->getIds());$i++){
					//	Проверим нет ли у блока потомков, если они есть то удалять блок не льзя
					if($Tree->GetChildsEx($this->getIds()[$i])!=NULL){
						//	Код 1 редирект на nextStep
						$this->SetAjaxCode(-1);
						$this->SetAjaxText(  Oxs::G("languagemanager")->T("cantDeleteBlockItHaveChilds")  );		
						return TRUE;
					}
				}				

				for($i=0;$i<count($this->getIds());$i++){				

					//	Получаем информацию об удаляемом блоку
					$CurrentBlock = Oxs::G("blocks:model")->GetAboutBlockById($this->getIds()[$i])[0];

					if(!$CurrentBlock){
						$this->Msg(Oxs::G("languagemanager")->T("data_blocks_id_not_exist",$this->getIds()[$i]),"ERROR");
					}else{
						//	Удаляем запись из таблицы блоков
						$Tree->Remove($this->getIds()[$i]);

						//	Удаляем все поля блока
						Oxs::G("DBLIB.IDE")->DB()->Remove("#__fields"," WHERE `block_name` = 'oxs:sql'" , $CurrentBlock["system_name"]);

						//	Удаляем кнопки
						////////////////////////////////////////////////////////////////////////////
						$TreeButtons=null;
						$TreeButtons=Oxs::L("DBTree",array("db" => Oxs::G("DBLIB.IDE")->DB(), "table" => "#__buttons"));

						//	Получаем все кнопки
						$Buttons = FALSE;
						$Buttons = Oxs::G("DBLIB.IDE")->DB()->Exec( "SELECT * FROM `#__buttons` WHERE `bid` = 'oxs:id'" , $this->getIds()[$i] );

						if($Buttons){
							for($j=0;$j<count($Buttons);$j++){
								$TreeButtons->Remove($Buttons[$j]["id"]);
							}
						}

						//	Удаляем таблицу блока
						Oxs::G("DBLIB.IDE")->DB()->Exec( "DROP TABLE `#__oxs:sql`;" , $CurrentBlock["system_name"] );

						$this->Msg(Oxs::G("languagemanager")->T("dataBlockRemovededSuccess",$CurrentBlock["name"]),"GOOD_blocks_remove");
						////////////////////////////////////////////////////////////////////////////						
					}
				}	

				//	Проверяем были ли ошибки
				if(Oxs::G("logger")->get("ERROR")){
					$this->SetAjaxCode(-1);
					$this->SetAjaxText( 
						Oxs::G("message_window")->ErrorUl( "ERROR" ) .
						Oxs::G("message_window")->Error( Oxs::G("languagemanager")->T("BAD_blocks_remove"))  
					) ;
				}else{
					//	Код 1 редирект на nextStep
					$this->SetAjaxCode(1);
					//	Куда переходить
					$this->SetAjaxData("nextStep","blocks:display");
					//	Сообщение для всплывашки
					$this->SetAjaxText( Oxs::G("message_window")->Good( Oxs::G("languagemanager")->T("GOOD_blocks_remove") ) );					
				}			
			}				
		}
	}