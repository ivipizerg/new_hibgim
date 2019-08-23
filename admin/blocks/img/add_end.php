<?php

	define("OXS_PROTECT",TRUE);

	Oxs::I("default:add_end");

	class img_add_end extends default_add_end{			

		public $insertID = "";

		function __construct($Path){
			parent::__construct($Path);
		}		

		function ajaxExec($Param){		

			switch($Param["action"]){
				case "save_files": 
					//	Обрежем лишний символ
					$Param["files"] = rtrim($Param["files"],",");

					//	Получаем настройки
					$Ext = Oxs::G("img_settings:model")->get("extention");
					$this->Msg($Ext,"MESSAGE");
					$Ext = explode(",",trim($Ext,"\""));	

					$mime = Oxs::G("img_settings:model")->get("mime_typs");
					$this->Msg($mime,"MESSAGE");
					$mime = explode(",",trim($mime,"\""));	

					//	Перебираем файлы
					$Param["files"] = explode(",",$Param["files"]);
					for($i=0;$i<count($Param["files"]);$i++){
						
						$this->Msg($Param["files"][$i],"MESSAGE");
						
						//	Проверяем есть ли файл
						if(Oxs::G("file")->isExist("files/tmp/".$Param["files"][$i])){
							//	ПРоверяем можно ли сохрнаить данный файл
							$access = false;
							for($z=0;$z<count($mime);$z++){
								if(Oxs::G("file")->getMIME("/files/tmp/".$Param["files"][$i]) == $mime[$z]){
									$access = true;
								}
							}

							$access2 = false;
							for($z=0;$z<count($Ext);$z++){
								if(strtolower(Oxs::G("url")->GetExt($Param["files"][$i]))==strtolower($Ext[$z])){
									$access2 = true;
								}
							}

							if(!$access2 ){					
								$this->Msg( Oxs::G("languagemanager")->T("WRONG_EXTENTION_FILE" , $Param["files"][$i] , Oxs::G("url")->GetExt($Param["files"][$i]) ) ,"ERROR");
								continue;
							}

							if( !$access){					
								$this->Msg( Oxs::G("languagemanager")->T("WRONG_MIME_FILE" , $Param["files"][$i] ,Oxs::G("file")->getMIME("/files/tmp/".$Param["files"][$i]) ) ,"ERROR");
								continue;
							}

							//	Получим даныне о категории, нам нужен путь
							$Cat = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__img_cat` WHERE `id` = 'oxs:id'" , $Param["cat"] );

							//	все гуд ищем свободное имя копируем заносим в базу
							//	Ищем свободное имечко
							$Name = Oxs::G("file")->GetFreeName($Param["files"][$i],"files/img");

							if(Oxs::G("file")->copy("files/tmp/".$Param["files"][$i],$Cat[0]["path"].$Name)){
								//	Отично скопировалось								
								//	Делаем мини иконку
								Oxs::G("files_manager:thumb")->make($Cat[0]["path"].$Name);
								//	Заносим в базу
								$this->insertID = Oxs::G("DBLIB.IDE")->DB()->Insert("#__img",array(
									"sql:file" => $Name,
									"id:cat" => $Param["cat"]
								));

								//	Пишем лог
								$this->Msg("GGGG","GOOD.img_add_end");
							}else{
								$this->Msg("Файл ".($Param["files"][$i])." уже существует или неизвестная ошибка копирования","ERROR");
							}

						}
					}

					if(Oxs::G("logger")->get("ERROR")){		
						$this->setAjaxCode(-1);
						$this->SetAjaxText(Oxs::G("message_window")->ErrorUl("ERROR").Oxs::G("message_window")->GoodUl("GOOD.img_add_end"));
						return ;
					}else{
						$this->SetAjaxText(Oxs::G("message_window")->Good(Oxs::G("languagemanager")->T("IMG_LOAD_SUCCESS")));
						return ;
					}
					
				break;
				default: $this->setAjaxCode(-1);
			}	
		}
	}

?>
 
