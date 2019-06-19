<?php
	/*
		Название:logger
		Автор: Зарницын Дмитрий Александрович;
		Почта автора: zergvip@mail.ru;
	*/


/*
	Протокол каналов для сообщений

			MESSAGE 		Отладочная информация
			GOOD 			Удачные операции
			ERROR 			Ошибки
			WARNING 		Предупреждения
			FATAL_ERROR		Фатальные ошибки, дальнейшее выполнение невозможно
			OBJECT_CREATE 	Обьект создан
			OBJECT_DELETE 	Обьект удален
			DB_QUERY		Запрос к базе данных

	Плагины создают свои каналы

*/

if(!defined("OXS_PROTECT"))die("Wrong start point");

class oxs_error_object {
	public	$value;
	public	$chanel;
	public 	$debug_info;
	public 	$time;
	public 	$code;
}


class logger extends SingleLib{

	private $BOX;

	function __construct($Path){
		$this->BOX=array();
		$this->Path=$Path;
		$this->AddMessage("Загружаю библиотеку ".get_class($this)."(".$this->GetVersion().")","OBJECT_CREATE");
	}

	function Init(){

		Oxs::G("BD")->Start();

		echo Oxs::GetLib("dom")->JQ();		
		echo Oxs::GetLib("dom")->LoadJsOnce( Oxs::GetBack() . $this->Path . "/logger/logger.js" );

		return Oxs::G("BD")->GetEnd();
	}

	function Add($Text,$Chanel="NO_CHANELL",$Code=-1){
		$this->AddMessage($Text,$Chanel,$Code);
	}

	function AddMessage($Text,$Chanel="NO_CHANELL",$Code=-1){
		$d_Temp="";
		$Debug=debug_backtrace();
		for($i=1;$i<count($Debug);$i++){
			$p_Temp="";
			$d_Temp=$Debug[$i]["class"].$Debug[$i]["type"].$Debug[$i]["function"]."(".$p_Temp.") : ".$d_Temp;
		}
		$d_Temp=trim($d_Temp);$d_Temp=trim($d_Temp,":");

		$Chanel=explode(",",$Chanel);

		for($o=0;$o<count($Chanel);$o++){

			if(is_array($Text)){
				for($i=0;$i<count($Text);$i++){
					$Temp=new oxs_error_object();
					$Temp->value = $Text[$i];
					$Temp->Obj = get_class($Debug[1]["object"]);
					$Temp->chanel=trim($Chanel[$o]);
					$Temp->debug_info=$d_Temp;
					$Temp->time=microtime(true) - $this->ScriptTime;
					$Temp->code=$Code;
					$this->BOX[count($this->BOX)]=$Temp[$i];
				}
			}else{
				$Temp=new oxs_error_object();
				$Temp->value = $Text;
				$Temp->Obj = get_class($Debug[1]["object"]);
				$Temp->chanel=trim($Chanel[$o]);
				$Temp->debug_info=$d_Temp;
				$Temp->time=microtime(true) - $this->ScriptTime;
				$Temp->code=$Code;
				$this->BOX[count($this->BOX)]=$Temp;
			}
		}

	}

	function GetMessages($Chanel="NO_CHANELL"){		

			if($Chanel==".") return $this->BOX;
			
			$Chanel=explode(",",$Chanel);

			$t=0;$Temp=FALSE;
			for($i=0;$i<count($this->BOX);$i++){
				for($j=0;$j<count($Chanel);$j++){
					if(preg_match("/^".strtolower(trim($Chanel[$j]))."(\.|$)/",strtolower($this->BOX[$i]->chanel))){
						$Temp[$t++]=$this->BOX[$i];
					}
				}
			}
			return $Temp;
	}

	function Get($Chanel){
		return $this->GetMessages($Chanel);
	}

	function GetString($Chanel,$Foo=NULL){
		$Mass = $this->GetMessages($Chanel);

		for($i=0;$i<count($Mass);$i++){
			if($Foo==NULL)
				$Tmp .= $Mass[$i]->Obj.":".$Mass[$i]->value."<br>";
			else
				$Tmp .= $Foo($Mass[$i]);
		}
		return $Tmp; 
	}

	function GetUl($Chanel,$Foo=NULL,$Param=NULL){
		$Mass = $this->GetMessages($Chanel);
		
		$Tmp .= "<ul class=".$Param["ul_class"].">";
		for($i=0;$i<count($Mass);$i++){
			if($Foo==NULL)
				$Tmp .= "<li class=".$Param["li_class"].">".$Mass[$i]->value."</li>";
			else
				$Tmp .= $Foo($Mass[$i],$Param);
		}
		$Tmp .= "</ul>";

		return $Tmp; 
	}

