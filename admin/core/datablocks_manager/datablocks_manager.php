<?php

	define("OXS_PROTECT",TRUE);

	class datablocks_manager extends CoreSingleLib{		
		
		public $CurrentBlock = "";

		public $CurrentBlockName = "";
		public $RealCurrentBlockName = "";
		public $CurrentBlockAction = "";
		public $Params = "";
		public $Type = "";

		function __construct($Path,$Params=null){
			parent::__construct($Path,$Params);
		}

		function FilndBlockName($Current){
			
			//	Если CurrentBlockAction пустое подгрзуаем action по умочланию для блока
			if(empty($this->CurrentBlockAction)){
				$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__blocks` WHERE `system_name` = 'oxs:sql'" , $this->CurrentBlockName)[0];
				$this->CurrentBlockAction = $R["defaultAction"];
				$this->CurrentBlock = $this->CurrentBlock.":".$this->CurrentBlockAction;
			}			
			
			//	Если не найден блок+действие ставим в блок type при этом RealCurrentBlockName будет по режнему не default	
			$this->Msg("Ищу: " . $this->CurrentBlockName.":".$this->CurrentBlockAction. "", "MESSAGE");		
			//	Ищем в самом блоке
			if(!Oxs::isExist($this->CurrentBlockName.":".$this->CurrentBlockAction)){					
				
				$this->Msg("NO", "MESSAGE");		
				
				//	Еси тип блока не стандарный ищем в нестандартном блоке
				if($Current[0]["type"]!="default"){
					$this->CurrentBlockName="default.".$Current[0]["type"];	
				}else{
				//	Если стандартынй сразу ищем тольк ов стандартном	
					$this->CurrentBlockName="default";
				}	

				$this->Msg("Ищу:" . $this->CurrentBlockName.":".$this->CurrentBlockAction."", "MESSAGE");			
					
				if(!Oxs::isExist($this->CurrentBlockName.":".$this->CurrentBlockAction)){	
					$this->Msg(" NO", "MESSAGE");
					//	Првоерить еще стандартное, если мы нестандартные
					if($Current[0]["type"]!="default"){
						$this->CurrentBlockName="default";

						$this->Msg("Ищу:" . $this->CurrentBlockName.":".$this->CurrentBlockAction."", "MESSAGE");		
						if(!Oxs::isExist($this->CurrentBlockName.":".$this->CurrentBlockAction)){
							$this->Msg(" NO", "MESSAGE");						
							$this->SetAjaxCode(-1);
							$this->SetAjaxText(Oxs::G("languagemanager")->T("data_blocks_not_exist",$this->RealCurrentBlockName.":".$this->CurrentBlockAction));
							return null;
						}else{
							$this->Msg("ok3", "MESSAGE");		
						}	
						
					}else{
						$this->Msg(" NO", "MESSAGE");						
						$this->SetAjaxCode(-1);
						$this->SetAjaxText(Oxs::G("languagemanager")->T("data_blocks_not_exist",$this->RealCurrentBlockName.":".$this->CurrentBlockAction));
						return null;
					}	

				}else{
					$this->Msg("Ok2", "MESSAGE");
				}
				
			}else{
				$this->Msg("Ok1", "MESSAGE");		
			}		 
			
			return $this->CurrentBlockName.":".$this->CurrentBlockAction;
		}

		function ExecAction($BlockName,$Params){	
			
			$this->Msg("Исполняю ".$BlockName." параметры \"".$Params."\"","MESSAGE");			

			//	Записываем данные о текущем блоке
			////////////////////////////////////////////////////////////////			
			$this->CurrentBlock = $BlockName;
			$this->CurrentBlockName = (explode(":",$BlockName))[0];
			$this->CurrentBlockAction = (explode(":",$BlockName))[1];	
			$this->RealCurrentBlockName = $this->CurrentBlockName;				

			if(!empty($Params["mode_string"])) {
				mb_parse_str($Params["mode_string"]["value"],$T);	
				$Params["mode_string"]["value"] = $T;
			}

			$this->Params = $Params;

			//	Существет ли такой блок вообще?
			$Current = Oxs::G("blocks:model")->GetAboutBlockByName($this->CurrentBlockName);
			if(!$Current){
				$this->SetAjaxCode(-1);
				$this->SetAjaxText(Oxs::G("languagemanager")->T("data_blocks_not_exist",$BlockName));
				return ;
			}

			$this->Type = $Current[0]["type"];			
						
			//	Опредеяем какой блок подключить 				
			$BlockName = $this->FilndBlockName($Current);	
			if($BlockName==null) return ;

			//	Это необходимо для корректнйо рабоыт кнопки назад
			//	и так как он дальше выкинеться на вывод то мы заодно задаим эти паарметы в сторадж
			$this->SetAjaxData("block_name" , $this->RealCurrentBlockName);
			$this->SetAjaxData("block_action" , $this->CurrentBlockAction);			
		
			//////////////////////////////////////////////////////////////////
			Oxs::G("BD")->Start();				

			//	Даем нашему блоку вызвать и подгрузит ьвсе необходимые ему js файлы
			Oxs::G($BlockName)->LoadMyJS();

			//	Вызываем шапку блока, в которой есть описание и кнопки
			echo Oxs::G($BlockName)->GetHead();	
			
			//	Вызываем блок	
			////////////////////////////////////////////////////
			if(Oxs::G($BlockName)->ExecBefore()!=TRUE)
				if(Oxs::G($BlockName)->Exec()!=TRUE)
					if(Oxs::G($BlockName)->ExecAfter()!=TRUE)
						Oxs::G($BlockName)->Destruct();	
			/////////////////////////////////////////////////////	

			return Oxs::G("BD")->GetEnd();
		}
	}

?>
