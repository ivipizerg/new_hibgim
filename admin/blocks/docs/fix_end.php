
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:fix_end");

	class docs_fix_end extends default_fix_end{		

		function __construct($Path){	
			parent::__construct($Path);			
		}			
		
		function Exec(){				

			//	Разбираемся с файлами
			for($i=0,$j=0;$i<count($this->getP("files_data"));$i++){				

				echo "files/tmp/".$this->getP("files_data")[$i]["name"];

				//	Проверяем не новый ли это файл, для этого проверим лежит ли он в tmp
				if(Oxs::G("file")->isExist("files/tmp/".$this->getP("files_data")[$i]["name"])){
					//	Файл новый копируем его и записываем в массив
					//	Ищем свободное имечко
					$Name = Oxs::G("file")->GetFreeName($this->getP("files_data")[$i]["oroginal_name"],"files/");
					//	Копируем
					if(Oxs::G("file")->copy("files/tmp/".$this->getP("files_data")[$i]["name"],"files/".$Name)){
						$Tmp[$j]["original_name"] =  $this->getP("files_data")[$i]["oroginal_name"];
						$Tmp[$j++]["name"] = $Name;
						$this->Msg("Новый файл ".($this->getP("files_data")[$i]["oroginal_name"])." скопирован успешно","GOOD");
						Oxs::G("file")->Delete("files/tmp/".$this->getP("files_data")[$i]["name"]);
					}else{
						$this->Msg("Новый файл ".($this->getP("files_data")[$i]["oroginal_name"])." уже существует или неизвестная ошибка копирования","ERROR");
					}
				}else{
					//	Файл уже существует ничего не делаем просто записываем ег ов массив
					$Tmp[$j]["original_name"] =  $this->getP("files_data")[$i]["oroginal_name"];
					$Tmp[$j++]["name"] = $this->getP("files_data")[$i]["name"];
				}	
			}

			$this->setD("files",Oxs::G("JSON.IDE")->JSON()->E($Tmp));
			parent::Exec();
			
			$this->setAjaxCode(3);
			//$this->setAjaxData("nextStep","");
			$this->SetAjaxText(Oxs::G("message_window")->ErrorUl("docs_fix_end.ERROR").Oxs::G("message_window")->GoodUl("docs_fix_end.GOOD"));			
		}	
	}