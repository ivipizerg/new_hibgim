<?php

	function head_design_modul($Param=NULL){	

		
		?>
			<div class=z_head>					
					
					<div class=z_head_1>
						<div style="width:1000px;  margin:0px auto 0px auto; padding-top:15px;padding-left:40px;">
							
							<table width="100%"><tr><td>
								<img src=admin/tpl/apdveri/img/phone.png width=50 align=left  style="margin-top:-10px;">
								<div style="font-size:14pt; margin-right:20px;padding-top:0px;margin-left:60px;margin-top:-4px;">+7(911)342-88-38<br>+7(911)342-88-37</div>
							</td><td>

								<img src=admin/tpl/apdveri/img/home.png width=50 align=left style="margin-top:-10px;">
								<div style="font-size:12pt;margin-top: -5px;margin-left: 60px;">Мурманская область<br>г. Апатиты, Нечаева 5</div>
							
							</td><td>

							<img src=admin/tpl/apdveri/img/clock.png width=50  align=left style="margin-top:-10px;">
							<div style="font-size:12pt;margin-top: -5px;margin-left: 60px;">Пн-Пт с 11 до 18 <br>Сб-Вс с 12 до 17</div>	


							</td><td>

							<a href=https://vk.com/apdveri target="_blank"><img src=admin/tpl/apdveri/img/mail.png width=50  align=left style="margin-top:-10px;">	</a>													
							
							</td></tr></table>
						
						</div>
					</div>
					
					<div class=z_head_left></div>					
					<div class=z_head_right></div>
					<div class=z_head_logo style='padding-top:20px;padding-left: 530px;color: white;font-weight: bold;font-size: 12pt;'>	
									<img style="position: absolute;margin-top: 10px;" src=admin/tpl/apdveri/img/worker.png width=130><img style="position: absolute; margin-top:-10px; margin-left: 90px; width: 210px; height: 90px;" src=admin/tpl/apdveri/img/future.png ><img style="position: absolute; margin-top:80px; margin-left: 115px; width: 230px; height: 90px;" src=admin/tpl/apdveri/img/VKPHONE.png >
					</div>

					<div class=z_head_red>	
						<div style="width:1000px;  margin:0px auto 0px auto;  padding-left:0px; text-align:center; color:white; font-size:12pt; margin-top:6px;margin-left: -22px;">
						</div>						
					</div>	
			</div>

			

			<script type="text/javascript">
					
				//	Выравниваем лого по середине
		 		///////////////////////////////////////////////////////
		 		$(window).resize(function(){
		 			var z_Width_1=$("body").width();
			 		z_Width_1=(z_Width_1-1000)/2;
			 		z_Width_1+=100;
			 		$(".z_head_logo").css("margin-left",z_Width_1+"px");
			 	
		 		});
		 		$(window).resize(); 		

			</script>

		<?php
		
	}

?>
