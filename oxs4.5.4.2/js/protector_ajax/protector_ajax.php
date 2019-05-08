<?php

if(!defined("OXS_PROTECT"))die("Wrong start point");

class js_protector_ajax extends SingleLib{

	function __construct($Path,$params=null){
		parent::__construct($Path,$params);
	}

	function GetObject($Name="js_protector_ajax"){
		
		$D=Oxs::GetLib("dom");
		$D->jQuery();		

		$D->LoadJsOnce(Oxs::getOxsPath()."/js/protector_ajax/protector_ajax.js");

		$Pr=Oxs::LoadLib("protector");
		$Pr->SetToken("js_protector_ajax");

		?>
			<script>
				jQuery(function(){
					if(typeof <?php echo $Name;?> == "undefined")
						<?php echo $Name;?>=new oxs_js_protector_ajax("js_protector_ajax","<?php echo $Pr->GetToken("js_protector_ajax");?>" ,  "<?php echo Oxs::GetRoot(); ?>");

				});
			</script>
		<?php
	}

}

?>
