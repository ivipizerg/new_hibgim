<?php

	if(!defined("OXS_PROTECT"))die("protect");

    class search_ajax extends SingleLib{

		function __construct($Path){
            parent::__construct($Path);
        }

        function AjaxExec($Param){          	
          	switch($Param["action"]){
    			case "getform" : echo Oxs::G("search:form")->getFotm();
            }          
        }
    }
