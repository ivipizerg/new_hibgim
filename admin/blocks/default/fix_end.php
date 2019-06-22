<?php
	if(!defined("OXS_PROTECT"))die("protect");

	class default_fix_end extends BlocksSingleLib{
		
		function __construct($Path){	
			parent::__construct($Path);					
		}	

		function LoadFields(){
			return Oxs::G("fields:model")->GetFieldsForBlock();
		}	

		function ExecBefore(){			
		
			if(!Oxs::G("cheker")->id($this->getP("fixingId")) || empty($this->getP("fixingId"))){
				$this->SetAjaxCode(1);
				$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName);
				$this->SetAjaxText( Oxs::G("message_window")->Error(Oxs::G("languagemanager")->T("noID")) );				
				return TRUE;
			}

			//	Применить фильтры
			//	Поулчаем поля блока
			$Fields = $this->LoadFields();
			//	Выполняем фильтры
			Oxs::G("filters_manager")->Exec($Fields,$this->getD());

			if(Oxs::G("filters_manager")->DecodeFilterMessage()==TRUE){
				$this->SetAjaxCode(-1);	
				return TRUE;
			}
		}	


		function Exec(){

			$Fields = $this->LoadFields();
			
			$T=array();

			for($i=0;$i<count($Fields);$i++){

				$key = Oxs::G("fields")->convertTypeFroBD($Fields[$i]);
				
				//	если поле имеет тип data ы должны перевести переданную дату в Unix формат 
				if($Fields[$i]["type"]=="data"){
					$C = Oxs::L("calendar",$this->getD($Fields[$i]["system_name"]));
					$T[$key.":".$Fields[$i]["system_name"]] = $C->getUnix();
				}else
					$T[$key.":".$Fields[$i]["system_name"]] = $this->getD($Fields[$i]["system_name"]); 
				
				//	Обработаем чекбокс
				if($Fields[$i]["type"]=="сheckbox") {
					if($T[$key.":".$Fields[$i]["system_name"]]=="on") 
						$T[$key.":".$Fields[$i]["system_name"]]=1;
					else 
						$T[$key.":".$Fields[$i]["system_name"]]=0;					
				}
				
			}	

			Oxs::G("DBLIB.IDE")->DB()->Update( "#__".($this->getP( "block_name")), $T , " WHERE `id` = 'oxs:id'" , $this->getP("fixingId"));

			$C = Oxs::L("calendar");

			//	Обновление даты
			Oxs::G("DBLIB.IDE")->DB()->Update( "#__".($this->getP( "block_name")), array(				
				"update_data" => $C->get("getUnix")				
			) , " WHERE `id` = 'oxs:id'" , $this->getP("fixingId") );

			if(!Oxs::G("logger")->Get("ERROR")){				
				
				if($this->getP("mode_string")["mode"]==1){
					$this->SetAjaxCode(-1);						
				}else{
					$this->SetAjaxCode(1);
					$this->SetAjaxData("nextStep",($this->getP( "block_name")));
				}
				
				$this->Msg(Oxs::G("languagemanager")->T("defaultFixGood") , "GOOD" );	
				$this->SetAjaxText(Oxs::G("message_window")->GoodUl("GOOD"));			
			}else{
				$this->SetAjaxCode(-1);				
				$this->SetAjaxText(Oxs::G("message_window")->GoodUl("GOOD").Oxs::G("message_window")->ErrorUl("ERROR"));
			}
		}	
		
	}