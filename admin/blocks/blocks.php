<?php

	define("OXS_PROTECT",TRUE);

	class BlocksLib extends Lib{

		public $BlockName;
		public $Action;
		public $Param;	

		protected $postsInPage = 50;		

		function __construct($Path,$params=null){
			parent::__construct($Path,$params);			
		}

		//	Подгрузка необходимых JS обработичков и блиотек
		function LoadMyJS(){
			return ;
		}

		function LoadFields(){
			return Oxs::G("fields:model")->GetFieldsForBlock();
		}	

		function ShowNavigation($page){

			function FooNavigation($i,$Data,$obj){
				return "<div class='oxs_my_navigation_item oxs_active oxs_active_style' data-route=\"".(Oxs::G("datablocks_manager")->RealCurrentBlockName).":display\">".$i."</div>";
			}

			$Nav = Oxs::L("navigation",array(
				"all" => $this->GetCount(),
				"interval" => 5 ,
				"count" => $this->postsInPage,
				"page" => $page,
				"Foo" => FooNavigation
			));		

			echo $Nav->Show();
		}

		function getP($Name){
			return Oxs::G("datablocks_manager")->Params[$Name]["value"];
		}

		function setP($Name,$Value){
			Oxs::G("datablocks_manager")->Params[$Name]["value"] = $Value;
		}

		function getD($Name=NULL){
			if($Name==NULL) return Oxs::G("datablocks_manager")->Params["data"]["value"];
			return Oxs::G("datablocks_manager")->Params["data"]["value"][$Name];
		}

		function setD($Name=NULL,$Value=NULL){
			
			if($Name==NULL){
				Oxs::G("datablocks_manager")->Params["data"]["value"] = $Value;
			}

			Oxs::G("datablocks_manager")->Params["data"]["value"][$Name] = $Value;
		}

		function getM($Name){
			return $this->getP("mode_string")[$Name];
		}

		function setM($Name,$Valeu){
			Oxs::G("datablocks_manager")->Params["mode_string"][$Name]= $Valeu;
		}

		//	Шапка блока
		function GetHead(){			

			return "<div class=oxs_block_head><table width=100% border=0><tr><td>".(
				Oxs::GetLib("blocks:model")->GetAboutBlockByName( Oxs::G("datablocks_manager")->RealCurrentBlockName )[0]["name"]
			)." - ".(
				Oxs::GetLib("blocks:model")->GetAboutBlockByName( Oxs::G("datablocks_manager")->RealCurrentBlockName )[0]["description"]
			)."</td><td><div class=oxs_head_buttons>".$this->GetButtons()."</div></tr></tr></table></div>";
		}

		//	Кнопки управленяи блока
		function GetButtons(){	

			$List = Oxs::G("buttons:model")->GetButtonsForBlock(Oxs::G("datablocks_manager")->CurrentBlock);

			if(empty($List)){
				return ;
			}				

			$Tree=Oxs::L("DBTree",array("db" => Oxs::G("DBLIB.IDE")->DB() , "table" => "#__buttons"));	
			
			Oxs::G("oxs_obj")->G( "DBTree"  );	
			Oxs::G("BD")->Start();

			?>

			<script type="text/javascript">
					
				$(function(){											

					DBTree.setAim(".DBTree_menu");
					DBTree.setSubAim(".oxs_DBTree_menu_sub_menu");				
					DBTree.useHorisontMenu("left");

				});

			</script>

			<?php

			return "<div class=block_menu><STYLE>.DBTree_menu{display:none;}</STYLE>".$Tree->GetUl($List,array( "ulstyle" => "DBTree_menu", 
				"treangle" => function($Item){
					if($Item["level"]<=2){
						return "<div class='oxs_DBTree_menu_sub_menu' style='cursor:default;margin-top:-17px;margin-left:-0px;font-size:18px; '>⏷</div>";
					}

					if($Item["level"]>2)
						return "<div class='oxs_DBTree_menu_sub_menu' style='cursor:default;margin-top:-21px;margin-left:-0px;font-size:14px; '>⏴</div>";
				},
				"Foo" => function($Item){
				
				return "<div class='oxs_active' ".$Item["ui_class"]."' data-route=\"".(explode("?",$Item["action"])[0])."\" data-mode=\"".(explode("?",$Item["action"])[1])."\">&nbsp&nbsp".$Item["name"]."</div>";
					
			} ))."</div>".Oxs::G("BD")->getEnd();			
			
		}		

		function Exec(){
			return ;
		}

		function ExecAfter(){
			return ;
		}

		function ExecBefore(){
			return ;
		}

		function Destruct(){
			return ;
		}
		
	}

	class BlocksMultiLib extends BlocksLib{

		protected $oxs_Type="multilib";

		//	Констурктор по умолчанию
		function __construct($Path){
			parent::__construct($Path);
		}

		function Init($Param=NULL){
			return 0;
		}
	}

	class BlocksSingleLib extends BlocksLib{

		protected $oxs_Type="singlelib";

		//	Констурктор по умолчанию
		function __construct($Path,$params=null){
			parent::__construct($Path,$params);			
		}
	}

	class BlocksSingleLibSelectable extends BlocksSingleLib{
		
		protected $selected_id = null;

		//	Констурктор по умолчанию
		function __construct($Path,$params=null){
			parent::__construct($Path,$params);	

			//	Выбраныне id приходят в виде строки через запятую
			//	делим на массив			
			$this->selected_id = explode(",",$this->getP("oxs_selected_id"));			
		}		

		function ExecBefore(){

			if(empty($this->getP("oxs_selected_id"))){
				$this->SetAjaxCode(-1);
				$this->SetAjaxText(Oxs::G("languagemanager")->T("noSelectedToRemove"));
				return TRUE;
			}			
		}

		function getIds(){
			return $this->selected_id;
		}
	}

?>
