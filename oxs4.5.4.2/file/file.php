<?php
	
	if(!defined("OXS_PROTECT"))die("Wrong start point");

	class file extends SingleLib{			

		function __construct($Path){
			parent::__construct($Path);			
		}	

		function IncludeFile($Path){
			Oxs::IF($Path);
		}

		function IfDirEmpty($Dir,$Flags="All"){
			switch($Flags){
				case "All":
					$Files = scandir(Oxs::GetBack().$Dir);
					if(count($Files)>2)return 0;
					else return 1;
				break;
			}			
		}

		//	Time - секунды
		function ClearOldFiles($Path,$Time=300){
			$t=0;
			if (is_dir(Oxs::GetBack().$Path)) {
				if ($dh = opendir(Oxs::GetBack().$Path)){
					
					while (($file = readdir($dh)) !== false) {					
						
						$time_sec=time();
						$time_file=filemtime(Oxs::GetBack().$Path . $file);
						$time=$time_sec-$time_file;

						if ($this->CheckFile($Path . $file)){
							if ($time>$Time){
								$this->Delete($Path . $file);
								$t++;
							}
						}else{
							$this->Msg("Файл ".$Path." не существует","WARNING");
						}
					}

				}else{
					$this->Msg("Не удалось открыть папку ".$Path." для очистки файлов","ERROR");
					return 0;
				}
			}else{
				$this->Msg("".$Path." - не являеться папкой","ERROR");
				return 0;
			}

			if($t!=0) return 1;
			else return 0;
		}

		function isExist($Path){
			return $this->CheckFile($Path);
		}

		function CheckFile($Path){
			if(is_file(Oxs::GetBack().$Path)){
				return true;
			}else{
				return false;
			}
		}		

		//	Проверить доступ к файлу
		function Access($FileName){		
						
			if(!@fopen(Oxs::GetBack().$FileName,"w+")){
				return false;
			}						

			return true;
		}
		
		function GetFreeName($Name,$Path){

			if(!is_dir(Oxs::GetBack().$Path)){
				$this->Msg("Не найдена указанная директория " . $Path,"ERROR");
			}	
			
			$FilesName=Oxs::GetLib("url")->GetName($Name);
			$FilesExt=Oxs::GetLib("url")->GetExt($Name);
			if(!empty($FilesExt))$FilesExt=".".$FilesExt;

			$Count=1;	
			$TmpName=$FilesName;	
			while(1){

				$Tmp=$FilesName.$FilesExt;
				//echo Oxs::GetBack().$Path.$Tmp;
				if(is_file(Oxs::GetBack().$Path.$Tmp)){
					$FilesName=$TmpName."(".$Count++.")";
				}else{
					break;
				}
			}
			
			return $Tmp;
		}
			

		function Copy($Name,$path,$Rewrite=false){		

			if(Oxs::G("serverinfo")->GetOS()==1){
				$Name = $Name;
				$path = Oxs::GetBack().$path;
			}else{
				$Tmp=stripos($Name,sys_get_temp_dir());			
				if( $Tmp!=0 or $Tmp===false ){
					$Name = Oxs::GetBack().$Name;
				}	

				$Tmp=stripos($path,sys_get_temp_dir());			
				if( $Tmp!=0 or $Tmp===false ){
					$path = Oxs::GetBack().$path;
				}
			}			

			if(empty($Name)){
				$this->Msg("Не передан файл","ERROR");			
				return 0;
			}

			if(!is_file($Name)){
				$this->Msg("Файл ".$Name." для копирования не найден","ERROR");			
				return 0;
			}

			if(is_dir($path)){
				$this->Msg("Файл ".$path." назначения не может быть дирректорией","ERROR");				
				return 0;
			}

			if(empty($path)){
				$this->Msg("Не передан путь для сохранения файла","ERROR");		
				return 0;
			}

			//	Перезаписать файл если он есть
			if($Rewrite===true){
				@unlink($path);
			}

			//echo $New_Name;

			//echo "[".$Name."]";
			//echo "[".$path."]";

			copy($Name,$path);
			if(is_file($path)){$this->Msg("Файл ".$Name." успешно скопирован под именем ".$path,"GOOD"); return 0;}
			else{$this->Msg("Файл ".$Name."  не скопирован ","ERROR"); return falce;}
		}

		function DeleteFile($Name){
			$this->Delete($Name);
		}

		function Delete($Name){			

			$Tmp=stripos($Name,sys_get_temp_dir());			
			if( $Tmp!=0 or $Tmp===false ){
				$Name = Oxs::GetBack().$Name;
			}	
		
			
			if(empty($Name)){
				$this->Msg("Не передан файл","ERROR");			
				return 0;
			}
			
			if(is_file($Name)){
				@unlink($Name);
				if(is_file($Name)){
					$this->Msg("Файл \"".$Name."\" не был удален!!!","ERROR");			
					return 0;
				}else{
					$this->Msg("Файл \"".$Name."\" дален успешно","GOOD");
					return 1;	
				}
			}else{
				$this->Msg("Файл \"".$Name."\" для удаления не найден","ERROR");			
				return 0;
			}			
		}

		//	Быстрая запись в файл с перезписью
		function Write($FileName,$Data=NULL,$Param=NULL){
			$this->Delete($FileName);
			$File = fopen(Oxs::GetBack().$FileName,"w");
			fwrite($File,"%s",$Data);
			fclose($File);
		}

		function Read($FileName){			
			$File = fopen(Oxs::GetBack().$FileName,"r");
			$Ret = fread($File,filesize(Oxs::GetBack().$FileName));
			fclose($File);
			return $Ret;
		}
	}
		
?>