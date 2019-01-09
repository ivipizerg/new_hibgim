<?php

	define("OXS_PROTECT",TRUE);

	class templatemanager extends CoreSingleLib{		

		public $Head;
		private $TplCode=NULL;
		private $Title;
		private $TemplateName;
		public $mode = "admin";
	

		function __construct($Path){
			parent::__construct($Path);
		}

		//	Получить ранее выбранный шаблон
		function ShowTemplate(){
			return $this->TplCode;
		}

		//	выбрать и прогнать шаблон по умолчанию
		function ChoiseDefaultTemplate($mode="admin"){
				
			$this->mode = $mode;

			$name_default_template = Oxs::G("templatemanager:model")->GetDefaultTemplateName($mode);
			if($name_default_template==null){
				$this->Msg("Не найден шаблон по умолчанию или проблема с базой данных","ERROR");
			}

			$this->ChoiseTemplate($name_default_template);
		}

		//	Выбрать и прогнать шаблон
		function ChoiseTemplate($TemplateName,$Param=null){
				
			if(empty($Param["mode"])) $this->mode = "admin";
			else $this->mode = $Param["mode"];

			$this->LoadTemplate($TemplateName);			

			$Moduls=$this->GetModuls();			

			for($i=0;$i<count($Moduls);$i++){								
				try{			
					$this->InsertModulResult($Moduls[$i],Oxs::G("modulmanager")->ExecModul("admin/tpl/".$TemplateName."/moduls/".$Moduls[$i]."/".$Moduls[$i].".php"));	
				}catch(Throwable $e){
					echo "</script>Проблема с выполнением модуля: ".$Moduls[$i]."<br><br>";
					echo $e;
					die();
				}
			}

			$this->TplCode = str_replace("{oxs:head}",$this->Head,$this->TplCode);
		}

		function LoadTemplate($TemplateName){
			Oxs::G("BD")->Start();
				
			$this->TemplateName=$TemplateName;	

			if(Oxs::G("file")->CheckFile("admin/tpl/".$this->TemplateName."/".$this->TemplateName.".php"))
				Oxs::IF("admin/tpl/".$this->TemplateName."/".$this->TemplateName.".php");
			else{
				$this->Msg("Не найден шаблон ".$this->TemplateName,"FATAL_ERROR");
				return 0;			
			}

			$this->TplCode = Oxs::G("BD")->GetEnd();
		}

		function GetModuls(){				
			
			if($this->TplCode==NULL){
				$this->Msg("Шаблон не загружен","FATAL_ERROR");
				return 0;
			}

			//	Выбраем модули
			preg_match_all("/<oxs:([a-zA-Z0-9_]*)>/",$this->TplCode,$Result);

			if(count($Result[1])==0) return NULL;
			return $Result[1];
		}		

		function InsertModulResult($ModulName,$ModulResult){			
			$this->TplCode=str_replace("<oxs:".$ModulName.">",$ModulResult,$this->TplCode);
		}		

		function HeadAdd($Text){
			$this->Head .= $Text;
		}

		function SetTitle($Text){
			$this->Title=$Text;
		}

		function GetTitle(){
			return $this->Title; 
		}

		function getTemplateName(){
			return $this->TemplateName;
		}		

	}

?>
