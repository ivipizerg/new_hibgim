
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
				
				$T[$key.":".$Fields[$i]["system_name"]] = $this->getD($Fields[$i]["system_name"]); 
				
				//	Обработаем чекбокс
				if($Fields[$i]["type"]=="сheckbox") {
					if($T[$key.":".$Fields[$i]["system_name"]]=="on") 
						$T[$key.":".$Fields[$i]["system_name"]]=1;
					else 
						$T[$key.":".$Fields[$i]["system_name"]]=0;					
				}
				
				//	Обработаем файл
				if($Fields[$i]["type"]=="file") {
					//	Если файл указан
					if(!empty( $this->getD($Fields[$i]["system_name"])) ){

						//	Ищем свободное имя в основнйо папке для файлов
						$Name = Oxs::G("file")->GetFreeName( $this->getD($Fields[$i]["system_name"]),"admin/files/");

						//	Копируем его в постоянную папку
						Oxs::G("file")->Copy("admin/files/tmp/". $this->getD($Fields[$i]["system_name"]), "admin/files/".$Name);

						//	Запишем реальное имя файла
						$this->setD($Fields[$i]["system_name"] , $Name);
						$T[$key.":".$Fields[$i]["system_name"]] = $Name;

						//	Теперь порежем файл если заданы паарметры min_width и min_height
						if(!empty( $Fields[$i]["file_setting"]["min_width"]) && !empty( $Fields[$i]["file_setting"]["min_height"])){							
							$this->Msg("Обрабатываю файл ".$Field[$i]["file_setting"]["min_width"] . " ".$Fields["file_setting"]["min_height"] . " ".$this->getD($Fields[$i]["system_name"]) , "MESSAGE");
							
							$Img = Oxs::L("mimage");
							$Img->SetImage("admin/files/".$Name);
							$Img->ResizeImage($Fields[$i]["file_setting"]["min_width"],$Fields[$i]["file_setting"]["min_height"]);
							$Img->Save("admin/files/l_".$Name);
						}

						//	Теперь порежем файл если заданы паарметры middle_width и middle_height
						if(!empty( $Fields[$i]["file_setting"]["middle_width"]) && !empty( $Fields[$i]["file_setting"]["middle_height"])){							
							$this->Msg("Обрабатываю файл ".$Field[$i]["file_setting"]["middle_width"] . " ".$Fields["file_setting"]["middle_height"] . " ".$this->getD($Fields[$i]["system_name"]) , "MESSAGE");
							
							$Img = Oxs::L("mimage");
							$Img->SetImage("admin/files/".$Name);
							$Img->ResizeImage($Fields[$i]["file_setting"]["middle_width"],$Fields[$i]["file_setting"]["middle_height"]);
							$Img->Save("admin/files/m_".$Name);
						}

						//	Теперь порежем файл если заданы паарметры big_width и big_height
						if(!empty( $Fields[$i]["file_setting"]["big_width"]) && !empty( $Fields[$i]["file_setting"]["big_height"])){							
							$this->Msg("Обрабатываю файл ".$Field[$i]["file_setting"]["big_width"] . " ".$Fields["file_setting"]["big_height"] . " ".$this->getD($Fields[$i]["system_name"]) , "MESSAGE");
							
							$Img = Oxs::L("mimage");
							$Img->SetImage("admin/files/".$Name);
							$Img->ResizeImage($Fields[$i]["file_setting"]["big_width"],$Fields[$i]["file_setting"]["big_height"]);
							$Img->Save("admin/files/b_".$Name);
						}
					}	
				}				
			}	
			
			$this->CurrentID = Oxs::G("DBLIB.IDE")->DB()->Insert( "#__".Oxs::G("datablocks_manager")->RealCurrentBlockName, $T );

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