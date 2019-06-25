
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:fix_end");

	class docs_fix_end extends default_fix_end{		

		function __construct($Path){	
			parent::__construct($Path);			
		}			
		
		function Exec(){				

			$Ext = Oxs::G("doc_settings:model")->get("file_ext");
			$Ext = explode(",",trim($Ext,"\""));	

			$mime = Oxs::G("doc_settings:model")->get("mime_type");
			$mime = explode(",",trim($mime,"\""));	

			////////////////////////////////////////////////////////////	

			//	Разбираемся с файлами
			for($i=0,$j=0;$i<count($this->getP("files_data"));$i++){				

				//	Проверяем не новый ли это файл, для этого проверим лежит ли он в tmp
				if(Oxs::G("file")->isExist("files/tmp/".$this->getP("files_data")[$i]["name"])){

					//	Проверяем расширение файла и mem type
					$access = false;
					for($z=0;$z<count($mime);$z++){
						if(Oxs::G("file")->getMIME("/files/tmp/".$this->getP("files_data")[$i]["name"]) ==$mime[$z]){
							$access = true;
						}
					}

					$access2 = false;
					for($z=0;$z<count($Ext);$z++){
						if(Oxs::G("url")->GetExt($this->getP("files_data")[$i]["name"])==$Ext[$z]){
							$access2 = true;
						}
					}

					if(!$access2 ){					
						$this->Msg( Oxs::G("languagemanager")->T("WRONG_EXTENTION_FILE" , $this->getP("files_data")[$i]["oroginal_name"] , Oxs::G("url")->GetExt($this->getP("files_data")[$i]["name"]) ) ,"ERROR");
						continue;
					}

					if( !$access){					
						$this->Msg( Oxs::G("languagemanager")->T("WRONG_MIME_FILE" , $this->getP("files_data")[$i]["oroginal_name"] ,Oxs::G("file")->getMIME("/files/tmp/".$this->getP("files_data")[$i]["name"]) ) ,"ERROR");
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