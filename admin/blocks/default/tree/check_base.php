<?php
	if(!defined("OXS_PROTECT"))die("protect");	

	class default_tree_check_base extends BlocksSingleLib{	

		function __construct($Path){	
			parent::__construct($Path);			
		}			

		function Exec(& $Param=null){
			
			$Tree = Oxs::L("DBTree",array("table" => "#__".Oxs::G("datablocks_manager")->RealCurrentBlockName , "db" => Oxs::G("DBLIB.IDE")->DB()));

			$Tree->ChekForError();			

			$this->SetAjaxCode(-1);
			$this->SetAjaxText( 
				Oxs::G("message_window")->InfoUl( "DBTree.MESSAGE" ) .
				Oxs::G("message_window")->ErrorUl( "DBTree.FATAL_ERROR" ) . 
				Oxs::G("message_window")->GoodUl( "DBTree.GOOD" ) 				
			);			
		}
	}