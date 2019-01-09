<?php

if(!defined("OXS_PROTECT"))die("Wrong start point");

class DBTree extends MultiLib {

	private $DB;
	private $Table;	

	function __construct($Path){
		parent::__construct($Path);			
	}

	function Init($Param=NULL){
		$this->Table = $Param["table"];
		$this->DB = $Param["db"];
		return 1;
	}

	function ChekForError(){
		$Table=$this->Table;
		$this->Msg("Проверка таблицы ".$Table." на ошибки","MESSAGE");
		
		// Тест 1
		$Res=$this->DB->Exec("SELECT `id` FROM `oxs:sql` WHERE `left_key` >= `right_key`",$Table);
		if(!empty($Res)){
			for($i=0;$i<count($Res);$i++){
				$tmp=$tmp.$Res[$i]["id"];
			}
			$this->Msg("Тест 1 не пройден для таблицы ".$Table."(".$tmp.")","FATAL_ERROR");
		}else{
			$this->Msg("Тест 1 нет ошибок","GOOD");
		}

		//	Тест 2
		$Res=$this->DB->Exec("SELECT COUNT(`id`), MIN(`left_key`), MAX(`right_key`) FROM `oxs:sql`",$Table);
		$this->Msg("Тест 2 количество записей: ".$Res[0]["COUNT(`id`)"],"MESSAGE");
	
		//	Тест 3
		$Res=$this->DB->Exec("SELECT `id` FROM `oxs:sql` WHERE  MOD((`right_key` - `left_key`) , 2) = 0",$Table);
		if(!empty($Res)){
			for($i=0;$i<count($Res);$i++){
				$tmp=$tmp.$Res[$i]["id"];
			}
			$this->Msg("Тест 3 не пройден для таблицы ".$Table."(".$tmp.")","FATAL_ERROR");
		}else{
			$this->Msg("Тест 3 нет ошибок","GOOD");
		}

		//	Тест 4
		$Res=$this->DB->Exec("SELECT `id` FROM `oxs:sql` WHERE  MOD( (`left_key` - `level` + 2) , 2 ) = 1",$Table);
		if(!empty($Res)){
			for($i=0;$i<count($Res);$i++){
				$tmp=$tmp.$Res[$i]["id"];
			}
			$this->Msg("Тест 4 не пройден для таблицы ".$Table."(".$tmp.")","FATAL_ERROR");
		}else{
			$this->Msg("Тест 4 нет ошибок","GOOD");
		}

		//	Тест 5
		$Res=$this->DB->Exec("SELECT `t1`.`id`, COUNT(`t1`.`id`) AS `rep` , MAX(`t3`.`right_key`) AS `max_right` FROM `oxs:sql` AS `t1`, `oxs:sql` AS `t2`, `oxs:sql` AS `t3` WHERE `t1`.`left_key` <> `t2`.`left_key` AND `t1`.`left_key` <> `t2`.`right_key` AND `t1`.`right_key` <> `t2`.`left_key` AND `t1`.`right_key` <> `t2`.`right_key` GROUP BY `t1`.`id` HAVING `max_right` <> SQRT(4 * `rep` + 1) + 1",$Table,$Table,$Table);
		if(!empty($Res)){
			for($i=0;$i<count($Res);$i++){
				$tmp=$tmp.$Res[$i]["id"];
			}
			$this->Msg("Тест 5 не пройден для таблицы ".$Table."(".$tmp.")","FATAL_ERROR");
		}else{
			$this->Msg("Тест 5 нет ошибок","GOOD");
		}

		$this->Msg("Проверка завершена","MESSAGE");
	}

	/*private function ParceParam($Param){
		$Table=$this->Table;

		if(!empty($Param["WHERE"])){
			$this->DB->AddQ(" WHERE ".$Param["WHERE"]);
		}

		if(!empty($Param["ORDER BY"])){
			$this->DB->AddQ(" ORDER BY ".$Param["ORDER BY"]);
		}else{
			$this->DB->AddQ(" ORDER BY `".$Table."`.`left_key`");
		}

		if(!empty($Param["LIMIT"])){
			$this->DB->AddQ(" LIMIT ".$Param["LIMIT"]);
		}
	}*/
	

