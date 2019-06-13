<?php


	if(!defined("OXS_PROTECT"))die("Wrong start point");

	class JSON extends MultiLib{

		private $Mass;

		function __construct($Path){
			parent::__construct($Path);
		}

		function Add($Value,$Fields="value"){
			if(is_array($Value)){				
				$this->Mass[$Fields] = $Value;
			}else{			
				$this->Mass[$Fields] = $this->Mass[$Fields].$Value;
			}
		}

		function GetJSON(){
			return json_encode($this->Mass);
		}

		function GetJSONWithLog($AppEnd=NULL){

			if($AppEnd!=NULL) $AppEnd="<br>".$AppEnd;

			Oxs::G("BD")->Start();
			Oxs::ShowLog(false);
			$this->Mass["logger"]=$this->Mass["logger"].Oxs::G("BD")->GetEnd()."".$AppEnd;
			return json_encode($this->Mass);
		}

		//	legacy
		static function GetFromJSON($Text){			
			return json_decode($Text,true);
		}

		//	legacy
		static function GetFromText($JSON){
			return json_encode($JSON);
		}	

		static function E($JSON){
			return json_encode($JSON);
		}

		static function D($JSON){
			return json_decode($JSON);
		}

	}

?>
