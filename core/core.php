<?php
	
	if(!defined("OXS_PROTECT"))die("protect");

	/*class FrontCoreLib extends Lib{
		
		function __construct($Path){
			parent::__construct($Path);
		}	

		//	Метод для записи информации в лог
		//	Записывает в общий канал а так же в личный канал библиотеки
		function Msg($Text,$Chanell,$Code=-1){
			$Err=Oxs()->GetLib("logger");
			$Err->AddMessage($Text,"OXS_CMS_FRONT.".$Chanell.",".strtoupper(get_class($this)).".".$Chanell,$Code);
		}
	}

	class FrontCoreMultiLib extends FrontCoreLib{

		protected $Type="multilib";

		//	Констурктор по умолчанию
		function __construct($Path){
			parent::__construct($Path);			
		}

		function Init($Param=NULL){
			return 0;
		}

	}

	class FrontCoreSingleLib extends FrontCoreLib{

		protected $Type="singlelib";

		//	Констурктор по умолчанию
		function __construct($Path){
			parent::__construct($Path);			
		}

	}*/

?>