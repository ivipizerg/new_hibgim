
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:add_end");

	class docs_add_end extends default_add_end{		

		function __construct($Path){	
			parent::__construct($Path);			
		}			
		
		function Exec(){			

			//	Обрабатывам файлы
			print_r($this->getP("files_data"));

			for($i=0,$j=0;$i<count($this->getP("files_data"));$i++){
				
				//	Ищем свободное имечко
				$Name = Oxs::G("file")->GetFreeName($this->getP("files_data")[$i]["oroginal_name"],"files/");

				//	Копируем
				if(Oxs::G("file")->copy("files/tmp/".$this->getP("files_data")[$i]["name"],"files/".$Name)){
					$Tmp[$j]["oroginal_name"] =  $this->getP("files_data")[$i]["oroginal_name"];
					$Tmp[$j++]["name"] = $Name;
				}else{
					$this->Msg("Файл ".($this->getP("files_data")[$i]["oroginal_name"])." уже существует или неизвестная ошибка копирования","ERROR");
				}
			}

			//	Проверяем все ли скопировано
			if(Oxs::G("logger")->get("docs_add_end.ERROR")){		
				$this->setAjaxCode(-1);
				$this->SetAjaxText(Oxs::G("message_window")->ErrorUl("docs_add_end.ERROR"));
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

			//	Копируем в место постоянного хранения

			//parent::Exec();

			/*if(!Oxs::G("logger")->Get("ERROR")){
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
			}*/
		}	
	}