	function WrapMessages($Chanels="MESSAGE,GOOD,ERROR,WARNING,FATAL_ERROR,OBJECT_CREATE,OBJECT_DELETE,DB_QUERY"){
		$Res=$this->GetMessages($Chanels);

		Oxs::G("BD")->Start();
		echo "<ul class=oxs_debug_window_ul>";

		echo "<li>Версия Oxs: ". Oxs::GetVersion() ."</li>";	

		for($i=0;$i<count($Res);$i++){
			if(substr_count($Res[$i]->chanel,"OBJECT_CREATE")) echo  "<li class=oxs_debug_window_object_create><span class=oxs_debug_window_chanel>".$Res[$i]->chanel."</span><span class=oxs_debug_window_text>".$Res[$i]->Obj.":".$Res[$i]->value."</span></li>";
			if(substr_count($Res[$i]->chanel,"MESSAGE")) echo  "<li class=oxs_debug_window_message><span class=oxs_debug_window_chanel>".$Res[$i]->chanel."</span><span class=oxs_debug_window_text>".$Res[$i]->Obj.":".$Res[$i]->value."</span></li>";
			if(substr_count($Res[$i]->chanel,"GOOD")) echo  "<li class=oxs_debug_window_good><span class=oxs_debug_window_chanel>".$Res[$i]->chanel."</span><span class=oxs_debug_window_text>".$Res[$i]->Obj.":".$Res[$i]->value."</span></li>";
			if(substr_count($Res[$i]->chanel,"ERROR")) echo  "<li class=oxs_debug_window_error><span class=oxs_debug_window_chanel>".$Res[$i]->chanel."</span><span class=oxs_debug_window_text>".$Res[$i]->Obj.":".$Res[$i]->value."</span></li>";
			if(substr_count($Res[$i]->chanel,"WARNING")) echo  "<li class=oxs_debug_window_warning><span class=oxs_debug_window_chanel>".$Res[$i]->chanel."</span><span class=oxs_debug_window_text>".$Res[$i]->Obj.":".$Res[$i]->value."</span></li>";
			if(substr_count($Res[$i]->chanel,"FATAL_ERROR")) echo  "<li class=oxs_debug_window_fatal_error><span class=oxs_debug_window_chanel>".$Res[$i]->chanel."</span><span class=oxs_debug_window_text>".$Res[$i]->Obj.":".$Res[$i]->value."</span></li>";
			if(substr_count($Res[$i]->chanel,"OBJECT_DELETE")) echo  "<li class=oxs_debug_window_object_delete><span class=oxs_debug_window_chanel>".$Res[$i]->chanel."</span><span class=oxs_debug_window_text>".$Res[$i]->Obj.":".$Res[$i]->value."</span></li>";
			if(substr_count($Res[$i]->chanel,"DB_QUERY"))echo  "<li class=oxs_debug_window_db_query><span class=oxs_debug_window_chanel>".$Res[$i]->chanel."</span><span class=oxs_debug_window_text>".$Res[$i]->Obj.":".$Res[$i]->value."</span></li>";
		}
		echo "</ul>";

		return Oxs::G("BD")->GetEnd();
	}

	function Css($F=null){
		return Oxs::G("dom")->LoadCssOnce($this->Path."/logger/logger.css");
	}

	//	Режим default выводит ошибки как есть в месте вызова функции
	//	Режим window создает окно и выводит ошибки в него
	function ShowLog($Mode = true){

		//	Проверяем версию библиотеки псевдоокон
		//	Все что ниже 2.3.0 работать не будет
		///////////////////////////////////////////////////////////
		if(Oxs::G("js.window")->GetVersion()<"2.3.0"){
			$this->Msg("Некорректная версия js.window(".(Oxs::G("js.window")->GetVersion()).")","ERROR");
		}
		////////////////////////////////////////////////////////////

		//	Подключаем css		
		$this->Css();

		if(!$Mode){
			echo $this->ShowErrorsDefault();
		}else{
			$this->ShowErrorsWindow();
		}
	}

	private function ShowErrorsDefault(){
		return $this->WrapMessages();
	}

	function ShowErrorsWindow($Header="Системный лог",$class_name="oxs_logger_window"){		
		// Создаем окно		
		$WW = Rand();
		Oxs::GetLib("js.window")->GetObject("winobj_" . $WW);

		//	Получаем обернутые сообщения
		$Msssages = $this->WrapMessages();

		$WinObj = Oxs::G("logger.debug_window")->Init($class_name,$Header);	

		?>
			<SCRIPT>
				jQuery(function(){	

					window["<?php echo $WinObj;?>"].clear();
					window["<?php echo $WinObj;?>"].insert("<?php echo addslashes($Msssages);?>");
					//	Напо
					//window[<?php echo $WinObj;?>.WinObj].set("<div class=oxs_debug_window><?php echo addslashes($Msssages);?><div class='oxs_oxs_debug_window_button winobj_<?php echo $class_name;?>_fold_button'>__</div></div>");
						
					window[<?php echo $WinObj;?>.WinObj].addClass("<?php echo $class_name;?>");				
					
				});
			</SCRIPT>
		<?php
	}

}

?>