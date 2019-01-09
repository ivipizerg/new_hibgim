 <?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("blocks:fieldsTyps");
	
	class buttons_fieldsTyps extends blocks_fieldsTyps{
		
		function __construct($Path){	
			parent::__construct($Path);	
		}

		function button_displayin_text($Field,$Data){
			Oxs::G("BD")->Start();
			echo $this->text($Field,$Data);
			Oxs::G("oxs_obj")->G("buttons.js:displayin");
			return Oxs::G("BD")->GetEnd();
		}

		function button_action_text($Field,$Data){
			Oxs::G("BD")->Start();
			echo $this->text($Field,$Data);
			Oxs::G("oxs_obj")->G("buttons.js:action");
			return Oxs::G("BD")->GetEnd();
		}
		
	}
 
