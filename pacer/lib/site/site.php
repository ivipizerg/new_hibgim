<?php

	if(!defined("OXS_PROTECT"))die("protect");

	function separator($z = 5){
		for($i=0;$i<$z;$i++){
			echo "&nbsp;";
		}
	}

	function mb_ucfirst($string)
	{
	    $strlen = mb_strlen($string);
	    $firstChar = mb_substr($string, 0, 1);
	    $then = mb_substr($string, 1, $strlen - 1);
	    return mb_strtoupper($firstChar) . $then;
	}

	Oxs::G("default:add_end");

	class site extends default_add_end{

		function __construct($Path){
			parent::__construct($Path);
		}

		function ajaxExec($Param){

			Oxs::G("datablocks_manager")->Params=Array();
			Oxs::G("datablocks_manager")->RealCurrentBlockName = "news";

			$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__news_front` WHERE `added` = '0' ORDER BY `position` ASC");
			$Param["oxs_text_short"] = $R[0]["short_text"];
			$Param["oxs_text"] = $R[0]["text"];

			//	Есть ли мини изображение
			if(!empty($Param["oxs_mini_img"])){
				if(Oxs::G("file")->isExist("files1/".$Param["oxs_mini_img"])){
					echo "Файл мини изображения найден: ".separator(10)."<span style='color:green;'>".$Param["oxs_mini_img"]."</span><br>";
				}else{
					echo "<span style='color:red;'>".separator(10)."Файл мини изображения НЕ НАЙДЕН: files1/".$Param["oxs_mini_img"]."</span><br>";
				}

				//	Файл есть скопируем его в tmp
				$Name = Oxs::G("file")->GetFreeName($Param["oxs_mini_img"],"files/tmp/");
				Oxs::G("file")->copy( "files1/".$Param["oxs_mini_img"] , "files/tmp/".$Name );

				$H = hash_file('md5', Oxs::GetBack()."files/tmp/".$Name );
				$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__news` WHERE `img_hash` = 'oxs:sql'" , $H);

				if(  $R	 ){
					$this->setD( "mini_img" , $R[0]["mini_img"] );
					$Hash = $R[0]["img_hash"];
					$this->Msg("Файл иконки уже загружен, новый файл не будет скопирован","WARNING");
				}else{

					$Name1 = Oxs::G("file")->GetFreeName($Param["oxs_mini_img"],"files/news_img/");

					if(Oxs::G("file")->copy("files/tmp/".$Name,"files/news_img/".$Name1)){
						//	Отично скопировалось
						//	Делаем мини иконку
						Oxs::G("files_manager:thumb")->make("files/news_img/".$Name1);
						$this->setD( "mini_img" , $Name1 );
						$Hash = hash_file('md5', Oxs::GetBack()."/files/news_img/".$Name1 );

						Oxs::G("DBLIB.IDE")->DB()->Insert("#__img",array(
						 	"sql:file" => $Name1,
						 	"id:cat" => 6
						));

					}else{
						$this->Msg("Файл ".($this->getP("data-original-file"))." уже существует или неизвестная ошибка копирования","ERROR");
						$this->setAjaxCode(-1);
						return FALSE;
					}
				}
			}

			//	первым делом проверяем файлы
			for($i=0;$i<count($Param["img"]);$i++){
				//	наличие исходного файла
				if(Oxs::G("file")->isExist("files1/".$Param["img"][$i]["file"])){
					echo "Файл изображения найден: ".separator(10)."<span style='color:green;'>".$Param["img"][$i]["file"]."</span><br>";
				}else{
					echo "<span style='color:red;'>".separator(10)."Файл изображения НЕ НАЙДЕН: ".$Param["img"][$i]["file"]."</span><br>";
				}

				//	Файл есть скопируем его в tmp
				$Name = Oxs::G("file")->GetFreeName($Param["img"][$i]["file"],"files/tmp/");
				Oxs::G("file")->copy( "files1/".$Param["img"][$i]["file"] , "files/tmp/".$Name );

				//	Проверим вскопировалось ли
				if(Oxs::G("file")->isExist("files/tmp/".$Name)){
					echo "Файл изображения скопирвоан<br>";
				}else{
					echo "Файл изображения НЕ скопирвоан<br>";
				}

				//файл есть добавляем его
				Oxs::G("img:add_end")->ajaxExec(array(
					"action" => "save_files",
					"files" => $Name,
					"cat" => 2
				));

				if(Oxs::G("logger")->get("ERROR")){
					echo Oxs::G("message_window")->ErrorUl("ERROR").Oxs::G("message_window")->GoodUl("GOOD.img_add_end");
					return ;
				}else{

					//	Меняем тег изображения на секретынй тег
					//echo htmlspecialchars($Param["img"][$i]["oxs_img_tag"]);
					//echo htmlspecialchars($Param["oxs_text"]);
					$Param["oxs_text"] = str_replace( $Param["img"][$i]["oxs_img_tag"] , "<a href=\"insert_file.php/original/" . Oxs::G("img:add_end")->insertID . "\"><img width=400 class='oxs_image' src=\"insert_file.php/thumb/". Oxs::G("img:add_end")->insertID . "\"></a>" , $Param["oxs_text"]);

					echo Oxs::G("message_window")->Good(Oxs::G("languagemanager")->T("IMG_LOAD_SUCCESS"));
				}
			}


			$this->setD("data-file",$Name);
			$this->setD("name",mb_ucfirst(mb_strtolower($Param["oxs_name"])));
			$this->setD("create_data",$Param["oxs_create_data"]);
			$this->setD("update_data",$Param["oxs_update_data"]);
			$this->setD("count",$Param["oxs_count"]);
			$this->setD("cat",$Param["oxs_cat"]);
			$this->setD("like",0);
			$this->setD("fix_on_main",0);
			$this->setP("textarea_edit",$Param["oxs_text_short"]."<div style=\"page-break-after: always\"><span style=\"display: none;\">&nbsp;</span></div>".$Param["oxs_text"]);

			Oxs::G("news:add_end")->ExecBefore();
			Oxs::G("news:add_end")->Exec();

			//	Упдатим Хэш иконки
			Oxs::G("DBLIB.IDE")->DB()->Update("#__news",array(
					"sql:img_hash" => $Hash
			), " WHERE `id` ='oxs:id'" , Oxs::G("news:add_end")->CurrentID );

			if(Oxs::G("logger")->get("ERROR")){
				echo Oxs::G("message_window")->ErrorUl("ERROR");
				return ;
			}else{
				echo Oxs::G("message_window")->Good(Oxs::G("languagemanager")->T("GOOD"));

				//	Окей ноовсть добавлена
				//	обработаем её id и позиицию
				Oxs::G("DBLIB.IDE")->DB()->Update("#__news" , array(
					"id:id" => $Param["oxs_id"],
					"int:position" => $Param["oxs_position"]
				), "WHERE `id` = 'oxs:id'" , Oxs::G("news:add_end")->CurrentID);

				/*Oxs::G("DBLIB.IDE")->DB()->Update("#__news_front" , array(
					"int:added" =>1
				), "WHERE `id` = 'oxs:id'" , $Param["oxs_id"]);*/
			}

		}
	}

?>
