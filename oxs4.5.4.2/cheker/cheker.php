<?php

	if(!defined("OXS_PROTECT"))die("Wrong start point");

	class cheker extends SingleLib{

		function __construct($Path){
			parent::__construct($Path);
		}

		//	Проверяет на число
		//	Маски:
		//	+ - все полоительные
		//	- - все отрицательные
		//	+0 - все положительыне и 0
		//	-0 - все отрицатеьыне и 0 
		function Int($Value,$Mask=NULL){

			$Mask = str_replace("0","o",$Mask);

			if( is_numeric($Value) ){
				$Result = (int)$Value;
			}else{
				$this->Msg($Value." не являеться числом","WARNING");
				return false;				
			}				

			if($Mask == "+"){
				if($Result<=0){
					$this->Msg($Value." не являеться числом > 0","WARNING");
					return false;	
				}
			}

			if($Mask == (string)"o+" || $Mask == (string)"+o"){
				if($Result<0){
					$this->Msg($Value." не являеться числом >= 0","WARNING");
					return false;	
				}
			}
			
			if($Mask == "-"){
				if($Result>=0){
					$this->Msg($Value." не являеться числом < 0","WARNING");
					return false;	
				}
			}

			if( $Mask == (string)"o-" || $Mask == (string)"-o" ){
				if($Result>0){
					$this->Msg($Value." не являеться числом <= 0","WARNING");
					return false;	
				}
			}		

			return true;
		}

		function String($Value,$no_error=false){
			if(!is_string($Value)) {
				if(!$no_error)$this->Msg("Переданный элемент не явялеться строкой(".$Value.")","WARNING");
				return false;
			}
			else return true;
		}

		function id($Value){				
			
			if( is_numeric($Value) ){
				$Result = (int)$Value;
			}else{
				$this->Msg($Value." не являеться id","WARNING");
				return false;				
			}	

			if($Result===NULL){ $this->Msg($Value." не являеться id","WARNING"); return false; } 
			if($Result >= 0 ) return true;
				
			$this->Msg($Value." не являеться id","WARNING");
			return false;			
		}

	}
