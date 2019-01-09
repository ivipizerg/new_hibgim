<?php

	if(!defined("OXS_PROTECT"))die("protect");

	class show_form extends CoreSingleLib{			

		
		function __construct($_Path,$Params=null){
			parent::__construct($_Path,$Params);
			echo $this->CSS();
		}

		function ShowForm($Form){
			$this->SetAjaxCode(2);		
			$this->SetAjaxData("backWay",Oxs::G("datablocks_manager")->CurrentBlock);		
			$this->SetAjaxData("windowData",$Form);			
		}		
	}

?>
