<?php
		
	if(!defined("OXS_PROTECT"))die("protect");	

	class content_table_main_table_tools extends SingleLib{

		function __construct($Path,$Params=null){	
			parent::__construct($Path,$Params);								
		}

		//	берем столбец где есть списко id в формате json, и замняем его на занчения 
		//	из указаной таблицы данынми от записей с хранящимися id
		function loadContentByJSONId($Data,$field,$table,$foo,$foo_all=null){

			$c = count($Data);
			$uniquie_id;
			$t=0;
			for($i=0;$i<$c;$i++){
				if(empty($Data[$i][$field])) { continue; }	
				$Tmp = Oxs::G("JSON.IDE")->JSON()->GetFromJSON($Data[$i][$field]);				
				for($j=0;$j<count($Tmp);$j++){
					$uniquie_id[$t++] = $Tmp[$j];
				}				
				$uniquie_id = array_unique($uniquie_id);
				$uniquie_id=array_values($uniquie_id);	
				$t = count($uniquie_id);
			}			

			$tags = Oxs::G("DBLIB.IDE")->DB()->Exec( "SELECT * FROM `oxs:sql` WHERE `id` IN(".( implode($uniquie_id,",")).")" , $table);
			for($i=0;$i<count($tags);$i++){
				$tags_s[$tags[$i]["id"]] = $foo($tags[$i]);
			}			

			for($i=0;$i<$c;$i++){
				
				if(empty($Data[$i][$field])){ $Data[$i][$field] = $foo_all($Data[$i][$field]);	continue; }	
				$Tmp = Oxs::G("JSON.IDE")->JSON()->GetFromJSON($Data[$i][$field]);		
				$Data[$i][$field] = ""; 
				
				for($j=0;$j<count($Tmp);$j++){
					$Data[$i][$field] .= $tags_s[$Tmp[$j]];					
				}
				
				if($foo_all!=null)
					$Data[$i][$field] = $foo_all($Data[$i][$field]);		
			}

			return $Data;

		}
	}
