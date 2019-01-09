<?php
		
	if(!defined("OXS_PROTECT"))die("protect");	

	class oxs_Data{

		public $Year;
		public $Mount;
		public $CountDays;
		public $Day;
		public $Week;

		public $Hours;
		public $Minuts;
		public $Seconds;

		public $UTC=NULL;		

		function __construct($String=NULL){

			if(Oxs::G("cheker")->Int($String,"+")){
				//	Пришло число думаем что это UNux формат
				$this->Year = date("Y",$String);
				$this->Mount = date("m",$String);
				$this->CountDays = date("t",$String);
				$this->Day = date("d",$String);

				$this->Hours = date("G",$String);
				$this->Minuts = date("i",$String);
				$this->Seconds = date("s",$String);
				
			}else if( $String==NULL or empty($String) ){
				$this->Year = date("Y");
				$this->Mount = date("m");
				$this->CountDays = date("t");
				$this->Day = date("d");

				$this->Hours = date("G");
				$this->Minuts = date("i");
				$this->Seconds = date("s");
			}else{

				//	Ищем пробел, если он есть то указана и дата и время
				if( strripos($String," ") !== FALSE ){
					$String = explode(" ",$String);

					$String[0] = explode(".",$String[0]);

					$this->Year = $String[0][2];
					$this->Mount = str_pad($String[0][1],2,0, STR_PAD_LEFT);
					$this->CountDays = date("t" , strtotime($String[0][2]."-".$String[0][1]) );
					$this->Day =  str_pad($String[0][0],2,0, STR_PAD_LEFT);

					$String[1] = explode(":",$String[1]);

					$this->Hours = str_pad($String[1][0],2,0, STR_PAD_LEFT);
					$this->Minuts = str_pad($String[1][1],2,0, STR_PAD_LEFT);
					$this->Seconds = str_pad($String[1][2],2,0, STR_PAD_LEFT);
				}else{
					//	Если же нет проблеа то ищем двоеточие, если оно есть то указано только время
					//	Если нет то указна только дата
					if( strripos($String,":") !== FALSE ){

						$this->Year = date("Y");
						$this->Mount = date("m");
						$this->CountDays = date("t");
						$this->Day = date("d");

						$String = explode(":",$String);

						$this->Hours = str_pad($String[0],2,0, STR_PAD_LEFT);
						$this->Minuts = str_pad($String[1],2,0, STR_PAD_LEFT);
						$this->Seconds = str_pad($String[2],2,0, STR_PAD_LEFT);
					}else{
						$String = explode(".",$String);

						$this->Year = $String[2];
						$this->Mount = str_pad($String[1],2,0, STR_PAD_LEFT);
						$this->CountDays = date("t" , strtotime($String[2]."-".$String[1]) );
						$this->Day =  str_pad($String[0],2,0, STR_PAD_LEFT);

						$this->Hours = date("G");
						$this->Minuts = date("i");
						$this->Seconds = date("s");
						$this->UTC=date("Z")/60/60;
					}
				}
			}

			$this->Week =  date( "N" , strtotime( $this->Year."-".$this->Mount."-".$this->Day  ) );
		}
	} 
