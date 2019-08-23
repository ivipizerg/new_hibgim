<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:display");

	class img_display extends default_display{		

		function __construct($Path,$Params=null){	
			parent::__construct($Path,$Params);				
		}

		function LoadMyJS(){			
			
			Oxs::G("oxs_obj")->G("default.js.display:navigation");	

			Oxs::G("oxs_obj")->G("img.js:add","display_img");

		}	

		function GetCount(){
			$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__img`");
			if($R)
			return count($R);
			else
			return 0;
		}

		function Exec(){

			//	Получаем изображения
			$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT `#__img`.* , `#__img_cat`.`path` AS `cat_path` , `#__img_cat`.`name` AS `cat_name`   FROM `#__img` , `#__img_cat`  WHERE `#__img`.`cat` = `#__img_cat`.`id` ORDER BY `id` DESC".($this->getLimits($this->getP("page"))));

			echo "<div style='padding: 10px;text-align:center; '>";
			if($R)
			for($i=0;$i<count($R);$i++){
				
				echo "<div class='oxs_img_display_item' data-id=\"".$R[$i]["id"]."\" style='margin:5px;display: inline-block; width:200px;height:200px;background-image: url(\"".$R[$i]["cat_path"]."/thumbs/".$R[$i]["file"]."\");background-size:cover;background-position: center center;color:white;text-align:left;padding:5px;'><div style='overflow: hidden;white-space: nowrap;text-overflow: ellipsis; width:150px; background-color: rgba(0, 0, 0, 0.8);'>".$R[$i]["id"]." , ".$R[$i]["cat_name"]."</div></div>";
			}

			echo "</div>";

			echo $this->ShowNavigation($_GET["page"]);			
		}

	}