	/*
	//////////////////////////////////////////////////////////////
	Примем Foo
	function Foo($DB,$Params){
		$DB->SetQ("SELECT * FROM (".$DB->GetQ().") as T WHERE `displayin` = 'oxs:sql'" , $Params["Block"]);					
		return $DB;				
	}	
	*/
	
	function GetTree($Param=NULL){		
		
		$this->DB->SetQ("SELECT * FROM `oxs:sql` ORDER BY `oxs:sql`.`left_key`",$this->Table,$this->Table);
		
		if(!empty($Param["Foo"])){
			$this->DB=$Param["Foo"]($this->DB,$Param["Params"]);			
		}		
		
		return $this->DB->GetQ();
	}

	function GetTreeEx($Param=NULL){		
		return $this->DB->Exec($this->GetTree($Param));
	}

	function GetChilds($id,$Param=NULL){
		$Table=$this->Table;
		//	Получаем информацию о родителе
		$unit=$this->DB->Exec("SELECT * FROM `oxs:sql` WHERE `id` = 'oxs:id'" , $Table , $id);
		$this->DB->SetQ("SELECT * FROM `oxs:sql` WHERE `left_key` > 'oxs:int' AND `right_key` < 'oxs:int'" , $Table , $unit[0]["left_key"],$unit[0]["right_key"]);
		
		if(!empty($Param["Foo"])){
			$this->DB=$Param["Foo"]($this->DB,$Param["Params"]);			
		}		

		return $this->DB->GetQ();
	}

	function GetChildsEx($id,$Param=NULL){		
		return $this->DB->Exec($this->GetChilds($id,$Param));
	}

	function GetParents($id,$Params=NULL){
		$Table=$this->Table;
		//	Получаем информацию о родителе
		$unit=$this->DB->Exec("SELECT * FROM `oxs:sql` WHERE `id` = 'oxs:int'" , $Table , $id);
		$this->DB->SqtQ("SELECT * FROM `oxs:sql` WHERE `left_key` <= 'oxs:int' AND `right_key` >= 'oxs:int' " , $Table , $unit[0]["right_key"],$unit[0]["left_key"]);
		
		if(!empty($Param["Foo"])){
			$this->DB=$Param["Foo"]($this->DB,$Param["Params"]);			
		}		

		return $this->DB->GetQ(); 
	}

	function GetParentsEx($id,$Params=NULL){
		$this->GetParents($id,$Params);
		return $this->DB->Exec();
	}

	/*function GetBranchEx($id,$Params=NULL){
		$this->GetBranch($id);
		return $this->DB->Exec();
	}

	function GetBranch($id,$Params=NULL){
		$Table=$this->Table;
		//	Получаем информацию о родителе
		$unit=$this->DB->Exec("SELECT * FROM `oxs:sql` WHERE `id` = 'oxs:int'" , $Table , $id);
		$this->DB->SetQ("SELECT * FROM `oxs:sql` WHERE `right_key` > 'oxs:int' AND `left_key` < 'oxs:int' " , $Table , $unit[0]["left_key"],$unit[0]["right_key"]);
		
		if(!empty($Param["Foo"])){
			$this->DB=$Param["Foo"]($this->DB,$Param["Params"]);			
		}	

		return $this->DB->GetQ(); 
	}*/

	/*function GetParent($Table,$id){
		//	Получаем информацию о родителе
		$unit=$this->DB->Exec("SELECT * FROM `oxs:sql` WHERE `id` = 'oxs:int'" , $Table , $id);

		return $this->DB->Exec("SELECT * FROM `oxs:sql` WHERE `left_key` <= 'oxs:int' AND `right_key` >= 'oxs:int' AND `level` = `level` + '1' ORDER BY `left_key`" , $Table , $unit[0]["left_key"],$unit[0]["right_key"]);
	}*/

	function CreateRoot(){
		$Table=$this->Table;
		$this->Msg("Создаю корневаю запись в табилице ".$Table,"MESSAGE");
		if($this->DB->IfEmpty($Table)){
			$this->DB->Exec("ALTER TABLE `".$Table."` AUTO_INCREMENT=0");
			$this->DB->Insert($Table, array( "id" => 1 , "level" => 1 , "left_key" => 1 , "right_key" => 2 , "pid" => 0));
			$this->Msg("Запись создана","GOOD");
		}else{
			$this->Msg("Таблица не пуста","FATAL_ERROR");
		}
	}

