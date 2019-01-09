<?php			
		
	session_start();

	include("../../oxs_fw.php");
	Oxs::SetRoot($_POST["oxs_root"]);
	Oxs::Init($_POST["my_path"]);

	$Pr=Oxs::LoadLib("protector");	
	$Pr->CheckToken();

	//	Получить список файлов директории
	function GetDir($Path){

		if(!is_dir($Path)){echo "{oxs_error}";exit();}

		if ($dir = opendir($Path))  {
		     while (false !== ($file = readdir($dir))) {
		         if ($file == "." || $file == ".." || (is_dir($Path."/".$file))) continue;
		          $files[] = $file;
		          $i++;
		     }
		     closedir($dir);
		}

		for($i=0;$i<count($files);$i++){
			$Temp=$Temp.$files[$i].",";
		}

		echo trim($Temp,",");
	}

	//	Проверить директорию на запись
	function CheckWritable($Path){

		if(!is_dir($Path)){
			echo "{oxs_error}";
			exit();
		}

		if(is_writable($Path)) echo "1";
		else echo "0";
	}


	function SaveFile($Path){

		if(!EMPTY($_FILES["file"])){

			//echo "Проверяю папку по пути: ".$Path;
			$New_Name=Oxs::GetLib("file")->GetFreeName($_FILES["file"]["name"],$Path);

			//echo "Копирую из : ".$_FILES["file"]["tmp_name"]." в ". $Path.$New_Name;
			Oxs::GetLib("file")->Copy($_FILES["file"]["tmp_name"],$Path.$New_Name);

			//echo "Удаляю из : ".$_FILES["file"]["tmp_name"];
			Oxs::GetLib("file")->Delete($_FILES["file"]["tmp_name"]);
			
			echo $New_Name;

			//Oxs::ShowErrors();
		}
	}

	function IfFileExist($Path){
		if(file_exists($Path)){
			echo "true";
		}else{
			echo "false";
		}
	}


	//	обработка параметров
	////////////////////////////////////////////////
	try{
		
		if($_POST["act"]=="dir"){
			GetDir("../../".$_POST["back"].$_POST["path"]);
		}

		if($_POST["act"]=="chekdir"){
			CheckWritable("../../".$_POST["back"].$_POST["path"]);
		}

		if($_POST["act"]=="save"){
			SaveFile($_POST["path"]);
		}

		if($_POST["act"]=="fileexist"){
			IfFileExist(Oxs::GetBack().$_POST["path"]);
		}

	}catch(Throwable $e){
		echo "{oxs_error}";
	}
	


?>
