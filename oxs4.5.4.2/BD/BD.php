<?php

	if(!defined("OXS_PROTECT"))die("Wrong start point");

	class BD extends SingleLib{

		private $Count=0;

		function __construct($Path){
			parent::__construct($Path);
		}

		function Start(){
			$this->Count++;
			ob_start();
		}

		function End(){
			$this->Count--;
			ob_end_clean();
		}

		function Get(){
			return ob_get_contents();
		}

		function GetEnd(){
			$T = $this->Get();
			$this->End();
			return $T;
		}

		//	Закрыть все открытые потоки
		function CloseAll(){
			for($i=0;$i<$this->Count;$i++){
				ob_end_clean();
			}
		}
	}
?>
