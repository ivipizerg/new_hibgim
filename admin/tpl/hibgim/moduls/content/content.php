<?php

	function content_modul($Param=NULL){

		//	Получаем URL
		$URL = str_replace(Oxs::GetRoot(),"",$_SERVER['REQUEST_URI']);
		$URL = str_replace("/insert_file.php","",$URL);
		$URL = trim($URL,"/");

		$URL = explode("/",$URL);

		if(empty($URL[0])){
			$URL[0] = "main";
		}

		switch($URL[0]){
			case "main":
				echo "<table  border=0><tr><td valign=top>";
				echo "<h2 style='margin-left:10px;'>Новости гимназии</h2>";
				echo "<div class=main_wraper_left>".Oxs::G("front_news")->showNews("all",$URL[1])."</div>";
				echo "</td><td valign=top width=390>";
				echo "<h2 style=''>Важная информация</h2>";
				echo "<div class=main_wraper_right>".Oxs::G("front_news")->showNews("important",$URL[1])."</div>";
				echo "<h2 style=''>Мероприятия</h2>";
				echo "<div class=main_wraper_right>".Oxs::G("events")->showEvents("important",$URL[1])."</div>";
				echo "</td></tr></table>";
			break;
			case "news_details":
				echo Oxs::G("front_news")->showNewsDetails($URL[1]);
			break;

			default: echo "404";
		}

		echo "<div class=oxs_block></div>";
	}
