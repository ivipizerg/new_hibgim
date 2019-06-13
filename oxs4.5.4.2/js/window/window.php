<?php

if(!defined("OXS_PROTECT"))die("Wrong start point");

class js_window extends SingleLib{

	function __construct($_Path,$Params=null){
		parent::__construct($_Path,$Params);		
	}
	
	protected function CheckErrors(){
		if(Oxs::G("logger")->Get("js_loader.ERROR")){			
			echo false;
		}else{
			return true;
		}		
	}

	protected function Init(){
		$D=Oxs()->GetLib("dom");
		$D->jQuery();			

		$this->Css("style");		

		//	Подключить ядро билиотеки
		Oxs::G("js.loader")->IncludeObject("js.window");		

		//	Подключаем панель окон
		Oxs::G("js.loader")->GetObject("js.window:window_bar",$Param,"oxs_window_bar");

		//	Подключаем обработчик событий окна
		Oxs::G("js.loader")->IncludeObject("js.window:events");		

		//	Подключаем ширму
		Oxs::G("js.loader")->GetObject("js.window:black_screen" , $Param  , "oxs_black_screen" );
		$this->Css("black_screen");		
	}

	function Inlcude($Param=null){	
		
		$this->Init();

		//	Подключить ядро билиотеки
		Oxs::G("js.loader")->IncludeObject("js.window");		

		return $this->CheckErrors();
	}

	function GetObject($Name="js_window",$Param=null){	

		$this->Init();

		//	Подключить ядро билиотеки
		Oxs::G("js.loader")->GetObject("js.window",$Param,$Name);			

		return $this->CheckErrors();	
	}	
	
}

?>