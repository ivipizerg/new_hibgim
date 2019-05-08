<?php

	if(!defined("OXS_PROTECT"))die("protect");

	class _dialog {

		private $uiNmae;		

		private $HTML = "";
		private $CSS = "";
		private $JS = "";

		function __construct($uiName){
			$this->uiNmae = $uiName;
			Oxs::G("field");			
		}
		
		function Css($cssFile){		
			Oxs::G("BD")->Start();
			$this->CSS .= Oxs::G("dom")->LoadCSSOnce($cssFile);
			$this->JS .= Oxs::G("BD")->getEnd();
		}

		function js($C , $farVar=null){
			Oxs::G("BD")->Start();
			Oxs::G("oxs_obj")->G($C,array($this->uiNmae , $farVar),"oxs_".$$C.$this->uiNmae);
			$this->JS .= Oxs::G("BD")->getEnd();
		}		

		function addButton($Text,$Name,$Param=null){
			if(empty($Param["class"]))$Param["class"] = "btn btn-default"; 
			$this->HTML .= field::Button($Name,$Text,$Param);
		}

		function addText($Text){
			$this->HTML .= $Text;
		}

		function addPassword($Name,$Text=NULL,$Desc=null,$Param=null){
			$this->HTML .= field::Password($Name,$Text,array( "attr"=> $Param["attr"] , "class"=>"form-control ".$Param["class"] , "style" => "margin-top:3px; ".$Param["style"] , "auto_clear" => $Desc) );
		}

		function addEdit($Name,$Text=NULL,$Desc=null,$Param=null){
			$this->HTML .= field::Text($Name,$Text,array( "attr"=> $Param["attr"] , "class"=>"form-control ".$Param["class"] , "style" => "margin-top:3px; ".$Param["style"] , "auto_clear" => $Desc) );
		}

		function addHtml($html){
			$this->HTML .= $html;
		}

		function addBr(){
			$this->HTML .= "<br>";
		}

		function build(){

			Oxs::G("BD")->Start();

			//	Обернем диолог в оконце
			Oxs::G("js.window")->GetObject("dialog_window_".$this->uiNmae);		
			
			echo $this->CSS;
			echo $this->JS;

			?>
			
			<script type="text/javascript">
					
					$(function(){
						dialog_window_<?php echo $this->uiNmae;?>.set("<div class='oxs_all_dialogs oxs_dialog_<?php echo $this->uiNmae;?>'>" + (decodeURIComponent("<?php echo rawurlencode($this->HTML);?>")) + "</div>");						
						dialog_window_<?php echo $this->uiNmae;?>.stick("center","center");
						dialog_window_<?php echo $this->uiNmae;?>.show();
						oxs_black_screen.On();

						oxs_black_screen.addCode(function(){
							dialog_window_<?php echo $this->uiNmae;?>.hide();
						},"dialog");

					});

			</script>

			<?php			

			return Oxs::G("BD")->getEnd();			
		}	
	}

	class dialog extends CoreMultiLib{	
		
		public $uniqueName;

		function __construct($_Path,$Params=null){
			$this->uniqueName = Rand();				
			parent::__construct($_Path,$Params);				
		}		

		function AskUser($Text,$farVar){

			$D  = new _dialog($this->uniqueName);
			$D->addText($Text);
			$D->addBr();
			$D->addBr();			
			$D->addButton(Oxs::G("languagemanager")->T("yes"),"oxs_dialog_button_yes_".$this->uniqueName,array("style" => "width:70px;"));
			$D->addHtml("&nbsp;&nbsp;");
			$D->addButton(Oxs::G("languagemanager")->T("no"),"oxs_dialog_button_no_".$this->uniqueName,array("style" => "width:70px;"));
			$D->Css("admin/tpl/default/css/dialog.css");			
			$D->js( "dialog:dialog_yes_no" , $farVar);				

			$this->buildDialog($D);
		}	

		function buildDialog(_dialog $D){
			$this->SetAjaxCode(2);			
			$this->SetAjaxData("dialog",$D->build());
		}		
	}

?>
