<?php

	define("OXS_PROTECT",TRUE);

	class files_manager_thumb extends BlocksSingleLib{			

		function __construct($Path){
			parent::__construct($Path);
		}		

		//	Срщлает минизображение для указанног офайла
		//	возвращает путь к минизображению
		function make($FilePath){
			//	получаем настройки
			$thumbSetting = Oxs::G("img_settings:model")->get("thumb_params");
			$thumbSetting = explode("X",$thumbSetting);

			$Path = Oxs::G("url")->getPath($FilePath);
			$Name = Oxs::G("url")->GetName($FilePath);
			$Ext = Oxs::G("url")->GetExt($FilePath);			

			$M = Oxs::L("mimage");
			$M->setImage($FilePath);
			$M->ResizeImage($thumbSetting[0],$thumbSetting[1]);
			$M->Save($Path."/thumbs/".$Name.".".$Ext);
		}

		function get($FilePath){
			return ;
		}
	}

?>
 
