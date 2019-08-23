<?php

	function menu_modul(){	
		
		//	Выводим верхнее меню
		$Tree=Oxs::L("DBTree",array("db" => Oxs::G("DBLIB.IDE")->DB() , "table" => "#__menu"));			

		$UL=$Tree->GetChildsEX( 9 , array( "Foo" => function($DB,$Params){
			$DB->SetQ("SELECT * FROM (".( $DB->GetQ() ).") AS T WHERE `status` = 1 and `id` != '1'");
			return $DB;
		} ) );	

		Oxs::G("dom")->loadJsOnce("admin/tpl/default/JS/superfishmenu/superfish.min.js");
		//echo "<div class=oxs_header>Навигация</div>";
		echo $Tree->GetUl($UL,array(
			"ulstyle" => "left_menu sf-menu sf-vertical sf-arrows",
			"Foo" => function($Item){	
					return "<div style='display:inline-block;'>".$Item["name"]."</div>";
			}
		));	
	}

?>

