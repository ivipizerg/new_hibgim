<?php

	function banerBox_modul($Param=NULL){		

		$MainAction = Oxs::G("storage")->get("MainAction");
		if($MainAction!="mainPaige") return ;


		?>

			<div class=z_block>
					<h1>Размещение рекламмы</h1>		
					<div class=z_block_body>
						<div class=z_block_text style="padding: 0px;">							
								<!--<div class=z_reklamma>Здесь могла бы быть ваша реклама</div>-->	
								<div ><img style="margin-left:0px" src="admin/tpl/apdveri/img/Без-имени-1.gif" ></div>												
						</div>
					</div>
			</div>	



				<div class=z_block>
					<h1>Как нас найти?</h1>		
					<div class=z_block_body>
						<div class=z_block_text style="padding: 0px;">
							<div class=map_image_box>
								<img class=map_image src="admin/tpl/apdveri/img/map2.jpg">
							</div>							
						</div>
					</div>
				</div>

		<?php
		
	}

?>
