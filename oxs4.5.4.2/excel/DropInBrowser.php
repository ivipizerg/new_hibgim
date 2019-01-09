<?php
	
	session_start();	

	include("../oxs_fw.php");	
	Oxs::SetRoot($_SESSION["root"]);
	Oxs::Init("oxs/");	

	//	Защита
	$P = Oxs::LoadLib("protector");
	$P->CheckToken( "excel_drop_in_browser" , $_SESSION["token"]);

	Oxs::LoadLib("excel");

	$Excel = unserialize($_SESSION["obj"]);

	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition:attachment;filename="'.$Excel->GetNameToDrop().'"');
	$objWriter = new PHPExcel_Writer_Excel2007($Excel->GetPhpExcel());
	$objWriter->save('php://output');	

	unset($_SESSION["obj"]);
	unset($_SESSION["root"]);	
	unset($_SESSION["token"]);

?>