	function Insert($Parent,$Data=NULL){

		$Table=$this->Table;

		//	Проверим что нам передали
		//	Родитель долно быть положительнео число больше 0
		if(!Oxs::G("cheker")->id($Parent) || empty($Parent)){
			$this->Msg("Не верный родитель: \"".$Parent."\"  в таблице ".$this->Table,"ERROR");
			return null;
		}

		//	Получаем информацию о родителе
		$Parent=$this->DB->Exec("SELECT * FROM `oxs:sql` WHERE `id` = 'oxs:int'" , $this->Table , $Parent);

		//	Существует ли указанный родитель
		if(!$Parent){
			$this->Msg("Не найден родитль с id = ".$Parent,"ERROR");
			return null;
		}
		
		$this->Msg("Добавляю узел в таблицу ".$Table,"MESSAGE");
		
		if($Data == NULL) $Data = array();
		if(!is_array($Data)){
			$this->Msg("Неверный формат переданныз данных","ERROR");
			return null;
		}		
		
		$this->DB->Update($Table,array(
				"left_key" => "`left_key` + 2" ,
				"right_key" => "`right_key` + 2" 
			), " WHERE `left_key` > 'oxs:int'" , $Parent[0]["right_key"] );

		$this->DB->Update($Table,array(
				"right_key" => "`right_key` + 2" 
			), " WHERE right_key >= 'oxs:int' AND left_key < 'oxs:int'" , $Parent[0]["right_key"] , $Parent[0]["right_key"]);

		$InsertData = array(
				"int:left_key" => $Parent[0]["right_key"],
				"int:right_key" => $Parent[0]["right_key"] + 1,
				"int:level" =>  $Parent[0]["level"] + 1 , 
				"int:pid" => $Parent[0]["id"] 
			);
		
		foreach ($Data as $key => $Value){
			$InsertData[$key]=$Value;
		}

		$this->DB->Insert($Table,$InsertData);
		return $this->DB->GetLastId();
	}

	function Remove($id){
		$Table=$this->Table;
		$this->Msg("Удаляю узел из таблицы ".$Table,"MESSAGE");

		if(!Oxs::G("cheker")->id($id)){
			$this->Msg("Не верный id узла для удаления","ERROR");
		}

		if(empty($id)){
			$this->Msg("Не указан id узла для удаления","ERROR");
		}
		
		//	Получаем информацию о удаялемом юните
		$unit=$this->DB->Exec("SELECT * FROM `oxs:sql` WHERE `id` = 'oxs:int'" , $Table , $id);
		if(empty($unit)){
			$this->Msg("Узел с указанным id не найден","WARNING");
			return 0;
		}
		
		//	Удаление узла
		$this->DB->Delete($Table,"WHERE `left_key` >= 'oxs:int' and `right_key` <= oxs:int",$unit[0]["left_key"],$unit[0]["right_key"]);

		//	Обновление ключей
		$this->DB->Update($Table,array(
				"left_key" => "IF(`left_key` > '".$unit[0]["left_key"]."', `left_key` - ('".$unit[0]["right_key"]."' - '".$unit[0]["left_key"]."' + '1'), `left_key`)" ,
				"right_key" => "`right_key` - ('".$unit[0]["right_key"]."' - '".$unit[0]["left_key"]."' + '1')"
			)," WHERE `right_key` > 'oxs:int'" , $unit[0]["right_key"]);
	}

	//	Сменить родителя, принудительно!
	//	Даже если замена происходит в пределах одного предка
	function ChangeParent($id,$id_move){
		$this->Msg("Меняю родителя ".$Table,"MESSAGE");	
		$this->Move($id,$id_move,true);
	}

