<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:remove");

	class news_remove extends default_remove{		

		function __construct($Path,$Params=null){	
			parent::__construct($Path,$Params);				
		}

		function ajaxExec($Param){
				
			switch ($Param["action"]){
				case "rm_rmp":
					if(!empty($Param["fix"])){

						//	Мы должны проверить нет ли еще у какой новости этой же минииконки, и если нет то тогда уже удалять
						$H = hash_file('md5', Oxs::GetBack()."files/news_img/".$Param["file"] );
						$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__news` WHERE `img_hash` = 'oxs:sql'" , $H);
						
						Oxs::G("DBLIB.IDE")->DB()->Update("#__news",array(
									"sql:img_hash" => "",
									"sql:mini_img" => ""
							), " WHERE `id` ='oxs:id'" , $Param["fix"] ); 

						if(count($R)>1){
							$this->Msg("Записей болье 1, не трогаем файл", "MESSAGE" );
						}else{
								
							$this->Msg("Запись 1, удаляем файл", "MESSAGE" );	

							if(Oxs::G("file")->isExist("files/news_img/".$Param["file"])){
								Oxs::G("file")->delete("files/news_img/".$Param["file"]);
								$this->Msg(Oxs::G("languagemanager")->T("FILE_DELETED_SUCCESS" , $R[0]["file"] ),"GOOD.img_remove");
								$this->setAjaxCode(1);	
							}
							else{
								$this->Msg(Oxs::G("languagemanager")->T("FILE_NOT_FOUND" , $R[0]["file"] ),"ERROR");
								$this->setAjaxCode(-1);	
							}

							if(Oxs::G("file")->isExist("files/news_img/thumbs/".$Param["file"])){
								Oxs::G("file")->delete("files/news_img/thumbs/".$Param["file"]);
								$this->Msg(Oxs::G("languagemanager")->T("FILE_DELETED_SUCCESS" , $R[0]["file"] ),"GOOD.img_remove");
								$this->setAjaxCode(1);	
							}
							else{
								$this->Msg(Oxs::G("languagemanager")->T("FILE_NOT_FOUND" , $R[0]["file"] ),"ERROR");
								$this->setAjaxCode(-1);	
							}
						}
						
					}else{
						if(Oxs::G("file")->isExist("files/tmp/".$Param["file"])){
							Oxs::G("file")->delete("files/tmp/".$Param["file"]);
							$this->Msg(Oxs::G("languagemanager")->T("FILE_DELETED_SUCCESS" , $R[0]["file"] ),"GOOD.img_remove");
							$this->setAjaxCode(1);	
						}
						else{
							$this->Msg(Oxs::G("languagemanager")->T("FILE_NOT_FOUND" , $R[0]["file"] ),"ERROR");
							$this->setAjaxCode(-1);	
						}
					}
				break;
				default : $this->setAjaxCode(-1);
			}
					
			if(Oxs::G("logger")->get("ERROR")){	
				$this->SetAjaxText(Oxs::G("message_window")->ErrorUl("ERROR").Oxs::G("message_window")->GoodUl("GOOD.img_remove"));
				return ;
			}else{
				$this->SetAjaxText(Oxs::G("message_window")->Good(Oxs::G("languagemanager")->T("ALL_FILE_DELETED_SUCCESS")));
				return ;
			}
		}

		function Exec(){

			if($this->getIds()!=null){
				for($i=0;$i<count($this->getIds());$i++){
					//	Удаляем миникартинку
					$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__".Oxs::G("datablocks_manager")->RealCurrentBlockName."` WHERE `id` = 'oxs:id'" , $this->getIds()[$i] );

					if(Oxs::G("file")->isExist("files/news_img/".$R[0]["mini_img"])){
						Oxs::G("file")->Delete("files/news_img/".$R[0]["mini_img"]);						
					}

					if(Oxs::G("file")->isExist("files/news_img/thumbs/".$R[0]["mini_img"])){
						Oxs::G("file")->Delete("files/news_img/thumbs/".$R[0]["mini_img"]);						
					}					
				}
			}

			parent::Exec();
		}

	}