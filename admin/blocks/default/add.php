<?php
	if(!defined("OXS_PROTECT"))die("protect");

	class default_add extends BlocksSingleLib{
		
		function __construct($Path){	
			parent::__construct($Path);					
		}
		
		function LoadMyJS(){	
			Oxs::G("js.loader")->GetObject("default.js:active_buttons");
			Oxs::G("js.loader")->GetObject("default.js:add");
		}

		function Map(){
			return "<oxs:default>";
		}

		function LoadFields(){
			return Oxs::G("fields:model")->GetFieldsForBlock();
		}	

		function GetData(){
			return null;
		}
		
		function Exec(& $Param=null){	
			
			//	Получаем карту
			$Map = $this->Map();

			//	Получаем поля блока
			$Fields = $this->LoadFields();

			//	Если нет полей то че дальше то пытаться что то сделать?
			if(empty($Fields)){
				$this->SetAjaxCode(-1);			
				//	Сообщение для всплывашки
				$this->SetAjaxText( Oxs::G("languagemanager")->T("noFields") );
				return TRUE;
			}
			
			//	Дата пустая так как доабвляем новый элемент в блок
			$Data = $this->GetData($Param);
			
			if(is_array($Data)){
				$Data = $Data[0];				
			}			

			//	Применяем фильтры
			Oxs::G("filters_manager")->Exec($Fields,$Data);			
			
			//	Таблица для дефалта
			$Table = Oxs::L("table",array("count" => 1 , "class" => "oxs_fields_table"));
				
			//	Перебираем фильтры и вставляем в конец карты	
			for($i=0;$i<count($Fields);$i++){			
				
				//	Ищем место для кода в карте
				if(stristr($Map,"<oxs:".$Fields[$i]["system_name"].">")!=FALSE){
					//	Если нашли подменяем
					$Map = str_replace("<oxs:".$Fields[$i]["system_name"].">", Oxs::G("fields")->GetFieldCode($Fields[$i],$Data[$Fields[$i]["system_name"]]), $Map);
				}else{						
					//	не нашли вставялем в дефалтную позицию
					if($Fields[$i]["type"]!="hidden")	
						$Table->add( "<div class=oxs_fields_table_wrap>".Oxs::G("fields")->GetFieldCode($Fields[$i],$Data[$Fields[$i]["system_name"]])."</div>"  );
					else
						$Table->add( "".Oxs::G("fields")->GetFieldCode($Fields[$i],$Data[$Fields[$i]["system_name"]]).""  );
				}
			}	

			//	Убираем лишнее
			$Map = str_replace("<oxs:default>",$Table->Show(true), $Map);				

			//	Выводим карту
			echo $Map;
		}
	}