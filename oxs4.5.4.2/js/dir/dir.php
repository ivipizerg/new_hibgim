<?php

if(!defined("OXS_PROTECT"))die("Wrong start point");

class js_dir extends SingleLib{	

	function __construct($Path,$params=null){
		parent::__construct($Path,$params);			
	}

	
	function GetObject($Name="js_dir"){
		
		$D=Oxs::GetLib("dom");
		$D->jQuery();
		$D->LoadJsOnce(OXS_PATH."/js/dir/dir.js");
		
		Oxs::GetLib("js.protector_ajax")->GetObject("dir_ajax");

		$Pr=Oxs::LoadLib("protector");
		$Pr->SetToken("js_protector_dir");
		?>
			
			<script>
				jQuery(function(){
					if(typeof <?php echo $Name;?> == "undefined"){
						<?php echo $Name;?>=new oxs_js_dir_init("js_protector_dir","<?php echo $Pr->GetToken("js_protector_dir");?>" ,"<?php echo Oxs::GetBack(); ?>" , "<?php echo Oxs::GetRoot(); ?>" , "<?php echo $this->Path; ?>");	

						<?php echo $Name.".SetPost_max_size(\"".ini_get("post_max_size")."\")"; ?>;
						<?php echo $Name.".SetUpload_max_filesize(\"".ini_get("upload_max_filesize")."\")"; ?>;
						<?php echo $Name.".SetMax_file_uploads(\"".ini_get("max_file_uploads")."\")"; ?>;
					}				
				});
			</script>
		<?php
	}
}