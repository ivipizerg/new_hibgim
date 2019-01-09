<?php

	if(!defined("OXS_PROTECT"))die("protect");

	global $GlobalUtc;
	$GlobalUtc = FALSE;

	Oxs::IFO( OXS_PATH . "/calendar/oxs_data.php");	
	Oxs::I("calendar:getHelper");

	class calendar extends calendar_getHelper{

		protected $Data;		

		function __construct($Path){
			parent::__construct($Path);
		}

		function  __clone (  ){
			 $this->Data = clone $this->Data;
		}

		protected function _Set($Time){
			$this->Data->Year = date( "Y" , $Time );
			$this->Data->Mount = date( "m" , $Time );
			$this->Data->Day = date( "d" , $Time );

			$this->Data->Hours = date( "G" , $Time );
			$this->Data->Minuts = date( "i" , $Time );
			$this->Data->Seconds = date( "s" , $Time );

			$this->Data->Week =  date( "N" , $Time );
			$this->Data->CountDays = date("t" , $Time );
		}


		function Init($Param=NULL){			

			if($Param==null){
				$this->Set( null , $this->GetServerUtc() );
				return ;	
			}

			if(!is_array($Param)){
				$this->Set($Param);
			}else{				
				$this->Set($Param[0] , $Param[1] );
			}			
		}

		//	Формат инициализации число.месяц.год час:минуты:секунды
		//	Несоблюдение формата не гарантирует правильыйн парсинг
		function Set($Data=NULL,$UTC=NULL){

			unset($this->Data);	

			//	Если нашли хоть 1 дефис занчит формат Mysql
			if(strripos($Data,"-")!==FALSE){
				$Tmps=explode(" ",$Data);
				$Tmp1=explode("-",$Tmps[0]);
				$Tmp2=explode(":",$Tmps[1]);	
				$this->Data = new oxs_Data($Tmp1[2].".".$Tmp1[1].".".$Tmp1[0]." ".$Tmp2[0].":".$Tmp2[1].":".$Tmp2[2]);

			}else{
				$this->Data = new oxs_Data($Data);				
			}	

			if($UTC==NULL){
				$this->SetUtc(0);	
			}else{
				$this->SetUtc($UTC);
				$this->UseUtc(0);	
				$this->SetUtc(0);					
			}			
		}

		function SetUTC($Value){
			$this->Data->UTC = $Value;
		}

		function UseUTC($Value){
			$Tmp = $this->Data->UTC;
			$this->SetUtc($Value);
			$Value = $Value - $Tmp;
			$this->Hour($Value);
		}
		

		function get($Tag,$UTC=NULL,$Param=null){			

			//	Применяем указанный UTC
			if($UTC!=NULL){				
				$this->UseUtc($UTC);	
				$this->SetUtc($UTC);			
			}

			$R = $this->$Tag($Param);

			//	Возращшаем его обратно
			if($UTC!=NULL){
				$this->UseUtc(0);	
				$this->SetUtc(0);			
			}

			return $R;
		}		
		
	}
