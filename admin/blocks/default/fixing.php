
<?php
	if(!defined("OXS_PROTECT"))die("protect");	

	class default_fixing extends BlocksSingleLibSelectable{
		
		function __construct($Path){	
			parent::__construct($Path);			
		}	

		function Remove(){
			$this->setP("currentId",$_SESSION["oxs_copy_cut_id"]);
			$this->setP("changeId",$this->getIds()[0]);
			Oxs::G("default:position")->Exec();
		}

		function Copy(){

			//	Получаем поля элемента котоырй жуно переместить
			$Fields = Oxs::G("fields:model")->GetFieldsForBlock();

			//	Строим запрос дял получения данных
			$field_string="";
			for($i=0;$i<count($Fields);$i++){
				$field_string .= "`".$Fields[$i]["system_name"]."`,";
			}$field_string = trim($field_string,",");

			$Results = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT ".$field_string." FROM `#__oxs:sql` WHERE `id` = 'oxs:id' " , $this->GetP("block_name") , $_SESSION["oxs_copy_cut_id"]);

			
			$T=array();
			for($i=0;$i<count($Fields);$i++){				
				$T[$Fields[$i]["system_name"]] = $Results[0][$Fields[$i]["system_name"]];
			}			

			$TT = $this->getD();
			$this->setD(NULL,$T);
			if(Oxs::G("default:add_end")->ExecBefore()!=TRUE)
				Oxs::G("default:add_end")->Exec();			
			$this->setD(NULL,$TT);

			//	Меняем новой записи позиицию	
			$this->setP("currentId",Oxs::G("default:add_end")->getLastId());
			$this->setP("changeId",$this->getIds()[0]);
			Oxs::G("default:position")->Exec();			
			
		}

		function ExecBefore(){

			if(parent::ExecBefore()) return TRUE;	

			//	Очистка данных при переходе на новый блок
			if($this->getP("reset_block")){
				unset($_SESSION["oxs_copy_cut_id"]);
				unset($_SESSION["oxs_copy_cut_mode"]);
			}	

			//	Проверяем не выбрано ли несколько элементов
			if(count($this->getIds())>1){
				$this->SetAjaxCode(-1);				
				$this->SetAjaxText(Oxs::G("message_window")->Error(Oxs::G("languagemanager")->T("MultiselectPosition")));
				return TRUE;
			}		
		}

		//	Нам приходит id перемещаемого 
		//	и id после которого нужно вставиться
		function Exec(){		

			switch($this->getM("mode")){
				//	Вырезать
				case 1 : 
					$this->SetAjaxCode(-1);	
					$this->SetAjaxText(Oxs::G("message_window")->Info(Oxs::G("languagemanager")->T("CuteSelect")));	
					$_SESSION["oxs_copy_cut_id"] = $this->getIds()[0];
					$_SESSION["oxs_copy_cut_mode"] = 1; 
				break;
				//	Скопировать
				case 2 : 
					$this->SetAjaxCode(-1);	
					$this->SetAjaxText(Oxs::G("message_window")->Info(Oxs::G("languagemanager")->T("CopySelect")));	
					$_SESSION["oxs_copy_cut_id"] = $this->getIds()[0];
					$_SESSION["oxs_copy_cut_mode"] = 2;
				break;	
				case 3 : 				

					if($_SESSION["oxs_copy_cut_mode"]==1){
						$this->Remove();
					}

					if($_SESSION["oxs_copy_cut_mode"]==2){
						$this->Copy();
					}

					unset($_SESSION["oxs_copy_cut_id"]);
					unset($_SESSION["oxs_copy_cut_mode"]);

					if(Oxs::G("logger")->Get("ERROR")){
						$this->SetAjaxCode(-1);				
						$this->SetAjaxText(Oxs::G("message_window")->ErrorUl("ERROR"));		
						return TRUE;	
					}else{
						$this->SetAjaxCode(1);
						$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName);
						$this->SetAjaxText(Oxs::G("message_window")->Good(Oxs::G("languagemanager")->T("COPY_CUT_SUCCESS")));
					}
				break;			
			}				
		}
	}