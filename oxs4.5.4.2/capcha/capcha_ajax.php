<?php

	include("../oxs_fw.php");
	$Oxs=new oxs_fw("../");

	$P=$Oxs->LoadLib("protector");	
	$P->CheckToken("oxs_capcha_protector",$_POST["protect"],$_POST["sSID"]);

	$D=$Oxs->LoadLib("capcha");
	echo $D->GetCapchaBase64();	

?>