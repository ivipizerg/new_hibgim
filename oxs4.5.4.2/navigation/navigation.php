<?php

	if(!defined("OXS_PROTECT"))die("Wrong start point");

	class navigation extends Multilib{

		private $All;			//	Общее количество элементов
		private $interval;		//	Интервал
		private $Countelements;	//	Количестов отобрадаемых на странице елементов
		private $CurrentPage;	//	Текущая странциа
		private $Foo;		//	Функция вывода
		private $Data;

		function __construct($Path){
			parent::__construct($Path);
		}

		function Init($Param=NULL){

			if(!empty($Param["all"]))$this->All = $Param["all"]; else $this->All=0;
			if(!empty($Param["interval"]))$this->interval = $Param["interval"];else $this->interval=0;
			if(!empty($Param["count"]))$this->Countelements = $Param["count"];else $this->Countelements = 0;
			if(!empty($Param["page"]))$this->CurrentPage = $Param["page"];else $this->CurrentPage = 1;
			if(!empty($Param["Foo"]))$this->Foo = $Param["Foo"];else $this->Foo = NULL;
			if(!empty($Param["Data"]))$this->Data = $Param["Data"];else $this->Data = NULL;

			Oxs::GetLib("js.loader")->GetObject("navigation");

			?>
			<script>
				jQuery(function(){

				});
			</script>
			<?php

			return 0;
		}

		function GetCurrentPage(){
			return $this->CurrentPage;
		}

		function setAll($Value){
			$this->All  = $Value;
		}

		function getAll(){
			return $this->All;
		}

		function SqlLimits($full=false){
			if(!$full)
				return array(  ($this->Countelements*$this->CurrentPage)-$this->Countelements  , $this->Countelements );
			else
				return " LIMIT " . (($this->Countelements*$this->CurrentPage)-$this->Countelements  ). " , " . $this->Countelements ;
		}

		function ShowItem($i){
			if($this->Foo==NULL)
				return "<span class=oxs_navigation_item data-href=".$i.">".$i."</span>";
			else
				return "<span class=oxs_navigation_item>".($this->Foo)($i,$this->Data,$this)."</span>";
		}

		function Show(){

			$AllPage = intdiv( ($this->All - 1) ,  $this->Countelements ) + 1;
			$DoubleInterval = $this->interval * 2 + 1;

			//	Проверяем переданную страницу
			if($this->CurrentPage<=0) $this->CurrentPage = 0;
			if($this->CurrentPage>$AllPage)$this->CurrentPage = $AllPage;

			if($this->CurrentPage<=$this->interval+1){
				//echo "Вариант 1<br>";
				$start = 1;
				if($AllPage>$DoubleInterval) $end  = $DoubleInterval;
				else $end  = $AllPage;
			}else if( $this->CurrentPage>=( $AllPage - $this->interval ) ){
				//echo "Вариант 2<br>";
				$start = $AllPage - $DoubleInterval+1;
				$end = $AllPage;
			}else{
				//echo "Вариант 3<br>";
				$start = $this->CurrentPage - $this->interval;
				$end = $this->CurrentPage + $this->interval;
			}

			/*echo "Всего страниц: " . $AllPage ."<br>";
			echo "Интервал ".$this->interval ."<br>";
			echo "Текущая страница ".$this->CurrentPage ."<br>";
			echo "Начало ".$start ."<br>";
			echo "Конец ".$end ."<br>";*/

			$T .= "<div class=oxs_navigation>";
			for($i=$start;$i<=$end;$i++){
				$T .= $this->ShowItem($i);
			}
			$T .= "</div>";

			$this->Msg("Выводим навигацию","GOOD");
			$this->Msg("Всего материалов  ".$this->All,"MESSAGE");
			$this->Msg("Материалов на странице ".$this->Countelements,"MESSAGE");
			$this->Msg("Интервал слева и справа от активной страницы ".$this->interval,"MESSAGE");
			$this->Msg("Текущая страница ". $this->CurrentPage,"MESSAGE");

			return $T;

		}

	}
?>
