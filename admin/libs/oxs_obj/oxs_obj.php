<?php

	define("OXS_PROTECT",TRUE);

	class oxs_obj extends CoreSingleLib{

		function __construct($Path){
			parent::__construct($Path);			
		}

		function Init(){
			Oxs::G("js.loader")->GetObject("oxs_obj",null,"oxs_obj");	
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
