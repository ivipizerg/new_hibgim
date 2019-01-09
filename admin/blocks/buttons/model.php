<?php

	if(!defined("OXS_PROTECT"))die("protect");

	class buttons_model extends BlocksSingleLib{
		function __construct($Path,$params=null){
			parent::__construct($Path,$params);
		}

		function GetButtonsForBlock($Block){
			$Tree=Oxs::L("DBTree",array("db" => Oxs::G("DBLIB.IDE")->DB() , "table" => "#__buttons"));

			function Foo($DB,$Params){
				//	Мы берем уже сформированный запрос и отсекаем в нем все не нужное по параметрам
				$DB->SetQ("SELECT * FROM (".$DB->GetQ().") as T WHERE T.`displayin` = 'oxs:sql' and `status` = '1'" , $Params["Block"]);					
				return $DB;				
			}

			$UL=$Tree->GetTreeEx( array( "Foo" => Foo , "Params" => Array("Block" => $Block)) );

			return $UL;
		}

	}


?>
