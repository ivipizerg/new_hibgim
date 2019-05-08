<?php

	if(!defined("OXS_PROTECT"))die("protect");

     class files_manager_ajax extends SingleLib{

		function __construct($Path){
            parent::__construct($Path);
        }

        function AjaxExec($Param){ 
        	if($Param["action"]=="formLoadFiles"){
        		echo Oxs::G("files_manager:form")->formLoadFiles($Param["dir"],$Param["param"]);
        	}
        }
     }
