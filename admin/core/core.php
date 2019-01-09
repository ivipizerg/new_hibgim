<?php

	define("OXS_PROTECT",TRUE);

	class CoreLib extends Lib{

		function __construct($Path,$params=null){
			parent::__construct($Path,$params);
		}

		//	Метод для записи информации в лог
		//	Записывает в общий канал а так же в личный канал библиотеки
		/*function Msg($Text,$Chanell,$Code=-1){
			$Err=Oxs()->GetLib("logger");
			$Err->AddMessage($Text,"OXS_CMS.".$Chanell.",".strtoupper(get_class($this)).".".$Chanell,$Code);
		}*/
	}


	class CoreMultiLib extends CoreLib{

		protected $oxs_Type="multilib";

		//	Констурктор по умолчанию
		function __construct($Path,$params=null){
			parent::__construct($Path,$params);
		}

		function Init($Param=NULL){
			return 0;
		}
	}

	class CoreSingleLib extends CoreLib{

		protected $oxs_Type="singlelib";

		//	Констурктор по умолчанию
		function __construct($Path,$params=null){
			parent::__construct($Path,$params);
		}

	}

?>
