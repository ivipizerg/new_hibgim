<?php

	if(!defined("OXS_PROTECT"))die("protect");


	class calendar_getHelper extends MultiLib{
		
		function __construct($Path){
			parent::__construct($Path);
		}

		//	Получить дату на которую настроен текущий указатель
		function GetData(){
			return $this->GetDay().".".$this->GetMount().".".$this->GetYear();
		}

		function GetTime(){
			return $this->GetHours().":".$this->GetMinuts().":".$this->GetSeconds();
		}

		function GetDataTime(){
			return $this->GetData(). " " . $this->GetTime();
		}


		function GetDataMysql(){
			return $this->GetYear()."-".$this->GetMount()."-".$this->GetDay();
		}

		function GetDataTimeMysql(){
			return $this->GetYear()."-".$this->GetMount()."-".$this->GetDay() ." ".$this->GetHours().":".$this->GetMinuts().":".$this->GetSeconds();
		}

		function GetUTC(){
			return $this->Data->UTC ;
		}

		function GetHours(){
			return str_pad($this->Data->Hours,2,0, STR_PAD_LEFT);
		}

		function GetMinuts(){
			return str_pad($this->Data->Minuts,2,0, STR_PAD_LEFT);
		}

		function GetSeconds(){
			return str_pad($this->Data->Seconds,2,0, STR_PAD_LEFT);
		}

		//	Количество дней в месяце
		function GetCountDays(){
			return $this->Data->CountDays;
		}

		function GetMount(){
			return $this->Data->Mount;
		}

		function GetDay($mode = false){
			if(!$mode) return $this->Data->Day;
			else return ltrim($this->Data->Day,"0");
		}

		function GetYear(){
			return $this->Data->Year;
		}

		function GetMountName( $mode = false){
			return calendar::SGetMountName( $this->Data->Mount,$mode);
		}

		function Hour($Hour=0){
			if($Hour>0){
				$this->NextHour($Hour);
			}else if($Hour<0){
				$this->PrevHour($Hour);
			}
		}


		function NextMinuts($Min=1){
			$Tmp = strtotime($this->Data->Year."-".$this->Data->Mount."-".$this->Data->Day." ".$this->Data->Hours.":".$this->Data->Minuts.":".$this->Data->Seconds." +".$Min." minute " );
			$this->_Set($Tmp);
		}

		function PrevMinuts($Min=-1){
			$Min = abs($Min);
			$Tmp = strtotime($this->Data->Year."-".$this->Data->Mount."-".$this->Data->Day." ".$this->Data->Hours.":".$this->Data->Minuts.":".$this->Data->Seconds." -".$Min." minute " );
			$this->_Set($Tmp);
		}

		function NextHour($Hour=1){
			$Tmp = strtotime($this->Data->Year."-".$this->Data->Mount."-".$this->Data->Day." ".$this->Data->Hours.":".$this->Data->Minuts.":".$this->Data->Seconds." +".$Hour." hours " );
			$this->_Set($Tmp);
		}

		function PrevHour($Hour=-1){
			$Hour = abs($Hour);
			$Tmp = strtotime($this->Data->Year."-".$this->Data->Mount."-".$this->Data->Day." ".$this->Data->Hours.":".$this->Data->Minuts.":".$this->Data->Seconds." -".$Hour." hour " );
			$this->_Set($Tmp);
		}

		function NextYear($Year=1){
			$Tmp = strtotime($this->Data->Year."-".$this->Data->Mount."-".$this->Data->Day." ".$this->Data->Hours.":".$this->Data->Minuts.":".$this->Data->Seconds." +".$Year." year " );
			$this->_Set($Tmp);
		}

		function PrevYear($Year=1){
			$Tmp = strtotime($this->Data->Year."-".$this->Data->Mount."-".$this->Data->Day." ".$this->Data->Hours.":".$this->Data->Minuts.":".$this->Data->Seconds." -".$Year." year " );
			$this->_Set($Tmp);
		}

		function GetNextMount(){
			return date( "m" , strtotime($this->Data->Year."-".$this->Data->Mount."-".$this->Data->Day." ".$this->Data->Hours.":".$this->Data->Minuts.":".$this->Data->Seconds." +".$Mount." month " ) );
		}

		function NextMount($Mount=1){
			$Tmp = strtotime($this->Data->Year."-".$this->Data->Mount."-".$this->Data->Day." ".$this->Data->Hours.":".$this->Data->Minuts.":".$this->Data->Seconds." +".$Mount." month " );
			$this->_Set($Tmp);
		}

		function GetPrevMount(){
			return date( "m" , strtotime($this->Data->Year."-".$this->Data->Mount."-".$this->Data->Day." ".$this->Data->Hours.":".$this->Data->Minuts.":".$this->Data->Seconds." -".$Mount." month " ) );
		}

		function PrevMount($Mount=1){
			$Tmp = strtotime($this->Data->Year."-".$this->Data->Mount."-".$this->Data->Day." ".$this->Data->Hours.":".$this->Data->Minuts.":".$this->Data->Seconds." -".$Mount." month " );
			$this->_Set($Tmp);
		}

		function NextDay($Day = 1){

			$Tmp = strtotime($this->Data->Year."-".$this->Data->Mount."-".$this->Data->Day." ".$this->Data->Hours.":".$this->Data->Minuts.":".$this->Data->Seconds." +".$Day." day " );
			$this->_Set($Tmp);
		}

		function PrevDay($Day = 1){
			$Tmp = strtotime($this->Data->Year."-".$this->Data->Mount."-".$this->Data->Day." ".$this->Data->Hours.":".$this->Data->Minuts.":".$this->Data->Seconds." -".$Day." day " );
			$this->_Set($Tmp);
		}

		function CompareData(calendar $Cl){
			if( $this->Data->Year == $Cl->GetYear() and $this->Data->Mount == $Cl->GetMount() and $this->Data->Day == $Cl->GetDay() ){
				return 1;
			}else {
				return 0;
			}
		}

		
		function  getUnix(){
			return strtotime($this->Data->Year."-".$this->Data->Mount."-".$this->Data->Day." ".$this->Data->Hours.":".$this->Data->Minuts.":".$this->Data->Seconds);
		}

		function GetWeekDay($Mode=1){
			if($Mode==1)
				return $this->Data->Week;

			if($Mode==2){
				if($this->Data->Week==1) return "Понедельник";
				if($this->Data->Week==2) return "Вторник";
				if($this->Data->Week==3) return "Среда";
				if($this->Data->Week==4) return "Четверг";
				if($this->Data->Week==5) return "Пятница";
				if($this->Data->Week==6) return "Суббота";
				if($this->Data->Week==7) return "Воскресение";
			}

			if($Mode==3){
				if($this->Data->Week==1) return "Пн";
				if($this->Data->Week==2) return "Вт";
				if($this->Data->Week==3) return "Ср";
				if($this->Data->Week==4) return "Чт";
				if($this->Data->Week==5) return "Пт";
				if($this->Data->Week==6) return "Сб";
				if($this->Data->Week==7) return "Вс";
			}

		}

		static function GetWeekDatByNumber($N,$Mode=1){
			if($Mode==1){
				if($N==1) return "Понедельник";
				if($N==2) return "Вторник";
				if($N==3) return "Среда";
				if($N==4) return "Четверг";
				if($N==5) return "Пятница";
				if($N==6) return "Суббота";
				if($N==7) return "Воскресение";
			}

			if($Mode==1){
				if($N==1) return "Пн";
				if($N==2) return "Вт";
				if($N==3) return "Ср";
				if($N==4) return "Чт";
				if($N==5) return "Пт";
				if($N==6) return "Сб";
				if($N==7) return "Вс";
			}
		}		

		static function SGetMountName( $Month , $mode = false){			

			if($mode==true){
				switch($Month){
					case "01" : return "Января";
					case "02" : return "Февраля";
					case "03" : return "Марта";
					case "04" : return "Апреля";
					case "05" : return "Мая";
					case "06" : return "Июня";
					case "07" : return "Июля";
					case "08" : return "Августа";
					case "09" : return "Сентября";
					case "10" : return "Октября";
					case "11" : return "Ноября";
					case "12" : return "Декабря";
				}
			}else{
				switch($Month){
					case "01" : return "Январь";
					case "02" : return "Февраль";
					case "03" : return "Март";
					case "04" : return "Апрель";
					case "05" : return "Май";
					case "06" : return "Июнь";
					case "07" : return "Июль";
					case "08" : return "Август";
					case "09" : return "Сентябрь";
					case "10" : return "Октябрь";
					case "11" : return "Ноябрь";
					case "12" : return "Декабрь";
				}
			}
		} 		

		static function GetMountList(){

			$Array = array(
				array ( "name" => "Январь" , "id" => 1 ) ,
				array ( "name" => "Февраль" , "id" => 2 ) ,
				array ( "name" => "Март" , "id" => 3 ) ,
				array ( "name" => "Апрель" , "id" => 4 ) ,
				array ( "name" => "Май" , "id" => 5 ) ,
				array ( "name" => "Июнь" , "id" => 6 ) ,
				array ( "name" => "Июль" , "id" => 7 ) ,
				array ( "name" => "Август" , "id" => 8 ) ,
				array ( "name" => "Сентябрь" , "id" => 9 ) ,
				array ( "name" => "Октябрь" , "id" => 10 ) ,
				array ( "name" => "Ноябрь" , "id" => 11 ) ,
				array ( "name" => "Декабрь" , "id" => 12 )
			 );

			return $Array;
		}

		static function GetServerUtc(){
			return date("Z")/60/60;
		}	
	}