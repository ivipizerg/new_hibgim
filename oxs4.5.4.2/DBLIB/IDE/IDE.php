<?php

	if(!defined("OXS_PROTECT"))die("Wrong start point");

	class DBLIB_IDE extends SingleLib{

		private $DB=NULL;
		private $Cfg;

		function __construct($Path){
			parent::__construct($Path);
		}

		function Init( $Cfg = "cfg.php" ){	
			$this->Cfg=$Cfg;	
			if($this->DB==NULL){
				$this->DB=Oxs::LoadLib("DBLIB.DB",array("cfg_file" => $Cfg));
				$this->Msg("Инициализирую оболочку базы данных", "GOOD");
			}
		}

		function SetDB(DBLIB_DB $_DB){
			$this->DB = $_DB;
			$this->Msg("Связываю оболчку с существующей базой данных", "GOOD");
		}

		function DB(){
			if($this->DB==NULL){
				//	После этой ошибки дальнейшая работа не возможна
				Oxs::Error("База данных не инициализирована"); 				
				return 0;
			}
			return $this->DB;
		}

		function getTmpDB(){
			return Oxs::LoadLib("DBLIB.DB",array("cfg_file" => $this->Cfg));
		}

	}
?>
