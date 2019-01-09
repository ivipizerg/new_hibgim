
<?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default.tree:fix_end");

	class buttons_fix_end extends default_tree_fix_end{
		
		function __construct($Path){	
			parent::__construct($Path);				
		}	

		function Exec(){
			//	Возьмем старого парента
			$oldPost = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__oxs:sql` WHERE `id` = 'oxs:id'" , $this->getP("block_name") , $this->getP("fixingId") )[0];

			$this->setD("pid",$oldPost["pid"]);

			$this->Msg("Все проверки выполнены, передаю управление дефалтному обработчику","MESSAGE");
			parent::Exec();
		}
		
	}