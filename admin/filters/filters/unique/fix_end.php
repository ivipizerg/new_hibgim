<?php

	define("OXS_PROTECT",TRUE);

	Oxs::I("filters.unique:add_end");

	class filters_unique_fix_end extends filters_unique_add_end{
		
		function __construct($Path){
			parent::__construct($Path);
		}	

		function Exec($Command,& $Fields , & $Data){	
			
			$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__oxs:sql` WHERE `id` = 'oxs:id'" , Oxs::G("datablocks_manager")->RealCurrentBlockName , $Data["fixingId"])[0];

			if( $R[$Fields["system_name"]] == $Data[$Fields["system_name"]]) return 0;			

			parent::Exec($Command,$Fields , $Data);
		}

	}