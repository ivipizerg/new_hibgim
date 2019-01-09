
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:add_end");

	class default_tree_add_end extends default_add_end{	

		function __construct($Path){	
			parent::__construct($Path);			
		}	
		
		function Exec(){

			$Fields = $this->LoadFields();
			$T=array();

			for($i=0;$i<count($Fields);$i++){	
				if($Fields[$i]["sytem_name"]!="pid"){
					$key = Oxs::G("fields")->convertTypeFroBD($Fields[$i]);
					$T[$key.":".$Fields[$i]["system_name"]] = $this->getD($Fields[$i]["system_name"]); 
				}				
			}	

			$Tree = Oxs::L("DBTree",array("table" => "#__".Oxs::G("datablocks_manager")->RealCurrentBlockName , "db" => Oxs::G("DBLIB.IDE")->DB()));
			$this->CurrentID = $Tree->Insert( $this->getD("pid") , $T);			

			$C = Oxs::L("calendar");

			//	Добавляем даты
			Oxs::G("DBLIB.IDE")->DB()->Update( "#__".Oxs::G("datablocks_manager")->RealCurrentBlockName, array(
				"create_data" => $C->get("getUnix"),
				"update_data" => 0,
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