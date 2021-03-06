<?php

	define("OXS_PROTECT",TRUE);

	class filters_unique_add_end extends CoreSingleLib{
		
		function __construct($Path){
			parent::__construct($Path);
		}

		function Exec($Command,& $Fields , & $Data){	

			$Key = Oxs::G("fields")->convertTypeFroBD($Fields);

			if($Key==null){
				$this->Msg( Oxs::G("languagemanager")->T("converTypeError" ),"ERROR.FILTER" );
				return ;
			}

			//	Проверяем на уникальность
			$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__oxs:sql` WHERE `oxs:sql` = 'oxs:".$Key."' " , Oxs::G("datablocks_manager")->RealCurrentBlockName , $Fields["system_name"] , $Data[$Fields["system_name"]] );	

			if($R){			
				$this->Msg(Oxs::G("languagemanager")->T("uniqueFailed" , $Fields["name"] ),"ERROR.FILTER");
			}
			
			return 0;
		}

	}