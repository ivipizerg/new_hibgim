
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:remove");

	class docs_remove extends default_remove{		

		function __construct($Path){	
			parent::__construct($Path);			
		}			
		
		function AjaxExec($Param){				

			//	удаление файла из блока
			//	Первым делом проверим ринадлежит ли файл нашему блоку
			$R1 = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__docs` WHERE `id` = 'oxs:id'" , $Param["id"] );

			//	Перебираем все файлы что указаны в записи и ищем совпадение если нет файл не наш
			if(empty($R1[0]["files"])) return ;

			$R = Oxs::G("JSON.IDE")->JSON()->D($R1[0]["files"]);

			for($i=0;$i<count($R);$i++){
				//	Файл найден он действительно наш - удаляем
				//echo $R[$i]->name."|".$Param["file"];
				if($R[$i]->name == $Param["file"]){
					
					Oxs::G("file")->Delete("files/".$R[$i]->name);

					//	Пишем изменения в базу данных
					/////////////////////////////////////////////////////////////
					//	Удаляем обьект из массива
					array_splice($R,$i,1);
					//	Преобразуем обьект в JSON
					$Str = Oxs::G("JSON.IDE")->JSON()->E($R);
					//	пишем в базу
					Oxs::G("DBLIB.IDE")->DB()->Update("#__docs", array( "sql:files" => $Str ) , " WHERE `id` = 'oxs:id'" , $Param["id"] );
					//////////////////////////////////////////////////////////////

					$this->setAjaxCode(1);			
					return ;
				}
			}

			$this->setAjaxCode(-1);			
		}

		function Exec(){
			
			if($this->getIds()!=null){
				for($i=0;$i<count($this->getIds());$i++){	
					
					//	ПОлучаем данные выбранного обьекта
					$Current = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__oxs:sql` WHERE `id` = 'oxs:id'" , Oxs::G("datablocks_manager")->RealCurrentBlockName , $this->getIds()[$i])[0];

					//	Удаляем файлы
					$Files =  Oxs::G("JSON.IDE")->json()->D($Current["files"]);					

					if(!empty($Files))
					for($j=0;$j<count($Files);$j++){
						echo $Files[$j]->name;
						if(Oxs::G("file")->isExist("files/".$Files[$j]->name))
							Oxs::G("file")->Delete("files/".$Files[$j]->name);
					}
					
				}
			}

			parent::Exec();
		}	
	}