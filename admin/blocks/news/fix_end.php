
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::G("default:fix_end");

	class news_fix_end extends default_fix_end{
		
		protected $CurrentID;		

		function __construct($Path){	
			parent::__construct($Path);			
		}			
		
		function Exec(){	

			//	Понимаем чо делать с миникартинкой, если она задана а в базе пусто
			//	Занчит была заменена

			$this->setD( "mini_img" , $this->getP("data-fix-file-name") );	

			//	Смотрим есть ли миниизображение
			if($this->getP("data-file")!=""){
				
				$this->Msg("Обрабатываем иконку","MESSAGE");

				if($this->getP("data-file-form-img")=="false" || empty($this->getP("data-file-form-img"))){
					$Path = "files/tmp/";
				}else{
					$Path = "files/img/";
				}

				//	Получаем настройки
				$Ext = Oxs::G("img_settings:model")->get("extention");
				$this->Msg($Ext,"MESSAGE");
				$Ext = explode(",",trim($Ext,"\""));	

				$mime = Oxs::G("img_settings:model")->get("mime_typs");
				$this->Msg($mime,"MESSAGE");
				$mime = explode(",",trim($mime,"\""));	

				if(Oxs::G("file")->isExist($Path.$this->getP("data-file"))){
					//	ПРоверяем можно ли сохрнаить данный файл
					$access = false;
					for($z=0;$z<count($mime);$z++){
						if(Oxs::G("file")->getMIME($Path.$this->getP("data-file")) == $mime[$z]){
							$access = true;
						}
					}

					$access2 = false;
					for($z=0;$z<count($Ext);$z++){
						if(Oxs::G("url")->GetExt($this->getP("data-file"))==$Ext[$z]){
							$access2 = true;
						}
					}

					if(!$access2 ){					
						$this->Msg( Oxs::G("languagemanager")->T("WRONG_EXTENTION_FILE" , $this->getP("data-original-file") , Oxs::G("url")->GetExt($this->getP("data-original-file")) ) ,"ERROR");
						$this->setAjaxCode(-1);
						$this->SetAjaxText(Oxs::G("message_window")->ErrorUl("ERROR").Oxs::G("message_window")->GoodUl("ERROR"));
						return FALSE;
					}

					if( !$access){					
						$this->Msg( Oxs::G("languagemanager")->T("WRONG_MIME_FILE" , $this->getP("data-original-file") , Oxs::G("file")->getMIME($Path.$this->getP("data-original-file")) ) ,"ERROR");
						$this->setAjaxCode(-1);
						$this->SetAjaxText(Oxs::G("message_window")->ErrorUl("ERROR").Oxs::G("message_window")->GoodUl("ERROR"));
						return FALSE;
					}

					//	все гуд ищем свободное имя копируем заносим в базу
					//	Ищем свободное имечко
					$Name = Oxs::G("file")->GetFreeName($this->getP("data-file"),"files/news_img");

					//	Проверим нет ли уже картинки с таким хешем
					$H = hash_file('md5', Oxs::GetBack().$Path.$this->getP("data-file") );
					$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__news` WHERE `img_hash` = 'oxs:sql' and `id` != 'oxs:id'" , $H , $this->getP("fixingId") );
					if(  $R	 ){
						$this->setD( "mini_img" , $R[0]["mini_img"] );		
						$Hash = $R[0]["img_hash"];
						$this->Msg("Файл иконки уже загружен, новый файл не будет скопирован","WARNING");
					}else{
						if(Oxs::G("file")->copy($Path.$this->getP("data-file"),"files/news_img/".$Name)){
							//	Отично скопировалось								
							//	Делаем мини иконку
							Oxs::G("files_manager:thumb")->make("files/news_img/".$Name);	
							$this->setD( "mini_img" , $Name );		
							$Hash = hash_file('md5', Oxs::GetBack()."/files/news_img/".$Name );	

							//	Добавляем картинку в блок img
							if($this->getP("data-file-form-img")=="false" || empty($this->getP("data-file-form-img"))){
								 Oxs::G("DBLIB.IDE")->DB()->Insert("#__img",array(
								 	"sql:file" => $Name,
								 	"id:cat" => 6
								 ));	
							}

						}else{
							$this->Msg("Файл ".($this->getP("data-original-file"))." уже существует или неизвестная ошибка копирования","ERROR");
							$this->setAjaxCode(-1);
							return FALSE;
						}
					}					
				}

				Oxs::G("DBLIB.IDE")->DB()->Update("#__news",array(
					"sql:img_hash" => $Hash
				), " WHERE `id` ='oxs:id'" , $this->getP("fixingId") ); 
			}else{
				$this->Msg("Нет иконки" . $this->getD( "mini_img" ),"MESSAGE");
			}

			//	Обработка textarea_edit, нужно найти все втсавки файлов и вырезать ненужное
			/*preg_match_all( "(<span.*?span>)", $this->getP("textarea_edit") , $M );	
			
			$txt = $this->getP("textarea_edit");

			for($i=0;$i<count($M[0]);$i++){
				preg_match_all( "/insert=\"(.*?)\"/", $M[0][$i] , $m );	

				//	Заменяем тег на секретный тег
				$txt = str_replace($M[0][$i], "{OXS_FILE_DOCUMENT ".$m[1][0]."}" , $txt);
			}			
*/
			$this->setD( "text" , $this->getP("textarea_edit") );

			parent::Exec();				

			//	Если были заданы даты то изменяем их
			if(!empty($this->getD("create_data"))){
					
				$C = Oxs::L("calendar" , $this->getD("create_data") );	

				Oxs::G("DBLIB.IDE")->DB()->Update("#__news",array(
					"create_data" => $C->getUnix()
				), " WHERE `id` ='oxs:id'" , $this->getP("fixingId") );
			}

			//	Если были заданы даты то изменяем их
			if(!empty($this->getD("update_data"))){
					
				$C = Oxs::L("calendar" , $this->getD("update_data") );	

				Oxs::G("DBLIB.IDE")->DB()->Update("#__news",array(
					"update_data" => $C->getUnix()
				), " WHERE `id` ='oxs:id'" , $this->getP("fixingId") );
			}
		}	
	}