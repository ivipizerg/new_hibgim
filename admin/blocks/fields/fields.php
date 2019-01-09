 <?php
	if(!defined("OXS_PROTECT"))die("protect");

	class fields extends BlocksSingleLib{
		
		function __construct($Path){	
			parent::__construct($Path);			
		}

		//	Получить поле
		function GetFieldCode($Field,$Data=null){			

			$FieldType = $Field["type"];			 

			//	Если тип блока default все ок
			//	Если нет то ищем 

			//	Ищем поле в нашем собственном блоке, если не находим ищем в нестнадртном дефалтном иначе в дефалтном	
			if(Oxs::isExist(Oxs::G("datablocks_manager")->RealCurrentBlockName.":fieldsTyps")){
				$this->Msg("Нашел собственный обработчик полей:".Oxs::G("datablocks_manager")->RealCurrentBlockName.":fieldsTyps","MESSAGE");
				//	Существует ли метод
				if(Oxs::isFunctionExist(Oxs::G("datablocks_manager")->RealCurrentBlockName.":fieldsTyps",$FieldType)){
					$this->Msg("Нашел поле","MESSAGE");
					try{
						return Oxs::G(Oxs::G("datablocks_manager")->RealCurrentBlockName.":fieldsTyps")->$FieldType($Field,$Data);
					}catch(Throwable $e){
						$this->SetAjaxCode(-1);
						$this->SetAjaxText(Oxs::G("languagemanager")->T("dataBlocksFieldError",$e));
					} catch (Exception $e) {
	          			$this->SetAjaxCode(-1);
						$this->SetAjaxText(Oxs::G("languagemanager")->T("dataBlocksFieldError",$e));
	     			}   
	     			return ;
				}else{
					$this->Msg("Не нашел поле: \"" . $FieldType ."\"" ,"MESSAGE");
				}

			}else if( Oxs::isExist("default.".Oxs::G("datablocks_manager")->Type.":fieldsTyps") && Oxs::G("datablocks_manager")->Type!="default" ){

				$this->Msg("Нашел дефалтный уникальный обработчик полей","MESSAGE");

				if(Oxs::isFunctionExist("default.".Oxs::G("datablocks_manager")->Type.":fieldsTyps",$FieldType)){
					$this->Msg("Нашел поле","MESSAGE");
					try{
						return Oxs::G("default.".Oxs::G("datablocks_manager")->Type.":fieldsTyps")->$FieldType($Field,$Data);
					}catch(Throwable $e){
						$this->SetAjaxCode(-1);
						$this->SetAjaxText(Oxs::G("languagemanager")->T("dataBlocksFieldError",$e));
					} catch (Exception $e) {
	          			$this->SetAjaxCode(-1);
						$this->SetAjaxText(Oxs::G("languagemanager")->T("dataBlocksFieldError",$e));
	     			}   
	     			return ;
				}

			}else{

				$this->Msg("Нашел собственный дефалтный обработчик полей","MESSAGE");

				if(Oxs::isFunctionExist("default:fieldsTyps",$FieldType)){
					$this->Msg("Нашел поле","MESSAGE");
					try{
						return Oxs::G("default:fieldsTyps")->$FieldType($Field,$Data);
					}catch(Throwable $e){
						$this->SetAjaxCode(-1);
						$this->SetAjaxText(Oxs::G("languagemanager")->T("dataBlocksFieldError",$e));
					}catch (Exception $e) {
	          			$this->SetAjaxCode(-1);
						$this->SetAjaxText(Oxs::G("languagemanager")->T("dataBlocksFieldError",$e));
	     			} 

	     			return ;
				}

			}

			$this->SetAjaxCode(-1);
			$this->SetAjaxText(Oxs::G("languagemanager")->T("data_blocks_field_not_found",$FieldType));			
		}

		function checkType($Type){			
			switch($Type){
				case "text": break;
				case "tinyint": break;
				case "tinytext":  break;
				case "int":  break;
				case "boolean":  break; 
				default: 
					$this->SetAjaxCode(-1);
					//	Сообщение для всплывашки
					$this->SetAjaxText( Oxs::G("languagemanager")->T("cantChangeTypeWrongTipe" , $CurrentField["block_name"] , $Type) );
					return TRUE;
				break ; 
			}
		}

		function changeKey($Fields,$Key1,$Key2){
			
			for($i=0;$i<count($Fields);$i++){
				
				if($Fields[$i]["system_name"]==$Key1){
					$Fields[$i]["system_name"]=$Key2;					
				} 
			}

			return $Fields;
		}		
		
		function convertTypeFroBD($T,$DefaultFoo=null){
			//	Определяем тип поля
			switch($T["db_type"]){
				case "text": $key = "sql"; break;
				case "tinytext": $key = "sql"; break;
				case "tinyint": $key = "sql"; break;
				case "int": $key = "int"; break;
				case "boolean": $key = "int"; break; 
				default: 	
					if($DefaultFoo!=NULL) $DefaultFoo($T);
					$this->SetAjaxCode(-1);
					//	Сообщение для всплывашки
					$this->SetAjaxText( Oxs::G("languagemanager")->T("cantConvertFieldType" , $T["name"] , $T["db_type"]) );
					return null;
				break ; 
			}		

			return $key;
		}
	}
