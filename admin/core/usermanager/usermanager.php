<?php

if(!defined("OXS_CMS_PROTECT"))die("protect");

//	Обьект для методов относящихся к текущему поьзователю
class _CurrentUser{
	
	function IfAuth(){
		if($_SESSION["auth"]==1){
			return 1;
		}else{
			return 0;
		}		
	}

	function Get($Info){		
		if($this->IfAuth()){			
			return $_SESSION["user"][$Info];
		}else{
			return NULL;
		}
	}

	function SetData($Data){
		$_SESSION["user"] = $Data;
	}

	function SetAuth($Value){
		$_SESSION["auth"] = $Value;
	}

	function SaveEnterTime(){
		$C = Oxs::L("calendar");
		Oxs::G("DBLIB.IDE")->DB()->Update("#__users",array(
			"last_enter" => $C->get("getUnix")
		)," WHERE `id` = 'oxs:id'" , $this->Get("id") );
	}

	function logOut(){
		unset($_SESSION["user"]);
		unset($_SESSION["auth"]);
	}
}

class usermanager extends CoreSingleLib{	
	
	public $CurrentUser;

	function __construct ($Path){
		parent::__construct($Path);	
		$this->CurrentUser = new  _CurrentUser();	
	}

	function CheckPassword($login,$Password){
		$Result = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__users` WHERE `username` = 'oxs:sql' and `password` = 'oxs:sql' " , $login,  sha1($Password));

		$this->LastId=0;
		if($Result) {
			$this->LastId = $Result[0]["id"];
			return $Result[0]["id"];
		}
		else return 0;		
	}

	function LoadUserData($user_Id=-1){
		if($user_Id==-1){
			$user_Id = $this->LastId;
		}
		return Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__users` WHERE `id` = 'oxs:id' " ,  $user_Id)[0];
	}
}

?>
