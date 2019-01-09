
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::G("default:position_copy_past");

	class default_tree_position_copy_past extends default_position_copy_past{
		
		function __construct($Path){	
			parent::__construct($Path);			
		}			

		//	Нам приходит id перемещаемого 
		//	и id после которого нужно вставиться
		function Exec(& $Param = NULL){		

			$P = 	array( 
				"currentId" => $Param["oxs_default_tree_js_position_current_id"] , 
				"changeId" => $Param["oxs_default_tree_js_position_change_id"] 
			);	
			
			if(Oxs::G("default:position")->ExecAfter($P)!=TRUE)
				Oxs::G("default:position")->Exec($P);

		}			
	}