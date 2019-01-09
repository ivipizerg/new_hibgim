<?php

	if(!defined("OXS_PROTECT"))die("protect");

	class category extends SingleLib{
		

		function __construct($Path){
			parent::__construct($Path);
		}

		function Show($id_category){

			//	Получем категорию
			$Category = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__content_cat` WHERE `id` = 'oxs:id'" , $id_category)[0];

			if(!$Category) return "Категоряи пуста";
			
			echo "<H1>".$Category["name"]."</H1>";

			//	Получаем содержимое категории
			$Count = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__content_goods` WHERE `cat_id` = 'oxs:id' ORDER BY `position` DESC " , $Category["id"]);

			function Foo_category($i,$Data,$_this){
				if($i == $_GET["page"]){
					return "<span style=\"margin-left:10px;  display:inline-block;	height:22px; text-align: center; border-top:3px solid red; padding-top:5px;\" class=oxs_navigation_item ><a style='font-size:12pt;' href=category.html?p=".$_GET["p"]."&page=".$i.">".$i."</a></span>";		
				}else{
					return "<span style=\"margin-left:10px; display:inline-block; height:22px; text-align: center; padding-top:5px;\" class=oxs_navigation_item ><a style='font-size:12pt;' href=category.html?p=".$_GET["p"]."&page=".$i.">".$i."</a></span>";
				}				 
			}

			if(empty($_GET["page"]))$_GET["page"]=1;

			$Nav = Oxs::L("navigation",array( "all" => count($Count) ,  "interval" => 5 , "count" => 9 , "page" => $_GET["page"] , "Foo" => Foo_category));

			$Products = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__content_goods` WHERE `cat_id` = 'oxs:id' ORDER BY `position` DESC " . $Nav->SqlLimits(true) , $Category["id"]);

			if(!empty($Category["description"])){
					?>

					<div class=z_block >					
						<div class=z_block_body>
							<div class=z_block_text>		
								<?php
									echo $Category["description"];
								?>	
							</div>
						</div>
					</div><br>				

					<?php
			}

			if($Count){
				
				$Table = Oxs::L("table",array( "attr"=> "width=100%" , "count" => 3));		

				for($i=0;$i<count($Products);$i++){

					//	Поулчаем оснвоную картинку
					$img = explode(",",$Products[$i]["img"])[0];	
											
						?>									
									<?php

									Oxs::G("BD")->Start();	

									if(!empty($Products[$i]["text"])){
										?>
											<a href=products.html?p=<?php echo $Products[$i]["id"];?>><div class=z_block_name><?php echo $Products[$i]["name"];?></div>
										<?php
									}else{
										?>
											<div class=z_block_name><?php echo $Products[$i]["name"];?></div>
										<?php
									}
									?>	
									
									<div class="z_block_image">										
												<img width=170 class=z_block_image_show src="admin/files/<?php echo $img;?>">								
									</div>	
						<?php

						$Table->Add( Oxs::G("BD")->GetEnd()," valign=top");									
				}			

				return "<div class=z_block ><div class=z_block_body><div class=z_block_text>".$Table->Show(true)."</div></div></div><hr class=z_hr><div class=layout style='width: 800px;margin: 0px auto 0px auto; text-align:center;'>".$Nav->Show()."</div>";

			}			
		}
	}

?>
