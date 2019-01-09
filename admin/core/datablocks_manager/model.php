<?php

	define("OXS_PROTECT",TRUE);

	class datablocks_manager_model extends CoreSingleLib{

		function __construct($Path){
			parent::__construct($Path);
		}

		function GetBlockInfo($block_id){
			return Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__blocks` WHERE `id` = 'oxs:id'" , $block_id );
		}

		//	Получаем системное имя дефалтного блока для юзера
		//	Если он выключен или не существует
		function GetDefaultBlock(){
			$Block_id = Oxs::G("usermanager")->CurrentUser->Get("default_block");			
			$Data_block = $this->GetBlockInfo($Block_id);	

			//	Если выключен
			if($Data_block[0]["status"]==0) return Oxs::G("cfg")->Get("default_block");
			//	Если не существует
			if(!Oxs::isExist($Data_block[0]["system_name"])) return Oxs::G("cfg")->Get("default_block"); 			
			
			return $Data_block[0]["system_name"];				
		}
	}

?>
