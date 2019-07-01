
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	class default_add_end extends BlocksSingleLib{
		
		protected $CurrentID;		

		function __construct($Path){	
			parent::__construct($Path);			
		}	

		function getLastId(){
			return $this->CurrentID;
		}	

		//	Выполянем фильтры
		function ExecBefore(){
			//	Поулчаем поля блока
			$this->Fields = $this->LoadFields();
			//	Выполняем фильтры
			Oxs::G("filters_manager")->Exec($this->Fields,$this->getD());

			if(Oxs::G("filters_manager")->DecodeFilterMessage()==TRUE){
				$this->SetAjaxCode(-1);	
				return TRUE;
			}
				
		}
		
		function Exec(){			

			$Fields = $this->Fields ;
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
			
			$this->CurrentID = Oxs::G("DBLIB.IDE")->DB()->Insert( "#__".Oxs::G("datablocks_manager")->RealCurrentBlockName, $T );

			$C = Oxs::L("calendar");

			//	Добавляем даты
			Oxs::G("DBLIB.IDE")->DB()->Update( "#__".Oxs::G("datablocks_manager")->RealCurrentBlockName, array(
				"create_data" => $C->get("getUnix"),
				"update_data" => $C->get("getUnix"),
				"position" => $this->CurrentID
			) , " WHERE `id` = 'oxs:id'" , $this->CurrentID );

			//	Если был передан первый режим включаем обьект
			if($this->getP("mode_string")["mode"]==1){
				Oxs::G("DBLIB.IDE")->DB()->Update( "#__".Oxs::G("datablocks_manager")->RealCurrentBlockName, array(
					"status" => 1,				
				) , " WHERE `id` = 'oxs:id'" , $this->CurrentID );
			}

			if(!Oxs::G("logger")->Get("ERROR")){
				$this->SetAjaxCode(1);

				if($this->getP("mode_string")["mode"]==2){
					$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName.":add");
				}else{
					$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName);
				}
				
				$this->SetAjaxText(Oxs::G("message_window")->Good(Oxs::G("languagemanager")->T("defaultAddGood")));
			}else{
				$this->SetAjaxCode(-1);				
				$this->SetAjaxText(Oxs::G("message_window")->ErrorUl("ERROR"));
			}
		}	
	}