<?php

if(!defined("OXS_PROTECT"))die("Wrong start point");

class protector extends MultiLib{

	function __construct($Path){

		parent::__construct($Path);

	}

	function SetToken($name){

		$T=session_id();
		if(empty($T)) {
			$this->Msg("Не найдена сессия для токена ".$name." создам сам, но возможны проблемы","WARNING");
			session_start();
		}

		//$this->ClearToken($name);
		$this->Msg("Устанавливаю токен ".$name,"MESSAGE");

		if(empty($_SESSION[$name])){
			$Temp=openssl_random_pseudo_bytes(15);
			$Temp = bin2hex($Temp);

			//echo $T;
			$_SESSION[$name]=$Temp;
		}

		return 	$name;
	}

	function GetToken($name){

		if($name==NULL){
			$name=$_POST["OXS_TOKEN_NAME"];
		}

		return $_SESSION[$name];
	}

	function CheckToken($name=NULL,$token=NULL){

		if($name==NULL){
			$name=$_POST["OXS_TOKEN_NAME"];
		}

		if($token==NULL){
			$token=$_POST["OXS_TOKEN"];
		}

		if(!isset($_SESSION)) {
			session_start();
		}

		if($this->GetToken($name)!=$token|empty($token)|empty($name)) Oxs::Error("Неверный токен");
	}

	function ClearToken($name){
		$_SESSION[$name]="";
	}

	//	Использовать аккуратно так как если в нескольих метса испольхуеться один и тот же токен после проверки в одном месте в дургом он будет недоступен
	function CheckAndClearToken($name=NULL,$token=NULL){
		$this->CheckToken($name,$token);
		$this->ClearToken($name);
	}
}

?>
