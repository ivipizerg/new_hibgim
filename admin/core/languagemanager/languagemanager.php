<?php

	define("OXS_PROTECT",TRUE);

	class languagemanager extends CoreSingleLib{

		private $LanguageCode="ru";
		private $_Params ;

		function __construct($Path,$Param=null){
			parent::__construct($Path,$Param=null);
		}

		function SetLanguage($LanguageCode="ru"){
			//	Проверяем есть ли такой фаайл языка
			//	Если нет устанавлвиаем язык по умочланию RU		
			if(Oxs::G("file")->CheckFile("admin/languages/".$this->LanguageCode.".php"))
				$this->LanguageCode = $LanguageCode;
			else
				$this->Msg("Не найден файл языка: " . $this->LanguageCode,"ERROR");
		}

		function GetParam($Number){
			if(isset($this->_Params[$Number]))
				return $this->_Params[$Number];
			else
				return null;
		}

		function T(...$Params){
			
			$this->_Params = $Params;

			$Text = $Params[0];
			
			if(Oxs::G("file")->CheckFile("admin/languages/".$this->LanguageCode.".php"))
				include (Oxs::GetBack()."admin/languages/".$this->LanguageCode.".php");	
			else
				$this->Msg("Не найден файл языка: " . $this->LanguageCode,"ERROR");	

			if(isset($$Text)){
				return $$Text;
			}else
				return $Text;	
			
		}
	}

?>
