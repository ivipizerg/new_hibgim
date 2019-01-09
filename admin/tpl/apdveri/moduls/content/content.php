<?php

	function content_modul($Param=NULL){		
		
		$MainAction = Oxs::G("storage")->get("MainAction");

		if($MainAction=="mainPaige"){
			$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__main_page` ")[0];

			?>
			<div class=z_block >
					<h1>О нас</h1>		
					<div class=z_block_body >
						<div class=z_block_text>							
							<?php echo $R["content"];?>											
						</div>
					</div>
				</div>
			<?php
			
		}else if($MainAction=="category"){
			echo Oxs::G("category")->Show($_GET["p"]);
		}else if($MainAction=="products"){
			echo Oxs::G("products")->Show($_GET["p"]);
		}else{
			echo Oxs::G("category")->NotFound($_GET["p"]);
		}	
	}

 
