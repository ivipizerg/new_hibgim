
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:add");

	class docs_add_end extends default_add{		

		function __construct($Path){	
			parent::__construct($Path);			
		}			
		
		function Exec(){			

			//	Обрабатывам файлы
			print_r($this->getP("files_data"));

			for($i=0;$i<count($this->getP("files_data"));$i++){
				//	Ищем свободное имечко
				$Name = Oxs::G("file")->GetFreeName($this->getP("files_data")[$i]["name"],"files");

				//	Копируем
				Oxs::G("file")->copy("files/tmp/".$this->getP("files_data")[$i]["name"],"files/".$Name);

				$Tmp[$i]["oroginal_name"] =  $this->getP("files_data")[$i]["oroginal_name"];
				$Tmp[$i]["name"] = $Name;
			}

			//	Проверяем все ли скопировано
			if(Oxs::G("logger")->get("ERROR")){
				$this->setAjaxCode(-1);
				$this->SetAjaxText("Ошибка при копировании файлов");
				return ;
			}else{
				//	Если все скопировалось без проблем удаляем временные файлы
				for($i=0;$i<count($this->getP("files_data"));$i++){
					//	Ищем свободное имечко
					$Name = Oxs::G("file")->Delete("files/tmp/".$this->getP("files_data")[$i]["name"]);
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