<?php

	function menu_modul($Param=NULL){		

		Oxs::G("templatemanager:css")->loadCss("../JS/superfishmenu","superfish");
		Oxs::G("templatemanager:js")->loadJs("/JS/superfishmenu","superfish.min");
				
		//	Майн актион расчитываеться в head
    	$MainAction = Oxs::G("storage")->get("MainAction");			

		$Tree=Oxs::L("DBTree",array("db" => Oxs::G("DBLIB.IDE")->DB() , "table" => "#__blocks"));		
	

		$UL=$Tree->GetTreeEx( array( "Foo" => function($DB,$Params){
			$DB->SetQ("SELECT * FROM (".( $DB->GetQ() ).") AS T WHERE `status` = 1 and `id` != '1'");
			return $DB;
		} ) );

		if(!$UL){
			$this->Msg("menu: Не найден не один блок","FATAL_ERROR");
			return 0;
		}
		

		echo "<div class=menu_container>";
		echo $Tree->GetUl($UL,array(
			"ulstyle" => "main_menu sf-menu",
			"Foo" => function($Item){
				if($Item["section"] != 1)
					return "<div class=oxs_active_menu style='cursor:pointer;width:180px;text-align:left;' data-route=".$Item["system_name"].":display>".$Item["name"]."</div>";				
				else
					return "<div >".$Item["name"]." ⏷</div>";
			}
			));
		echo "</div>";
		
		Oxs::G("dom")->LoadJsOnce("admin/tpl/default/moduls/menu/menu.js");		
	}

