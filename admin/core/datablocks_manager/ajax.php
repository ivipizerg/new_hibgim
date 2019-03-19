<?php

	if(!defined("OXS_PROTECT"))die("protect");

     class datablocks_manager_ajax extends SingleLib{

		function __construct($Path){
               parent::__construct($Path);
          }

          function AjaxExec($Param){             
            echo Oxs::G("datablocks_manager")->ExecAction($Param["block"],$Param["param"]);            
          }

     }
