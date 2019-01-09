<?php

	if(!defined("OXS_PROTECT"))die("Wrong start point");

	class js_ajaxexec extends SingleLib{

		function __construct($Path,$params=null){
			parent::__construct($Path,$params);
		}

		function GetObject( $Name="ajexec", $Param=NULL ){	
			
			//	Обрабатываем входящие параметры
			////////////////////////////////////////////////////////////
			if($Param["log"]=="off"){
				$WinObj="";				
			}
			else{ 
				$WW = Rand();
				$WinObj = "winobj_" . $WW;
				Oxs::GetLib("js.window")->GetObject($WinObj);
				Oxs::G("logger")->Css();

				?>

					<script type="text/javascript">							
						jQuery(function(){

							if(typeof log_window_bar == "undefined"){
								log_window_bar = new oxs_js_window_window_bar("false");									
							}	

							<?php echo "winobj_" . $WW;?>.UserResize = function(Wi){					
								//	Мальца подпарвлям ширину оконца					
								Wi.w.width(document.documentElement.clientWidth);						
							}

							<?php echo $WinObj;?>.setWindowBar(log_window_bar);
							
							<?php echo $WinObj;?>.set("<div class=oxs_debug_window><div class=id_window_" + ( <?php echo $WinObj;?>.uiid ) + ">Ожидаем аякс запросы...<hr></div><div class='oxs_oxs_debug_window_button <?php echo $WinObj;?>_fold_button'>__</div></div>");

							<?php echo $WinObj;?>.stick("left","bottom");
							<?php echo $WinObj;?>.static();							
							<?php echo $WinObj;?>.addClass("<?php echo $Name;?>");
							<?php echo $WinObj;?>.setName("<?php echo "AJAX ($Name)"; ?>");
							<?php echo $WinObj;?>.folding(".<?php echo $WinObj;?>_fold_button");
							<?php echo $WinObj;?>.fold();
							log_window_bar.Window.stick("right","top");
							

						});
					</script>

				<?php

			}
			///////////////////////////////////////////////////////////	

			Oxs::G("js.protector_ajax")->GetObject("protector_ajax_".$Name);
			
			//	start_code - некий код который выполняеться каждый раз при запросах
			//	Например инициализация базы данных или еще что то 
			Oxs::G("js.loader")->GetObject("js.ajaxexec",
				array(  $this->Path ,  Oxs::GetPaths() , $Param["start_code"] , $WinObj , "protector_ajax_".$Name  )
			,$Name);
		}

	}
?>