	//	Пункт котоырй переносим (id_move)
	//	Пункт за который переноим (id)
	//	режим change_parrent==false перемещаемый обьект встает под обьектом id
	//	режим change_parrent==true перемещаемый обьект встает внутрь обьекта id
	function Move($id_move,$id,$change_parrent=false){
		
		$this->Msg("Перемещаю узел в таблице ".$Table,"MESSAGE");		

		$Table=$this->Table;

		if($id == $id_move){
			$this->Msg("Попытка перенести самого себя за самим собой","ERROR");
			return ;
		}
		
		//	Получаем информацию о родителе
		$unit=$this->DB->Exec("SELECT * FROM `oxs:sql` WHERE `id` = 'oxs:int'" , $Table , $id)[0];
		
		//	Получаем информацию о узле в который перемещаем
		$unit_move=$this->DB->Exec("SELECT * FROM `oxs:sql` WHERE `id` = 'oxs:int'" , $Table , $id_move)[0];			

		//	Проверка на то что мы пытаемся переместить узел в одного из своих потомков		
		///////////////////////////////////////////////////////////////////////////////////////////////////
		$R=$this->DB->Exec("SELECT * FROM `oxs:sql` WHERE `left_key` > 'oxs:int' AND `right_key` < 'oxs:int' AND `left_key` = 'oxs:int' AND `right_key` = 'oxs:int' ORDER BY `left_key`" , $Table , $unit_move["left_key"], $unit_move["right_key"] , $unit["left_key"], $unit["right_key"]);

		if($R) {
			$this->Msg("Попытка переноса узла в свего же потомка","ERROR");
			return ;
		}
		
		//	Получаем колчиество вложенных обьектов котоыре содержаться в переносимой категории
		$R=$this->DB->Exec("SELECT * FROM `oxs:sql` WHERE `left_key` >= 'oxs:int' AND `right_key` <= 'oxs:int' ORDER BY `left_key`" , $Table , $unit_move["left_key"], $unit_move["right_key"]);
		$sub_cat_move = count($R);

		$this->Msg("Колчиестов подкатегорий ".($sub_cat_move),"MESSAGE");
		
		
		//	Изымаем перемещаемый элемент. Левые и правые ключи котыре больше правог оключа изымаемого элемента уменьшаем
		//	на количество вложенных в перемещайемый элемент элементов			
		////////////////////////////////////////////////////////////////////////
		$this->DB->Update($Table, 
			array( 
				"left_key" =>  " `left_key` -  '".($sub_cat_move*2)."'" 
			),
			" WHERE `left_key` > 'oxs:int'" , $unit_move["right_key"]
		);

		$this->DB->Update($Table, 
			array( 
				"right_key" =>  " `right_key` -  '".($sub_cat_move*2)."'" 
			),
			" WHERE `right_key` > 'oxs:int'" , $unit_move["right_key"]
		);
		////////////////////////////////////////////////////////////////////////

		//	Получим правый ключ элемента id заново так как он скорее всего изменился			
		$unit_re=$this->DB->Exec("SELECT * FROM `oxs:sql` WHERE `id` = 'oxs:int'" , $Table , $id)[0];
		$this->Msg("RR =  ".$unit_re["right_key"],"MESSAGE");
		

		//	Если режим change_parrent = true мы внедяремся в пункт то есть обрачиваемся им
		//	Если нет прост овстаем за ним
		if(!$change_parrent){

			//	Высчитываемразницу в смещениях
			//	Тащим снизу вверх
			//if($unit_move["left_key"]>$unit["left_key"])
			$Range = ( $unit_re["right_key"] - $unit_move["left_key"] ) + 1;
			//else
			//	Тащщим сверху вниз	
				//$Range = ( $unit["left_key"] - $unit_move["right_key"] ) + 1;
			
			$this->Msg("Смещение  ".$Range,"MESSAGE");

			//	Берем правый ключ элемента id и увеличенный на 1 вставим в леый ключ переносимого
			$this->DB->Update($Table, 
			array( 
				"int:left_key" =>  $unit_re["right_key"] + 1
				),
				" WHERE `id` = 'oxs:int'" , $id_move
			);

			//	Меняем правый ключ перемещаемого элемента увеличиваем его на количестов вложенных категорий
			$this->DB->Update($Table, 
			array( 
				"int:right_key" =>  ( ($unit_re["right_key"] ) + ($sub_cat_move * 2) )
				),
				" WHERE `id` = 'oxs:int'" , $id_move
			);		
	
			//	перебираем вложенные категории что бы составить из них список id этих категорий
			for($i=0;$i<count($R);$i++){
				if($R[$i]["id"] !=  $id_move)
					$t=$t."'".$R[$i]["id"]."',";	
			} $t=trim($t,",");

			$this->Msg("Списко id: ".$t,"MESSAGE");

			//	Изменяем ключи внтури переносимного элемента если в нем ест ьподкатегории
			if(!empty($t))			
			$this->DB->Update($Table,array(
					"left_key" => "`left_key` + '".( $Range  )."'", 
					"right_key" => "`right_key` + '".( $Range  )."'"					
				), " WHERE `id` IN (".$t.")");				

			//	Увеличим все эелементы ниже по дереву на колчиестов категорий * 2
			//	После увеличим все ключи которые больше правого ключа переносимого элемента на колчиестов вложенных категори переносимого элемента
			$tt = $t;	
			if(empty($t)) $t = "'".$id_move."'"; else $t = $t.",'".$id_move."'";
			$this->DB->Update($Table,array(
					"left_key" => "`left_key` + '".($sub_cat_move*2)."'"								
				), " WHERE `left_key` > 'oxs:int' and `id` not IN (".$t.")" , ($unit_re["right_key"]  ) );	

			$this->DB->Update($Table,array(
					"right_key" => "`right_key` + '".($sub_cat_move*2)."'"								
				), " WHERE `right_key` > 'oxs:int' and `id` not IN (".$t.")" , ($unit_re["right_key"] ) );	

			// Меняем pid так как мы встаем за новым элементом можно просто взят ьего родителя и все
			////////////////////////////////////////////////////////
			$this->DB->Update($Table,array(
					"int:pid" => $unit["pid"]								
				), " WHERE `id` = 'oxs:int' " , $id_move );	
			////////////////////////////////////////////////////////

			//	Расчитываем новый level для этого просто вычтем из левела unit наш левел
			//////////////////////////////////////////////////////////
			$new_lewel = $unit["level"] - $unit_move["level"];
			$this->Msg("Новый левлел: ".$new_lewel,"MESSAGE");

			//	Зададим левел для unit_move
			$this->DB->Update($Table,array(
				"int:level" => $unit["level"]								
			), " WHERE `id` = 'oxs:int' " , $id_move );

			//	для подкатегорий
			if(!empty($tt))			
			$this->DB->Update($Table,array(
					"level" => "`level` + '".( $new_lewel  )."'"							
				), " WHERE `id` IN (".$tt.")");
			//////////////////////////////////////////////////////////
			
		}else{

			//	Высчитываемразницу в смещениях				
			$Range = ( $unit_re["left_key"] - $unit_move["left_key"] + 1 );
			
			$this->Msg("Смещение  ".$Range,"MESSAGE");

			//	Берем правый ключ элемента id и увеличенный на 1 вставим в леый ключ переносимого
			$this->DB->Update($Table, 
			array( 
				"int:left_key" =>  $unit_re["left_key"] + 1
				),
				" WHERE `id` = 'oxs:int'" , $id_move
			);

			//	Меняем правый ключ перемещаемого элемента увеличиваем его на количестов вложенных категорий
			$this->DB->Update($Table, 
			array( 
				"int:right_key" =>  ( ($unit_re["left_key"] ) + ($sub_cat_move * 2) )
				),
				" WHERE `id` = 'oxs:int'" , $id_move
			);	

			
			$this->DB->Update($Table, 
			array( 
				"right_key" => " `right_key` +  '". ($sub_cat_move * 2) . "'"
				),
				" WHERE `id` = 'oxs:int'" , $id
			);	

			//	перебираем вложенные категории что бы составить из них список id этих категорий
			for($i=0;$i<count($R);$i++){
				if($R[$i]["id"] !=  $id_move)
					$t=$t."'".$R[$i]["id"]."',";	
			} $t=trim($t,",");

			$this->Msg("Списко id: ".$t,"MESSAGE");

			//	Изменяем ключи внтури переносимного элемента если в нем ест ьподкатегории
			if(!empty($t))			
			$this->DB->Update($Table,array(
					"left_key" => "`left_key` + '".( $Range  )."'", 
					"right_key" => "`right_key` + '".( $Range )."'"					
				), " WHERE `id` IN (".$t.")");		

			//	Увеличим все эелементы ниже по дереву на колчиестов категорий * 2
			//	После увеличим все ключи которые больше правого ключа переносимого элемента на колчиестов вложенных категори переносимого элемента
			$tt = $t;	
			if(empty($t)) $t = "'".$id_move."',"."'".$id."'"; else $t = $t.",'".$id_move."',"."'".$id."'";
			$this->DB->Update($Table,array(
					"left_key" => "`left_key` + '".($sub_cat_move*2)."'"								
				), " WHERE `left_key` > 'oxs:int' and `id` not IN (".$t.")" , ($unit_re["left_key"]  ) );	

			$this->DB->Update($Table,array(
					"right_key" => "`right_key` + '".($sub_cat_move*2)."'"								
				), " WHERE `right_key` > 'oxs:int' and `id` not IN (".$t.")" , ($unit_re["left_key"] ) );

			// Меняем pid так как мы встаем за новым элементом можно просто взят ьего родителя и все
			////////////////////////////////////////////////////////
			$this->DB->Update($Table,array(
					"int:pid" => $id								
				), " WHERE `id` = 'oxs:int' " , $id_move );	
			////////////////////////////////////////////////////////		

			//	Расчитываем новый level для этого просто вычтем из левела unit наш левел
			//////////////////////////////////////////////////////////
			$new_lewel = $unit["level"] - $unit_move["level"] + 1;
			$this->Msg("Новый левлел: ".$new_lewel,"MESSAGE");

			//	Зададим левел для unit_move
			$this->DB->Update($Table,array(
				"int:level" => ($unit["level"] + 1)								
			), " WHERE `id` = 'oxs:int' " , $id_move );

			//	для подкатегорий
			if(!empty($tt))			
			$this->DB->Update($Table,array(
					"level" => "`level` + '".( $new_lewel  )."'"							
				), " WHERE `id` IN (".$tt.")");
			//////////////////////////////////////////////////////////			
		}
		
		return;
		
	}	

