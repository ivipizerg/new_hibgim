<?php

	if(!defined("OXS_PROTECT"))die("Wrong start point");

	class js_ajaxexec extends SingleLib{

		function __construct($Path,$params=null){
			parent::__construct($Path,$params);
		}

		function GetObject( $Name="ajexec", $Param=NULL ){	
			
			//	Обрабатываем входящие параметры
			////////////////////////////////////////////////////////////
			if($Param["log"]=="off"){
				$WinObj="";				
			}
			else{ 
				
				$old_name = $Name;
				
				if(!empty($Param["window_name"])){
					$Name = $Param["window_name"];					
				}

				//	Создаем отладочное окно
				$WinObj = Oxs::G("logger.debug_window")->Init($Name);			

				//	Создаем обьект для аякс
				Oxs::G("js.protector_ajax")->GetObject("protector_ajax_".$Name);
				
				//	Готовим список источников
				$SOURCES="";
				for($i=0;$i<=Oxs::GetPathCount();$i++){
					$SOURCES .= Oxs::GetPath($i).",";
				}$SOURCES = str_replace(",,","",$SOURCES);

				Oxs::G("js.loader")->GetObject("js.ajaxexec",
					array(  $this->Path ,  $Param["start_code"] , $SOURCES ,   $WinObj , "protector_ajax_".$Name  )
				,$old_name);

			}
		}
	}
