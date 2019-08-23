<?php

	if(!defined("OXS_PROTECT"))die("protect");

	class front_news extends SingleLib{

		private $Tpl;

		function __construct($_Path,$Params=null){
			parent::__construct($Path,$Params);
		}

		function showNewsDetails($ID){

			$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT `#__news`.*, `#__news_cat`.`name` AS `cat_name` FROM `#__news` , `#__news_cat`  WHERE `#__news`.`status` = '1' and `#__news`.`id` = 'oxs:id' and ( `#__news`.`cat` = `#__news_cat`.`id` ) " , $ID);
			$r = $R[0];

			if(!$R){
				echo "404";
				return ;
			}

				$T.= "<div class=oxs_news_box>";
				$T.= "".$Img."<a href=news_details/".$r["id"]."><div class=oxs_news_name><h3>".$r["name"]."</h3></div></a>";

				$C = Oxs::L("calendar",$r["create_data"]);

				if($type!="important") $T.= "<div class=oxs_news_create_data>".$C->GetDay()." ".$C->GetMountName(true)." ".$C->GetYear()." "." </div><div class='oxs_news_count'>&nbsp;|&nbsp;".$r["count"]." просмотров</div>&nbsp;|&nbsp;<div class='oxs_news_cat'>".$r["cat_name"]."</div>&nbsp;|&nbsp;<div class='oxs_news_like'>".$r["like"]." Мне нравится</div>";

				$r["text"] =  str_replace("<div style=\"page-break-after: always\"><span style=\"display: none;\">&nbsp;</span></div>","",$r["text"]);
				$T.= "".$r["text"];
				$T.= "</div>";

				return $T;
		}

		function showNews($type="all",$page=1){

			switch($type){
				case "important":
					$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT `#__news`.*, `#__news_cat`.`name` AS `cat_name` FROM `#__news` , `#__news_cat`  WHERE `#__news`.`status` = '1' and `#__news`.`cat` = 6 and ( `#__news`.`cat` = `#__news_cat`.`id` ) ORDER BY `#__news`.`position` DESC LIMIT 0,4");
				break;
				default :
					$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT `#__news`.*, `#__news_cat`.`name` AS `cat_name` FROM `#__news` , `#__news_cat`  WHERE `#__news`.`status` = '1' and `#__news`.`cat` != 6 and ( `#__news`.`cat` = `#__news_cat`.`id` ) ORDER BY `#__news`.`position` DESC LIMIT 0,7");
			}

			if(!$R) return "Нет новостей";

			$T = "";

			foreach($R as $r){

				if(!empty($r["mini_img"]))
					$Img ="<div class=oxs_mini_img style='width:90px;height:90px; margin-right:10px;margin-top:5px; background:url(\"files/news_img/thumbs/". $r["mini_img"] ."\") no-repeat; background-size:contain; background-position: top center;'></div>";
				else
					$Img= "";

				$T.= "<div class=oxs_news_box>";
				$T.= "<table><tr><td valign=top>".$Img."</td><td valign=top><a href=news_details/".$r["id"]."><div class=oxs_news_name><h3>".$r["name"]."</h3></a>";

				$C = Oxs::L("calendar",$r["create_data"]);

				if($type!="important") $T.= "<div class=oxs_news_create_data>".$C->GetDay()." ".$C->GetMountName(true)." ".$C->GetYear()." "." </div><div class='oxs_news_count'>&nbsp;|&nbsp;".$r["count"]." просмотров</div>&nbsp;|&nbsp;<div class='oxs_news_cat'>".$r["cat_name"]."</div>&nbsp;|&nbsp;<div class='oxs_news_like'>".$r["like"]." Мне нравится</div>";
				//else
					//$T.= "<div class=oxs_news_create_data>".$C->GetDay()." ".$C->GetMountName(true)." ".$C->GetYear()." "." </div>";

				$short =  explode("<div style=\"page-break-after: always\"><span style=\"display: none;\">&nbsp;</span></div>",$r["text"]);
				$short = $short[0];
				$T.= "".$short."</td></tr></table>";
				$T.= "</div>";
			}

			return $T;
		}
	}

?>