	//	Функция возвращает список с вложенынми спсиками в соответствии со стандартом 
	//	Параметры:

	//	$R - Массив данных
	//	ulstyle - Стиль основного списка	
	//	subulstyle - Стиль выпадашек
	//	treangle - вывод дял подпунктов (ункция)

	//	Функции Foo

	function GetUl($R,$Param=NULL){
		if(empty($R)){
			$this->Msg("Не передан массив данных","FATAL_ERROR");	
			return 0;	
		}		
		
		if(empty($Param["Foo"]))$Param["Foo"]=NULL;	
		if(empty($Param["treangle"])) $Param["treangle"] = function(){};			

		return "<ul class=\"".$Param["ulstyle"]."\">".$this->ShowULEx($R,$Param,0)."</ul>";
	}	

	private function ShowULEx($Tree,$Param,$i){

		if($i>=count($Tree)) return;

		if( $Tree[$i]["level"] < $Tree[$i+1]["level"] ){
			if($Param["Foo"]==NULL)
				return "<li>".$Tree[$i]["name"]." <ul data-level=".$Tree[$i]["level"]." class=\"".$Param["subulstyle"]."\">".($this->ShowULEx($Tree,$Param,++$i))."</ul></li>";	
			else
				return "<li>".($Param["Foo"]($Tree[$i])).( $Param["treangle"]($Tree[$i]) )."  <ul data-level=".$Tree[$i]["level"]." class=\"".$Param["subulstyle"]."\">".($this->ShowULEx($Tree,$Param,++$i))."</ul></li>";	
		}		

		if($Param["Foo"]==NULL)
			$R = $R."<li> ".$Tree[$i]["name"]."</li>";
		else
			$R = $R."<li> ".$Param["Foo"]($Tree[$i])."</li>";

		if( $Tree[$i]["level"] > $Tree[$i+1]["level"] ){	
			for($z=0;$z<($Tree[$i]["level"] - $Tree[$i+1]["level"] ) ;$z++){
				$R = $R."</ul>";
			}	
		}
		
		$R = $R.($this->ShowULEx($Tree,$Param,++$i));
		return $R;
	}	

}

?>