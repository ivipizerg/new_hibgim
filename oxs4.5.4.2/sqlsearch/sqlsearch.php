<?php

if(!defined("OXS_PROTECT"))die("Wrong start point");

class sqlsearch extends MultiLib{		

		function __construct($Path){
			parent::__construct($Path);
		}		

		//	Посик с уточнением, каждое последующее слово уточняет запрос
		function search($DB,$search=null,$fieldArray=null){				

				if($search==null) return $DB;	
				if($fieldArray==null) return $DB;			 

				$search =  preg_replace('/ {2,}/',' ',$search);
				$Search=explode (" ",$search);						
				
				for($i=0;$i<count($Search);$i++){
					$Search[$i]=trim($Search[$i]);	

						$DB->SetQ("SELECT * FROM (".$DB->GetQ().") AS  `oxsBuffer".$i."`");				
					
						$DB->AddQ(" WHERE (");
						for($p=0;$p<count($fieldArray);$p++){
							if($p<count($fieldArray)-1)
								$DB->AddQ( " LOWER(`oxsBuffer".($i)."`.oxs:sql) RLIKE LOWER('oxs:sql') OR" ,$fieldArray[$p],$Search[$i]);
							else
								$DB->AddQ( " LOWER(`oxsBuffer".($i)."`.oxs:sql) RLIKE LOWER('oxs:sql')" ,$fieldArray[$p],$Search[$i]);
						} 	
						$DB->AddQ(")");	
													
				}

				return $DB;			 
		}

}
?>
