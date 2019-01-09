<?php

	if(!defined("OXS_PROTECT"))die("protect");

    class buttons_ajax extends SingleLib{

		function __construct($Path){
            parent::__construct($Path);
        }

        function AjaxExec($Param){              	
          	switch($Param["action"]){
    			case "getfordisplayin" : echo (Oxs::G("blocks:model")->GetAboutBlockById($Param["id"])[0])["system_name"]; break;
                case "getforaction" : echo (Oxs::G("blocks:model")->GetAboutBlockById($Param["id"])[0])["system_name"]; break;
            }          
        }
    }
