<?php
	if(!defined("OXS_PROTECT"))die("protect");

	class default_cancel extends BlocksSingleLib{		

		function __construct($Path){	
			parent::__construct($Path);			
		}	

		function Exec(& $Param=null){

			//	Получаем дейстиве по умолчанию
			$Info = Oxs::G("blocks:model")->GetAboutBlockByName(Oxs::G("datablocks_manager")->RealCurrentBlockName)[0];		

			//	Код 1 редирект на nextStep
			$this->SetAjaxCode(1);
			//	Куда переходить
			$this->SetAjaxData("nextStep",Oxs::G("datablocks_manager")->RealCurrentBlockName.":".$Info["defaultAction"]);
		}		
	}