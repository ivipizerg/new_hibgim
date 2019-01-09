<?php

	function content_modul($Param=NULL){			

		//	Подключаем основной обект управления блоками
		Oxs::GetLib("js.loader")->GetObject("datablocks_manager");	

		//	Строим массив параметров
		/////////////////////////////////////////////		
		$A = "{"; foreach ($_GET as $key => $value) $A .= $key.":\"".$value."\","; $A = trim($A,","); $A .= "}";

		//	Майн актион расчитываеться в head
    	$MainAction = Oxs::G("storage")->get("MainAction");
    	
		?>

		<div class=container_for_load_content></div>

		<?php

		//	Записываем точку старта в историю
		?>
		<script type="text/javascript">				
				jQuery( function(){						
					datablocks_manager.ExecBlock("<?php echo $MainAction;?>",<?php echo $A;?>,"admin/<?php echo $MainAction.".html";?>" , true);
				});
		</script>
		<?php	
	}
