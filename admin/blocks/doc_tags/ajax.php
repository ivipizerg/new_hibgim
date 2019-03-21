<?php

	if(!defined("OXS_PROTECT"))die("protect");

     class doc_tags_ajax extends SingleLib{

		function __construct($Path){
            parent::__construct($Path);
        }

        function AjaxExec($Param){          	
        	
        	if($Param["action"]=="search"){
        		//	базовый запрос
				Oxs::G("DBLIB.IDE")->DB()->SetQ( "SELECT * FROM `oxs:sql` WHERE `id` != '1' ORDER BY `position` ASC " , $Param["settings"]["table_name"]  );			
					
				$Sql = Oxs::L("sqlsearch");
				
				//	Добавляем поиск
				$DB = $Sql->search( Oxs::G("DBLIB.IDE")->DB(),trim($Param["value"]), Oxs::G("JSON.IDE")->JSON()->GetFromJSON( Oxs::G("crypto.base64")->D($Param["settings"]["search_fields"]) )) ;		

				//	Дописываем лимиты
				$DB->AddQ(" LIMIT 0,20 ");		

				$R = $DB->Exec();   	

				if( $R == FALSE ){
					echo Oxs::G("languagemanager")->T($Param["settings"]["no_tag_search_result"]);
					return ;
				}     

		        for($i=0;$i<count($R);$i++){
		        	echo "<div class=\"oxs_doc_tags_fieldsTyps_add_list_items oxs_doc_tags_fieldsTyps_add_list_item_".$Param["settings"]["prefix"]."\" value=".$R[$i]["id"].">".$R[$i][$Param["settings"]["field_name"]]."</div>";
		        }                
        	}  

        	if($Param["action"]=="language"){
        		echo Oxs::G("languagemanager")->T($Param["code"]);
        	}              
        }
     }
