<?php
	if(!defined("OXS_PROTECT"))die("protect");

	class default_display extends BlocksSingleLib{

		//	Таблица выборки данных для блока
		private $Data;
		private $Fields;		

		function __construct($Path,$Params=null){	
			parent::__construct($Path,$Params);				
		}

		function LoadMyJS(){
			
			Oxs::G("oxs_obj")->G("default.js.display");			
			Oxs::G("oxs_obj")->G("default.js.display:fix");
			Oxs::G("oxs_obj")->G("default.js.display:navigation");

			Oxs::G("oxs_obj")->G("default.js:collect_cheked_id");
			Oxs::G("oxs_obj")->G("default.js:active_buttons");		
			
			Oxs::G("search")->Init();			
			Oxs::G("dialog")->Init();			

			Oxs::G("oxs_obj")->G("default.js.display:position");
			//Oxs::G("js.loader")->ReGetObject("default.tree.js:fixing");					
		}

		function getLimits($Page){
			$this->Msg("Пришла странциа" + $Page, "MESSAGE");
			if($Page==-1) return ;
			if(empty($Page)) $Page=1;
			return "LIMIT ".(($Page*$this->postsInPage)-$this->postsInPage.",".($this->postsInPage));	
		}

		function getFieldsForSearch(){
			$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SHOW  COLUMNS FROM `#__oxs:sql`" , Oxs::G("datablocks_manager")->RealCurrentBlockName);
			if(!$R){
				return null;
			}

			$T = array();

			for($i=0;$i<count($R);$i++){				
				if( $R[$i]["Field"]!="id" && $R[$i]["Field"]!="create_data" && $R[$i]["Field"]!="update_data" && $R[$i]["Field"]!="status" && $R[$i]["Field"]!="create_data" && $R[$i]["Field"]!="position" )
					array_push($T,$R[$i]["Field"]);
			}			

			return $T;
		}
		
		function GetCount(){

			$R = $this->LoadData(-1);

			if(!$R){
				return 0;
			}else{
				return count($R);
			}
		}

		function LoadData($Page){	

			$Sql = Oxs::L("sqlsearch");
			
			$T = $this->getFieldsForSearch();	

			//	базовый запрос
			Oxs::G("DBLIB.IDE")->DB()->SetQ( "SELECT * FROM `#__".Oxs::G("datablocks_manager")->RealCurrentBlockName."` ORDER BY `position` ASC " );			
			
			//	Добавляем поиск
			$DB = $Sql->search(Oxs::G("DBLIB.IDE")->DB(),$this->getP("searchString"),$T);		

			//	Дописываем лимиты
			$DB->AddQ(" ".$this->getLimits($Page));			

			return $DB->Exec();
		}

		function LoadFields(){
			return Oxs::G("fields:model")->GetFieldsForBlock();
		}		

		function FieldsProcessing($Fields){
			return $Fields;
		}

		function DataProcessing($Data){
			return $Data;
		}

		function addCheckBox(& $Fields,& $Data){
			Oxs::I("field");
			//	Чекбокс главный
			array_unshift($Fields,array( "system_name" => "oxs_checkBoxMainTable" , "filters" => "class /d oxs_no_click , style /f \"width:20px;text-align:center;\" /d \"width:20px;text-align:center;padding:0px;\"" ,  "name"=>field::Checkbox("oxs_checkBoxMainTable"  ) ));

			$T = count($Data);
			for($i=0;$i<$T;$i++){
				 if( empty($Data[$i]["checkbox_template"]) && $Data[$i]["checkbox_template"] != "no_chekbox"  ) $Data[$i]["oxs_checkBoxMainTable"] = field::Checkbox( "oxs_checkBoxMainTableItem"  , null , array(  "attr" => "data-id=".$Data[$i]["id"] ));
				 else
				 	if($Data[$i]["checkbox_template"] != "no_chekbox")
				 		$Data[$i]["oxs_checkBoxMainTable"] = $Data[$i]["checkbox_template"];
			}
			return 1;
		}

		function addId(& $Fields,& $Data){			
			array_unshift($Fields,array( "system_name" => "oxs_id" , "filters" => "style /f \"width:20px;text-align:center;\" /d \"width:20px;text-align:center;\"" ,  "name"=> "ID" ));

			$T = count($Data);
			for($i=0;$i<$T;$i++){
				 $Data[$i]["oxs_id"] =  $Data[$i]["id"];
			}
			return 1;
		}

		function addDradArea(& $Fields,& $Data){			
			array_push($Fields,array( "system_name" => "oxs_drag_zone" , "filters" => "style /f \"width:20px;text-align:center;\" /d \"width:20px;text-align:center;\"" ,  "name"=> "" ));

			$T = count($Data);
			for($i=0;$i<$T;$i++){
				 $Data[$i]["oxs_drag_zone"] =  "<div class='oxs_drag_zone' style=''>&nbsp</div>";
			}
			return 1;
		}

		function ExecBefore(){
			//	если сброс блока то сбрасываем странциу и окн опоиска
			if($this->getP("reset_block")==1){
				$this->setP("page",1);
				$this->setP("searchString","");
			}
		}

		function Exec(){

			$C  = $this->GetCount();

			if($this->getP("searchString")!=""){
				$this->SetAjaxCode(3);
				$this->SetAjaxText( "По запросу: \"" . ($this->getP("searchString")) . "\" найдено: " . $C);
			}

			if($C==0){
				echo "<div class=oxs_warning_message>".(Oxs::G("languagemanager")->T("noRecords"))."</div>";
				return TRUE;
			}	
			
			$this->Data=$this->DataProcessing($this->LoadData($this->getP("page")));	
			
			$this->Fields=$this->FieldsProcessing($this->LoadFields());				

			if(empty($this->Fields)){
				echo "<div class=oxs_warning_message>".(Oxs::G("languagemanager")->T("blockHaveNoFields"))."</div>";
				return TRUE;
			}

			//	Если были ошибки с дотсупом к данынм выводим ошибку
			if(Oxs::G("logger")->Get("ERROR")){
				$this->SetAjaxCode(-1);
				$this->SetAjaxText(Oxs::G("message_window")->ErrorUl( "ERROR" ) );
				return TRUE;
			}		
			
			//	Создаем обьект Таблицы
			$MainTable = Oxs::L("content_table.main_table"); 

			//	Добавляем чекбоксы
			$this->addId($this->Fields,$this->Data);

			//	Добавляем id
			$this->addCheckBox($this->Fields,$this->Data);

			//	Добавляем зону перетаскивания
			$this->addDradArea($this->Fields,$this->Data);
			
			//	Применяем фильтры			
			Oxs::G("filters_manager")->Exec($this->Fields,$this->Data);			

			//	Выводим содержимое
			echo $MainTable->Show($this->Fields,$this->Data);			
			
			echo $this->ShowNavigation($_GET["page"]);			
			
		}		
	}