<?php
		
	if(!defined("OXS_PROTECT"))die("protect");	

	class fields_model extends SingleLib{

		function __construct($Path,$params=null){			
			parent::__construct($Path,$params);
		}
		
		function GetFieldsForBlock(){
			return Oxs::G("DBLIB.IDE")->DB()->Exec( "SELECT * FROM `#__fields` WHERE `block_name` = 'oxs:sql' and `status` = '1' ORDER BY `position` ASC " , Oxs::G("datablocks_manager")->RealCurrentBlockName );
		}

		function findType($Fields,$type){
			
			for($i=0;$i<count($Fields);$i++){
				if(!empty($Fields[$i]["type"] == $type )) return $Fields[$i];
			}
			
			return null;
		}

		function findSystemName($Fields,$name){
			
			for($i=0;$i<count($Fields);$i++){
				if(!empty($Fields[$i]["system_name"] == $name )) return $Fields[$i];
			}
			
			return null;
		}
	}