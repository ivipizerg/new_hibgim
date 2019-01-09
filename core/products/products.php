<?php

	if(!defined("OXS_PROTECT"))die("protect");

	class products extends SingleLib{		

		function __construct($Path){
			parent::__construct($Path);
		}

		function Show($id_product){
			//	Получем категорию
			$Products = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__content_goods` WHERE `id` = 'oxs:id' " , $id_product)[0];

			if(!$Products) return "Категоряи пуста";
			
			echo "<H1>".$Products["name"]."</H1>";			

		
			//	Поулчаем оснвоную картинку
			$img = explode(",",$Products["img"])[0];				

			Oxs::G("BD")->Start();

				?>

				<div class=z_block >					
					<div class=z_block_body>
						<div class=z_block_text>		
							<?php
								echo $Products["text"]
							?>	
						</div>
					</div>
				</div><br>

				<?php		


			for($i=0;$i<count($img);$i++){

			}	

			return Oxs::G("BD")->GetEnd();
		}
	}

?>
