
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::G("default:add_end");

	class content_add_end extends default_add_end{
		
		protected $CurrentID;		

		function __construct($Path){	
			parent::__construct($Path);			
		}			
		
		function Exec(){
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