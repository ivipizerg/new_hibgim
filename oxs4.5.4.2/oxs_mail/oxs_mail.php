<?php

if(!defined("OXS_PROTECT"))die("Wrong start point");

class oxs_mail extends MultiLib{

	private $username;			//Смените на адрес своего почтового ящика. zergvip@yandex.ru
	private $port = '465';		// Порт работы. 465
	private $host;				//сервер для отправки почты ssl://smtp.yandex.ru
	private $password;			//Измените пароль
	private $charset = 'utf-8';	//кодировка сообщений. (windows-1251 или utf-8, итд)
	private $from="nobody";		//Ваше имя - или имя Вашего сайта. Будет показывать при прочтении в поле "От кого"


	function __construct($Path){
		parent::__construct($Path);
	}


	function Init($Param=NULL){
		if(!empty($Param["username"]) )	$this->username = $Param["username"];
		if(!empty($Param["port"]) )		$this->port = $Param["port"];
		if(!empty($Param["host"]) )		$this->host = $Param["host"];
		if(!empty($Param["password"]) )	$this->password = $Param["password"];
		if(!empty($Param["charset"]) )	$this->charset = $Param["charset"];
		if(!empty($Param["from"]) )		$this->from = $Param["from"];
	}


	function smtpmail($to='', $mail_to, $subject, $message, $headers='') {

		$SEND =	"Date: ".date("D, d M Y H:i:s") . " UT\r\n";
		$SEND .= 'Subject: =?'.$this->charset.'?B?'.base64_encode($subject)."=?=\r\n";
		if ($headers) $SEND .= $headers."\r\n\r\n";
		else
		{
				$SEND .= "Reply-To: ".$this->username."\r\n";
				$SEND .= "To: \"=?".$this->charset."?B?".base64_encode($to)."=?=\" <$mail_to>\r\n";
				$SEND .= "MIME-Version: 1.0\r\n";
				$SEND .= "Content-Type: text/html; charset=\"".$this->charset."\"\r\n";
				$SEND .= "Content-Transfer-Encoding: 8bit\r\n";
				$SEND .= "From: \"=?".$this->charset."?B?".base64_encode($this->from)."=?=\" <".$this->username.">\r\n";
				$SEND .= "X-Priority: 3\r\n\r\n";
		}
		$SEND .=  $message."\r\n";
		 if( !$socket = fsockopen($this->host, $this->port, $errno, $errstr, 30) ) {
			$this->Msg("Ошибка fsockopen: " . $errno . "(" . $errstr . ")" , "ERROR" );
			return false;
		 }

		if (!$this->server_parse($socket, "220", __LINE__)) return false;

		fputs($socket, "HELO " . $this->host . "\r\n");
		if (!$this->server_parse($socket, "250", __LINE__)) {
			$this->Msg("Не могу отправить HELO!", "ERROR");
			fclose($socket);
			return false;
		}
		fputs($socket, "AUTH LOGIN\r\n");
		if (!$this->server_parse($socket, "334", __LINE__)) {
			$this->Msg("Не могу найти ответ на запрос авторизаци", "ERROR");
			fclose($socket);
			return false;
		}
		fputs($socket, base64_encode($this->username) . "\r\n");
		if (!$this->server_parse($socket, "334", __LINE__)) {
			$this->Msg("Логин авторизации не был принят сервером!", "ERROR");
			fclose($socket);
			return false;
		}
		fputs($socket, base64_encode($this->password) . "\r\n");
		if (!$this->server_parse($socket, "235", __LINE__)) {
			$this->Msg("Пароль не был принят сервером как верный! Ошибка авторизации!", "ERROR");
			fclose($socket);
			return false;
		}
		fputs($socket, "MAIL FROM: <".$this->username.">\r\n");
		if (!$this->server_parse($socket, "250", __LINE__)) {
			$this->Msg("Не могу отправить комманду MAIL FROM: ", "ERROR");
			fclose($socket);
			return false;
		}
		fputs($socket, "RCPT TO: <" . $mail_to . ">\r\n");

		if (!$this->server_parse($socket, "250", __LINE__)) {
			$this->Msg("Не могу отправить комманду RCPT TO: ", "ERROR");
			fclose($socket);
			return false;
		}
		fputs($socket, "DATA\r\n");

		if (!$this->server_parse($socket, "354", __LINE__)) {
			$this->Msg("Не могу отправить комманду DATA", "ERROR");
			fclose($socket);
			return false;
		}
		fputs($socket, $SEND."\r\n.\r\n");

		if (!$this->server_parse($socket, "250", __LINE__)) {
			$this->Msg("Не смог отправить тело письма. Письмо не было отправленно!", "ERROR");
			fclose($socket);
			return false;
		}
		fputs($socket, "QUIT\r\n");
		fclose($socket);

		$this->Msg("Письмо отправлено","GOOD");

		return TRUE;
	}

	private function server_parse($socket, $response, $line = __LINE__) {
		while (@substr($server_response, 3, 1) != ' ') {
			if (!($server_response = fgets($socket, 256))) {
				$this->Msg("Проблемы с отправкой почты!$response ($line)", "ERROR");
	 			return false;
	 		}
		}
		if (!(substr($server_response, 0, 3) == $response)) {
			$this->Msg("Проблемы с отправкой почты!$response($line)", "ERROR");
			return false;
		}
		return true;
	}



}

?>
