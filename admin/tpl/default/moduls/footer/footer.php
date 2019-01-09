<?php

	function footer_modul(){	
		
		$Cfg=Oxs::GetLib("cfg");

		echo "<div class=footer >";				
		echo "OXANA - конструкор сайтов© Все права защищены. <div style='float:right; font-style: italic;'>Версия: ".$Cfg->Get("versionMAIN","admin/version.php")."";
		$Temp=$Cfg->Get("verisonLocal","admin/version.php");
		if(!empty($Temp))echo " Ветка: ";
		echo "".$Temp."";		

		echo " Верся OXS: ";
		echo "".$Cfg->Get("Version",OXS_PATH."/version.php")."";
		echo "<i> (".$Cfg->Get("Data",OXS_PATH."/version.php").")</i>";
 		
 		echo "</div></div>";	
	}

?>

