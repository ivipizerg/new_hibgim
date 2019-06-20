<?php

if(!defined("OXS_PROTECT"))die("Wrong start point");

class dom extends SingleLib{

	private $jQuery_v=0;	//	Флаг вывода jQuery
	private $UI=0;			//	Флаг вывода UI
	private $DC=0;

	function __construct($Path){
		parent::__construct($Path);
	}

	function JQ(){
		$this->jQuery();
	}

	function jQuery(){

		if($this->jQuery_v!=1){
			$this->Msg("Подключаю Jquery","MESSAGE");
			$this->LoadJsOnce( $this->Path ."/dom/jq3.3.1.js");				
		}

		$this->jQuery_v=1;
	}

	function Ui(){
		if($this->UI!=1){
			$this->jQuery();
			$this->Msg("Подключаю Ui","MESSAGE");				
			$this->LoadJsOnce( $this->Path ."/dom/UI1.12.1.js");
			$this->LoadCssOnce( $this->Path ."/dom/ui.css");			
		}
		$this->UI=1;
	}

	function LoadCss($FileName){
		$FileName=str_replace("//","/",$FileName);

		if(!is_file(Oxs::GetBack().$FileName)){$this->Msg("Не удалось подключить CSS файл \"".$FileName."\"" ,"ERROR");return 0;}

		$this->Msg("CSS файл \"".$FileName ."\" подключен" ,"GOOD");
		echo "\n<link rel=\"stylesheet\" type=\"text/css\" href=\"".$FileName."\" >\n";
	}

	function LoadCssOnce($FileName){
		static $FilesCSs;

		if(isset($FilesCSs[$FileName])){
			return ;
		}

		$FilesCSs[$FileName] = true;

		$this->LoadCss($FileName);
	}


	//	Проверить существует ли файл
	function CheckJs($FileName){
		$FileName=str_replace("//","/",$FileName);
		if(!is_file(Oxs::GetBack().$FileName)){
			return FALSE;
		}
		return TRUE;
	}

	function LoadJs($FileName){
		$FileName=str_replace("//","/",$FileName);

		if(!is_file(Oxs::GetBack().$FileName)){
			$this->Msg("Не удалось подключить JS файл \"". $FileName ."\"","ERROR");return 0;
		}

		echo "\n<script  src=\"".$FileName ."\" ></script>\n";
		$this->Msg("JS файл \"".$FileName  ."\" подключен" ,"GOOD");

	}

	function LoadJsOnce($FileName){

		static $Files;

		if(isset($Files[$FileName])){
			return ;
		}

		$Files[$FileName] = true;

		$this->LoadJs($FileName);
	}

	function SetCharset($Charser="UTF-8"){
		return "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$Charser."\">";
	}

	//	Проверить наличие доктайпа
	function CheckDOCTYPE(){
		if($this->DC!=1){
			$this->jQuery();
			?>
				<script>
					jQuery(function(){
						var a = document.doctype;
						if(a!=undefined){
							if(a.name!="html") alert("Не найден <!DOCTYPE html>");
						}else throw "Не найден <!DOCTYPE html>";

					});
				</script>
			<?php
		}
		$this->DC=1;
	}

	//	Запретить браузеру кешировать
	function NoCache(){
		return "<meta http-equiv=\"Cache-Control\" content=\"no-cache\">";
	}

	function ShowBase($Base=NULL){
		$_proto=($_SERVER["SERVER_PORT"]==443)?"https":"http";
		if($Base==NULL){		
			if(Oxs::GetRoot()=="/")	
				return "<base href=\"".$_proto."://".$_SERVER["SERVER_NAME"]."\">\n";
			else
				return "<base href=\"".$_proto."://".$_SERVER["SERVER_NAME"]."/".Oxs::GetRoot()."\">\n";
		}else{
			return "<base href=\"".$_proto."://".$_SERVER["SERVER_NAME"]."/".$Base."\">\n";
		}
	}

	function BS(){
		$this->Msg("Подключаю BootStrap","MESSAGE");
		$this->JQ();
		$this->LoadJsOnce($this->Path."/dom/bootstrap-3.3.7-dist/js/bootstrap.min.js");
		$this->LoadCssOnce($this->Path."/dom/bootstrap-3.3.7-dist/css/bootstrap.min.css");
	}
}

?>
