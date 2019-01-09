<?php

	if(!defined("OXS_PROTECT"))die("protect");

	class _dialog {

		private $HTML = "";

		function __construct(){
			Oxs::G("field");			
		}
		
		function addButton($Text,$Name,$Param=null){
			if(empty($Param["class"]))$Param["class"] = "btn btn-default"; 
			$this->HTML .= field::Button($Name,$Text,$Param);
		}

		function addText($Text){
			$this->HTML .= $Text;
		}

		function addTextField(){
			//$HTML .= field::Text($Name,$Text,array( "attr"=>$attr , "class"=>"form-control oxs_field_value" , "style" => "margin-top:3px;".$Field["field_style"] , "auto_clear" => $Field["form_name"]) );
		}

		function addHtml($html){
			$this->HTML .= $html;
		}

		function addBr(){
			$this->HTML .= "<br>";
		}

		function getHtml(){
			return $this->HTML;
		}

		function setCloseButton($Class){
			Oxs::G("BD")->Start();
			?>
			<script type="text/javascript">
				$(function(){
					sys_dialog.setCloseEvent("<?php echo $Class;?>");
				});
			</script>
			<?php
			$this->HTML .= Oxs::G("BD")->GetEnd();
		}

		function setRoute($Class,$Route){
			Oxs::G("BD")->Start();
			?>

				<script type="text/javascript">
					jQuery(function(){
						jQuery("<?php echo $Class;?>").attr("data-route","<?php echo $Route;?>");
						//jQuery("<?php echo $Class;?>").addClass("oxs_active");
						jQuery("<?php echo $Class;?>").addClass("oxs_active_dialog");
						sys_dialog.setRoute("<?php echo $Class;?>");
					});
				</script>

			<?php

			//	На вскйи случай подключим active_buttons, вдруг они не подключены
			//Oxs::G("js.loader")->GetObject("default.js:active_buttons");	

			$this->HTML .= Oxs::G("BD")->GetEnd();
		}
	}

	class dialog extends CoreSingleLib{	
		
		function __construct($_Path,$Params=null){
			parent::__construct($_Path,$Params);				
		}

		function BuildDialog( _dialog $D){				
			return $D->getHtml();
		}

		function AskUser($Varibale,$Text){

			$D  = new _dialog();
			$D->addText($Text);
			$D->addBr();
			$D->addBr();			
			$D->addButton(Oxs::G("languagemanager")->T("yes"),$Varibale,array("style" => "width:70px;"));
			$D->addHtml("&nbsp;&nbsp;");
			$D->addButton(Oxs::G("languagemanager")->T("no"),"oxs_dialog_no",array("style" => "width:70px;"));
			$D->setCloseButton("[name=oxs_dialog_no]");
			$D->setRoute("[name=".$Varibale."]",Oxs::G("datablocks_manager")->CurrentBlock);
			
			$this->SetAjaxCode(2);		
			$this->SetAjaxData("dialog",$this->BuildDialog($D));	
		}	

		function Init(){
			Oxs::G("dom")->LoadCSSOnce("admin/tpl/default/css/dialog.css");		
			Oxs::G("js.window")->GetObject("dialog_window");		
			Oxs::G("oxs_obj")->G("dialog",NULL,"sys_dialog");
		}
	}

?>
