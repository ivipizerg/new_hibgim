<?php

if(!defined("OXS_CMS_PROTECT"))die("protect");

class autentificator_forms extends CoreSingleLib{	

	function __construct($Path,$Params=null){

		parent::__construct($Path,$Params);	

		echo $this->JS("forms_events");	
		echo $this->CSS("style");							
	}	

	function GetAuthForm(){
		Oxs::G("BD")->Start();

		Oxs::G("js.cookie")->GetObject();

		$this->JS();

		Oxs::I("field");

		echo "<div style='margin:auto;text-align:center;width:200px;'><br><br><br>";
			echo field::Text("login",  NULL,array(  "auto_clear"=>Oxs::G("languagemanager")->T("login") , "class" => "form-control" , "style" => "margin-bottom:10px;"));
			echo field::Text("password",NULL,array( "type" => "password" , "auto_clear"=>Oxs::G("languagemanager")->T("password") , "class" => "form-control"));
			echo field::Button("enter",Oxs::G("languagemanager")->T("enter_button"), array("style"=>"margin-top:10px; width:100px;" , "class" => "btn btn-success"));
		echo "</div>";

		?>
		<script type="text/javascript">
			jQuery(function(){
				jQuery("[name=login]").focus();
			});
		</script>
		<?php

		return Oxs::G("BD")->GetEnd();
	}
}

?>