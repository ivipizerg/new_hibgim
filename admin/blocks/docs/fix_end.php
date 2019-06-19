
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:fix_end");

	class docs_fix_end extends default_fix_end{		

		function __construct($Path){	
			parent::__construct($Path);			
		}			
		
		function Exec(){				

			//	Получаем данные о фильтах
			////////////////////////////////////////////////////////////
			$Fields = Oxs::G("fields:model")->GetFieldsForBlock();
			$Fields = Oxs::G("fields:model")->findSystemName($Fields,"files");
			$Command = Oxs::G("filters_manager")->ParceFilterString($Fields["filters"]);	

			//Oxs::G("BD")->Start();

			for($i=0;$i<count($Command);$i++){
				if($Command[$i]->name == "file_ext"){
					$Ext =  Oxs::G("filters_manager")->EjectValue($Command[$i],"v");
				}

				if($Command[$i]->name == "file_mime"){
					$Mime =  Oxs::G("filters_manager")->EjectValue($Command[$i],"v");
				}
			}			

			$Ext = explode(",",trim($Ext[0],"\""));	
			////////////////////////////////////////////////////////////	

			//	Разбираемся с файлами
			for($i=0,$j=0;$i<count($this->getP("files_data"));$i++){				

				//	Проверяем не новый ли это файл, для этого проверим лежит ли он в tmp
				if(Oxs::G("file")->isExist("files/tmp/".$this->getP("files_data")[$i]["name"])){

					//	Проверяем расширение файла и mem type
					$access = false;
					for($z=0;$z<count($Ext);$z++){						
						if(Oxs::G("url")->GetExt($this->getP("files_data")[$i]["name"])==$Ext[$z]){
							$access = true;
						}
					}
					
					if(!$access){					
						$this->Msg( Oxs::G("languagemanager")->T("WRONG_EXTENTION_FILE" , $this->getP("files_data")[$i]["oroginal_name"] , Oxs::G("url")->GetExt($this->getP("files_data")[$i]["name"]) ) ,"ERROR.docs_fix_end");						
						continue;
					}

					//	Файл новый копируем его и записываем в массив
					//	Ищем свободное имечко
					$Name = Oxs::G("file")->GetFreeName($this->getP("files_data")[$i]["oroginal_name"],"files/");
					//	Копируем
					if(Oxs::G("file")->copy("files/tmp/".$this->getP("files_data")[$i]["name"],"files/".$Name)){
						$Tmp[$j]["original_name"] =  $this->getP("files_data")[$i]["oroginal_name"];
						$Tmp[$j++]["name"] = $Name;
						$this->Msg("Новый файл ".($this->getP("files_data")[$i]["oroginal_name"])." скопирован успешно","GOOD.docs_fix_end");
						Oxs::G("file")->Delete("files/tmp/".$this->getP("files_data")[$i]["name"]);
					}else{
						$this->Msg("Новый файл ".($this->getP("files_data")[$i]["oroginal_name"])." уже существует или неизвестная ошибка копирования","ERROR.docs_fix_end");
					}
				}else{
					//	Файл уже существует ничего не делаем просто записываем ег ов массив
					$Tmp[$j]["original_name"] =  $this->getP("files_data")[$i]["oroginal_name"];
					$Tmp[$j++]["name"] = $this->getP("files_data")[$i]["name"];
				}	
			}

			//$this->Msg(Oxs::G("BD")->getEnd(),"MESSAGE");

			$this->setD("files",Oxs::G("JSON.IDE")->JSON()->E($Tmp));
			
			parent::Exec();							
		}	
	}