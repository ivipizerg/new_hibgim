
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:add_end");

	class docs_add_end extends default_add_end{		

		function __construct($Path){	
			parent::__construct($Path);			
		}			
		
		function Exec(){	

			//	Получаем данные о фильтах
			$Fields = Oxs::G("fields:model")->GetFieldsForBlock();
			$Fields = Oxs::G("fields:model")->findSystemName($Fields,"files");
			$Command = Oxs::G("filters_manager")->ParceFilterString($Fields["filters"]);	

			Oxs::G("BD")->Start();

			for($i=0;$i<count($Command);$i++){
				if($Command[$i]->name == "file_ext"){
					$Ext =  Oxs::G("filters_manager")->EjectValue($Command[$i],"v");
				}

				if($Command[$i]->name == "file_mime"){
					$Mime =  Oxs::G("filters_manager")->EjectValue($Command[$i],"v");
				}
			}

			echo $Ext;
			echo $Mime;

			print_r($Ext);

			$this->Msg(Oxs::G("BD")->getEnd(),"MESSAGE");

			//	Обрабатывам файлы		
			for($i=0,$j=0;$i<count($this->getP("files_data"));$i++){
				
				//	Проверяем расширение файла и mem type


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
		}	
	}