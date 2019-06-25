
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:add_end");

	class docs_add_end extends default_add_end{		

		function __construct($Path){	
			parent::__construct($Path);			
		}			
		
		function Exec(){	

			$Ext = Oxs::G("doc_settings:model")->get("file_ext");
			$Ext = explode(",",trim($Ext,"\""));	

			$mime = Oxs::G("doc_settings:model")->get("mime_type");
			$mime = explode(",",trim($mime,"\""));	

			////////////////////////////////////////////////////////////		

			//	Обрабатывам файлы		
			for($i=0,$j=0;$i<count($this->getP("files_data"));$i++){
				
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

				//	Ищем свободное имечко
				$Name = Oxs::G("file")->GetFreeName($this->getP("files_data")[$i]["oroginal_name"],"files/");

				//	Копируем
				if(Oxs::G("file")->copy("files/tmp/".$this->getP("files_data")[$i]["name"],"files/".$Name)){
					$Tmp[$j]["original_name"] =  $this->getP("files_data")[$i]["oroginal_name"];
					$Tmp[$j++]["name"] = $Name;
				}else{
					$this->Msg("Файл ".($this->getP("files_data")[$i]["oroginal_name"])." уже существует или неизвестная ошибка копирования","ERROR");
				}
			}

			//$this->Msg(Oxs::G("BD")->getEnd(),"MESSAGE");

			//	Проверяем все ли скопировано
			if(Oxs::G("logger")->get("ERROR")){		
				$this->setAjaxCode(-1);
				$this->SetAjaxText(Oxs::G("message_window")->ErrorUl("ERROR"));
				return ;
			}else{
				//	Если все скопировалось без проблем 
				//	Выполняем стандартный алгоритм заполнив предвалительльно поле files
				$this->setD("files",Oxs::G("JSON.IDE")->JSON()->E($Tmp));

				parent::Exec();

				//	удаляем временные файлы
				for($i=0;$i<count($this->getP("files_data"));$i++){					
					Oxs::G("file")->Delete("files/tmp/".$this->getP("files_data")[$i]["name"]);
				}
			}
		}	
	}