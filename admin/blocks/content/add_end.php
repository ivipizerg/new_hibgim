
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::G("default:add_end");

	class content_add_end extends default_add_end{
		
		protected $CurrentID;		

		function __construct($Path){	
			parent::__construct($Path);			
		}			
		
		function Exec(){		
			
			//	Обработка textarea_edit, нужно найти все втсавки файлов и вырезать ненужное
			preg_match_all( "(<span.*?span>)", $this->getP("textarea_edit") , $M );	
			
			$txt = $this->getP("textarea_edit");

			for($i=0;$i<count($M[0]);$i++){
				preg_match_all( "/insert=\"(.*?)\"/", $M[0][$i] , $m );	

				//	Заменяем тег на секретный тег
				$txt = str_replace($M[0][$i], "{OXS_FILE_DOCUMENT ".$m[1][0]."}" , $txt);
			}			

			$this->setD( "text" , $txt );

			parent::Exec();

			//	Если были заданы даты то изменяем их
			if(!empty($this->getD("create_data"))){
					
				$C = Oxs::L("calendar" , $this->getD("create_data") );	

				Oxs::G("DBLIB.IDE")->DB()->Update("#__content",array(
					"create_data" => $C->getUnix()
				), " WHERE `id` ='oxs:id'" , $this->CurrentID );
			}

			//	Если были заданы даты то изменяем их
			if(!empty($this->getD("update_data"))){
					
				$C = Oxs::L("calendar" , $this->getD("update_data") );	

				Oxs::G("DBLIB.IDE")->DB()->Update("#__content",array(
					"update_data" => $C->getUnix()
				), " WHERE `id` ='oxs:id'" , $this->CurrentID );
			}
		}	
	}