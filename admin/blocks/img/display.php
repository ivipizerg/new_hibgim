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
			$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__img` ORDER BY `id` DESC".($this->getLimits($this->getP("page"))));

			echo "<div style='padding: 10px;text-align:center; '>";
			if($R)
			for($i=0;$i<count($R);$i++){
				
				echo "<div class='oxs_img_display_item' data-id=\"".$R[$i]["id"]."\" style='margin:5px;display: inline-block; width:200px;height:200px;background-image: url(\"files/img/thumbs/".$R[$i]["file"]."\");background-size:cover;background-position: center center'></div>";
			}

			echo "</div>";

			echo $this->ShowNavigation($_GET["page"]);			
		}

	}