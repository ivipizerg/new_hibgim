<?php

	function tpl_head_modul($Param=NULL){			

		?>
			<table width=100%><tr><td width=170>
				<div style='display:inline-block;padding:15px 25px 0px 25px;'>
					<img width=130 src=admin/tpl/hibgim/img/logotip.png>
				</div>
			</td><td>
				<div style='display:inline-block;'>					
					<div style='display:inline-block;'>
						<b><br>Муниципальное бюджетное общеобразовательное учреждение "Хибинская гимназия"</b>
					</div>
					<br>
					<div style='display:inline-block;'>
						Россия, Мурманская область, г.Кировск, ул Олимпийская 57А<br>
						(81531)5-69-77, (81531)4-32-09, (81531)4-36-16, факс: (81531)5-59-27<br>
						 Приемная: info@hibgim.ru, технический специалист: admin@hibgim.ru<br>
					</div>

				</div>
				<div style='float: right;margin-top: -20px;margin-right: 20px;'>
					версия для слабовидящих<br>
					<div style='float:right;margin-top: 5px;'>						
						<a href=#><img class=oxs_mini_img style='margin-top:0px;' width=29 src=admin/tpl/hibgim/img/w512h5121380376664MetroUISearch.png></a>
						<a href=#><img class=oxs_mini_img width=25 src=admin/tpl/hibgim/img/1200px-VK.com-logo.svg.png></a>
						<a href=#><img class=oxs_mini_img  style='margin-top:0px;' width=32 src=admin/tpl/hibgim/img/mail_nowm.png></a>
						<a href=#><img class=oxs_mini_img  style='margin-top:-2px;' width=22 src=admin/tpl/hibgim/img/2530592213-1._znachek_android.jpg></a>
					</div>
				</div>
			</td></tr></table>
				<hr>
			<?php

			//	Выводим верхнее меню
			$Tree=Oxs::L("DBTree",array("db" => Oxs::G("DBLIB.IDE")->DB() , "table" => "#__menu"));			

			$UL=$Tree->GetChildsEX( 2 , array( "Foo" => function($DB,$Params){
				$DB->SetQ("SELECT * FROM (".( $DB->GetQ() ).") AS T WHERE `status` = 1 and `id` != '1'");
				return $DB;
			} ) );	
			
			echo $Tree->GetUl($UL,array(
				"ulstyle" => "top_menu",
				"Foo" => function($Item){	
						return "<div style='display:inline-block;'>".$Item["name"]."</div>";
				}
				));	

		echo "<hr style='margin-bottom:10px;'>";	
	}
