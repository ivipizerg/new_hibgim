<?php

	function navigation_modul($Param=NULL){		

		?>
				<div class=z_menu>
				<div class=z_menu_head>Навигация</div>
					<div class=z_menu_body>
						<div class=z_menu_text>	 						
								<?php	
										
									$Tree=Oxs::L("DBTree",array("db" => Oxs::G("DBLIB.IDE")->DB(), "table" => "#__content_cat"));									


									function Foo_1($DB,$Params){
										$DB->SetQ("SELECT * FROM (". $DB->GetQ().") AS T  WHERE `level` > '2' and `status` = '1'" );
										return $DB;
									}

									$Q = $Tree->GetTreeEx( array( "Foo" => Foo_1) );

									function Foo($Item){
										if($Item["type"] != "separator")
											return "<div ><a href=category.html?p=".$Item["id"].">".$Item["name"]."</a></div>";				
										else
											return "<div class=\"z_menu_close\"><table><tr><td><span class=\"z_menu_span_close\"></span></td><td>".$Item["name"]."</td></tr></table></div>";
									}

									echo $Tree->GetUl($Q , array( "Foo" => Foo , "ulstyle" => "main_menu"));	

								?>							
						</div>
					</div>
					</div>

					<script type="text/javascript">
						
						jQuery(".main_menu ul").each(function(E){
							if( jQuery(this).attr("data-level") >= 3 ) jQuery(this).hide();

							jQuery("html").on("click",".z_menu_close ",function(){
								jQuery(this).addClass("z_menu_open");
								jQuery(this).removeClass("z_menu_close");
								jQuery(this).next().show();	

								jQuery(this).find(".z_menu_span_close").addClass("z_menu_span_open");	
								jQuery(this).find(".z_menu_span_close").removeClass("z_menu_span_close");							
							});

							jQuery("html").on("click",".z_menu_open",function(){
								jQuery(this).addClass("z_menu_close");
								jQuery(this).removeClass("z_menu_open");
								
								jQuery(this).next().find("ul").hide();	
								jQuery(this).next().hide();			
								
								jQuery(this).find(".z_menu_span_open").addClass("z_menu_span_close");	
								jQuery(this).find(".z_menu_span_open").removeClass("z_menu_span_open");		

								jQuery(this).next().find(".z_menu_span_open").addClass("z_menu_span_close");	
								jQuery(this).next().find(".z_menu_span_open").removeClass("z_menu_span_open");							
							});
						});						

					</script>

		<?php
		
	}

?>
