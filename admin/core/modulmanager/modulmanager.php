<?php

	define("OXS_PROTECT",TRUE);

	class modulmanager extends CoreSingleLib{

		function __construct($Path){
			parent::__construct($Path);
		}

		function ExecModul($Name){				

			if(!Oxs::G("file")->CheckFile($Name)){
				$this->Msg("Не найден модуль ".$Name,"ERROR");
				return ;	
			} 				

			//	подключаем файл модуля
			Oxs::IFO($Name);

			//	строим имя класса модуля
			$Temp_name="".Oxs::G("url")->GetName($Name)."_modul";

			Oxs::G("BD")->Start();		

			//	Вызываем модуль	
			$Temp_name();			

			return Oxs::G("BD")->GetEnd();
		}
	}

?>
