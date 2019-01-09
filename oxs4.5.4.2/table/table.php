<?php

	if(!defined("OXS_PROTECT"))die("Wrong start point");

	class table extends MultiLib{

		private $Mode;
		private $Count;
		private $Tr;
		private $Td;
		private $Style;

		private $TableContent;

		private $Param;

		function __construct($Path){
			parent::__construct($Path);

			$this->Td=0;
			$this->Tr=0;
		}

		function Init($Param=NULL){
			$this->Param = $Param;
			$this->Count=$Param["count"];
		}

		//	Возможные параметры Param:
		//	even_class - класс четных строк/столбцов
		//	тще_even_class - класс нечетных строк/столбцов
		//	class - класс для всей таблицы
		//	firststr_class - класс первой строки
		///////////////////////////////////


		//	Содержимое Param будет выведено в ячейке
		//	Удобен для разбиения столбцов таблицы по ширине
		//	Прописав width=10 в первую ячейку столбца
		//	мы сделаем весь столбец шириной в 10 пикселей
		//	или выровянть содержимое ячейки параметром align=center
		function Add($Value,$_Param=NULL){

			if( is_string($_Param) ) $Param["attr"] = $_Param;
			else $Param = $_Param;

			if(($this->Td+1)%$this->Count==0){
				$this->TableContent[$this->Tr][$this->Td]["value"]=$Value;
				$this->TableContent[$this->Tr][$this->Td]["class"]=$Param["class"];
				$this->TableContent[$this->Tr][$this->Td]["attr"]=$Param["attr"];
				$this->TableContent[$this->Tr][$this->Td]["style"]=$Param["style"];
				$this->Tr++;
				$this->Td=0;
			}
			else {
				$this->TableContent[$this->Tr][$this->Td]["value"]=$Value;
				$this->TableContent[$this->Tr][$this->Td]["class"]=$Param["class"];
				$this->TableContent[$this->Tr][$this->Td]["attr"]=$Param["attr"];
				$this->TableContent[$this->Tr][$this->Td]["style"]=$Param["style"];
				$this->Td++;
			}
		}

		function GetTd(){
			return $this->Td;
		}

		function Show($Return=false){

			if(empty($this->Param["even_class"]))

			if($Return)ob_start();

			echo "<table class=\"".$this->Param["class"]."\" ".$this->Param["attr"]." style='".$this->Param["style"]."'>";

			for($i=0;$i<count($this->TableContent);$i++){

				if($i==0)echo "<thead><tr class=\"".$this->Param["firststr_class"]." oxs_table_tr_".$i." oxs_table_tr"."\">";
				else {
					if($i%2!=0)echo "<tr class=\"even_oxs_table_tr oxs_table_tr oxs_table_tr_".$i."\">";
					else echo "<tr class=\"no_event_oxs_table_tr oxs_table_tr oxs_table_tr_".$i."\">";
				}

				for($j=0;$j<count($this->TableContent[$i]);$j++){
					echo "<td ".$this->TableContent[$i][$j]["class"]." ".$this->TableContent[$i][$j]["attr"]." style=\"".$this->TableContent[$i][$j]["style"]."\">".$this->TableContent[$i][$j]["value"];
					echo "</td>";
				}

				if($i==0)echo "</tr></thead>";
				else echo "</tr>";
			}

			echo "</table>";

			if($Return){
				$myStr = ob_get_contents();
				ob_end_clean();
			}

			return $myStr;
		}

		function ClearContent(){
			$this->TableContent=array();
			$this->Td=0;
			$this->Tr=0;			
		}

	}

?>
