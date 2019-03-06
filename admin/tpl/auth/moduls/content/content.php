<?php

	function content_modul($Param=NULL){	

		if(Oxs::G("templatemanager")->mode=="admin"){
			?>
				<div class=container_for_load_content></div>

				<script type="text/javascript">
					jQuery(function(){				
						
						oxs_history.GoTo(function(){	
							
							aj_auth.Exec("autentificator:ajax",{ action: "getform" },function(T){								
								jQuery(".container_for_load_content").html(T.Msg);
							});

						},"admin/",true);	
						
					});	
					
				</script>
				
			<?php
		}

		if(Oxs::G("templatemanager")->mode=="front"){

			//	В режиме фронта выводим собщение 
			echo "<div style='width:310px;height:290px;position:absolute; top:0px; right:50px; background:url(admin/tpl/auth/img/remont1.jpg) no-repeat;'></div>";
			echo "<div style='width:550px;height:50px;margin:auto;margin-top:100px;'>".(Oxs::G("cfg")->get("enable_site_text"))."</div>";

			?>
				<div class=container_for_load_content></div>

				<script type="text/javascript">
					jQuery(function(){				
						
						oxs_history.GoTo(function(){	
							
							aj_auth.Exec("autentificator:ajax",{ action: "getform" },function(T){
								jQuery(".container_for_load_content").html(T.Msg);
							});

						},"",true);	
						
					});	
					
				</script>
				
			<?php
		}

		
	}
