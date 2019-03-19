<?php

	define("OXS_PROTECT",TRUE);

	class oxs_obj extends CoreSingleLib{

		function __construct($Path){
			parent::__construct($Path);			
		}

		function Init($_log=true){
			$_log = ($_log) ? 'true' : 'false';
			Oxs::G("js.loader")->GetObject("oxs_obj",array("notString:".$_log),"oxs_obj");	
		}

		function add($ObjName){
			?>

				<script type="text/javascript">
					$(function(){
						oxs_obj.add("<?php echo $ObjName; ?>");
					});
				</script>

			<?php	
		}

		function G($ObjName,$Param=null,$Name=null){
			$T = Oxs::G("js.loader")->GetObject($ObjName,$Param,$Name);
			?>

			<script type="text/javascript">
				$(function(){
					oxs_obj.add("<?php echo $T; ?>");
				});
			</script>

			<?php		
		}
	}

?>
