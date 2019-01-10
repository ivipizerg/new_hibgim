<?php

	if(!defined("OXS_PROTECT"))die("Wrong start point");

	class field extends SingleLib{

		function __construct($Path,$params=null){
			parent::__construct($Path,$params);
		}

		static function Text($Name,$Value=NULL,$Param=NULL){

			Oxs::G("BD")->Start();			

			if(!empty($Param["auto_clear"])){				

				//	Используем Rand что бы каждый раз был создан новый обьект иначе при работе с аякс
				//	Возникнет ситуация что обьект уже создан и новый созадвать не будет
				if(empty($Param["auto_clear_class"]))$Param["auto_clear_class"]="auto_clear_ch";				
				Oxs::G("js.loader")->ReGetObject("field:autoclear" , array ( $Name , $Param["auto_clear"] , $Param["auto_clear_class"] , addslashes($Value)) , "autoclear_".Rand() );
			}

			if(empty($Param["type"]))$Param["type"]="text";

			if($Param["type"]=="password"&&!empty($Param["auto_clear"])){
				echo "<input type=text type_ch=true name = ".$Name." value=\"".htmlspecialchars($Value)."\" class=\"".$Param["class"]."\" style=\"".$Param["style"]."\"".$Param["attr"].">";
			}else{
				echo "<input type=".$Param["type"]." name = ".$Name." value=\"".htmlspecialchars($Value)."\" class=\"".$Param["class"]."\" style=\"".$Param["style"]."\"".$Param["attr"].">";
			}

			return Oxs::G("BD")->GetEnd();
		}

		static function Password($Name,$Value=NULL,$Param=NULL){			
			$Param["type"]="password";		
			return field::Text($Name,$Value,$Param);
		}
		
		static function Textarea($Name,$Value=NULL,$Param=NULL){

			Oxs::G("BD")->Start();

			if(!empty($Param["auto_clear"])&$Value==NULL){
				//	Используем Rand что бы каждый раз был создан новый обьект иначе при работе с аякс
				//	Возникнет ситуация что обьект уже создан и новый созадвать не будет
				Oxs::G("js.loader")->GetObject("field:autoclear" , array ( $Name , $Param["auto_clear"]) , "autoclear_".Rand() );
			}

			echo "<textarea name = \"".$Name."\"  class=\"".$Param["class"]."\" style=\"".$Param["style"]."\"".$Param["attr"]." >".$Value."</textarea>";

			return Oxs::G("BD")->GetEnd();
		}

		//	Функция возращает массив из двух параметров
		//	string - это сторка которая вставится в OPTION
		//	value - это будет занчение
		static function Select($Name,$ValueMass,$Foo=NULL,$Param=NULL){

			if(empty($Param["value_name"]))$Param["value_name"]="value";

			$Result .= "<SELECT ".$Param["attr"]." class=\"".$Param["class"]."\"  name=\"".$Name."\" style=\"".$Param["style"]."\">";

			for($i=0;$i<count($ValueMass);$i++){
				
				if($Foo!=NULL){ 
					$Tmp = $Foo( $i, $ValueMass[$i]  , $Param["value"] );
				}else{
					if($ValueMass[$i]["id"] == $Param["value"]){
						$Tmp["string"] = sprintf( " selected value=%s " , $ValueMass[$i]["id"] );
						$Tmp["value"] = sprintf( "%s" , $ValueMass[$i][$Param["value_name"]] );
					}
					else{
						$Tmp["string"] = sprintf( " value=%s " , $ValueMass[$i]["id"] );
						$Tmp["value"] = sprintf( "%s" , $ValueMass[$i][$Param["value_name"]] );
					}						
				}
				$Result .= sprintf( "<OPTION %s >%s</OPTION> " , $Tmp["string"] , $Tmp["value"]);

			}

			$Result .= "</SELECT >";
			return $Result;
		}

		static function File($Name,$Param=NULL){

			if($Param["mutiple"]) $Param["attr"] .= " multiple ";
			$R .= "<input style=\"".$Param["style"]."\" class=\"".$Param["class"]."\" type=file name=\"".$Name."\" ".$Param["attr"]." >";
			
			if($Param["smart"]){
			Oxs::G("BD")->Start();	
			Oxs::G("js.dir")->GetObject($Param["object_name"]);
			?>

				<script type="text/javascript">
						
					jQuery(function(){
						<?php echo $Param["object_name"].".BindInput(\"[name=".$Name."]\")"; ?>							
					});

				</script>

			<?php
			$R .= Oxs::G("BD")->GetEnd();
			}			

			return $R;
		}
		
		static function Data($Name ,$Value=NULL, $Param=NULL){

			if(!isset($Param["class"])){
				$Param["class"] = "oxs_data";
			}

			//	Настройки по умолчанию
			if(!isset($Param["options"]["time"]))$Param["options"]["time"]=true;
			if(!isset($Param["options"]["time_formar24"]))$Param["options"]["time_formar24"]=true;
			if(!isset($Param["options"]["seconds"]))$Param["options"]["seconds"]=false;
			if(!isset($Param["options"]["onChange"]))$Param["options"]["onChange"]=""; else { $Param["options"]["onChange"]=" onChange: function(){".$Param["options"]["onChange"].";},"; }
			if(!isset($Param["options"]["dateFormat"]))$Param["options"]["dateFormat"]="d.m.Y H:i:S";
			if(!isset($Param["options"]["maxDate"]))$Param["options"]["maxDate"]="";else $Param["options"]["maxDate"] = "maxDate: \"".$Param["options"]["maxDate"]."\",";
			if(!isset($Param["options"]["minDate"]))$Param["options"]["minDate"]="";else $Param["options"]["minDate"] = "minDate: \"".$Param["options"]["minDate"]."\",";	
			if( isset($Param["options"]["EnableConfirm"]) & $Param["options"]["EnableConfirm"]==true ){

				$Param["options"]["EnableConfirm"]= " , \"plugins\": [new confirmDate({})]";
				
				Oxs::GetLib("dom")->LoadJsOnce( OXS_PATH."field/js/plug.js");
				Oxs::GetLib("dom")->LoadCssOnce( OXS_PATH."field/css/plug.css");
			}


			Oxs::G("BD")->Start();
			Oxs::GetLib("dom")->jQuery();			

			Oxs::GetLib("dom")->LoadJsOnce( OXS_PATH."field/js/js.js");
			Oxs::GetLib("dom")->LoadCssOnce( OXS_PATH."field/css/style.css");

			echo field::Text($Name,$Value, $Param);

			?>
				<script type="text/javascript">
					jQuery(function(){
						//	Адовая конструкция что бы дождаться подгрузки js файлйа flatpickr
						//	Интервал закончиться как только обьект flatpickr станет доступен
						var Interval<?php echo $Name;?>;
						Interval<?php echo $Name;?>=setInterval(function(){
							if( typeof flatpickr != 'undefined' ){
								clearTimeout(Interval<?php echo $Name;?>);
								
								flatpickr("[name=<?php echo $Name ?>]" , {
									enableTime: <?php if($Param["options"]["time"]) echo " true"; else echo " false"; ?>,
									<?php echo $Param["options"]["maxDate"]; ?> 
									<?php echo $Param["options"]["minDate"]; ?> 
									<?php echo $Param["options"]["onChange"]; ?> 
									time_24hr: <?php if($Param["options"]["time_formar24"]) echo " true"; else echo " false"; ?> ,
									enableSeconds: <?php if($Param["options"]["seconds"]) echo " true"; else echo " false"; ?> ,
									dateFormat: "<?php echo $Param["options"]["dateFormat"]; ?>",
									
									//	Парсит с ошибкой пришлось отключить
									//parseDate: function(){return 0;},
									
									defaultDate: "<?php echo $Value; ?>"									
								    <?php echo $Param["options"]["EnableConfirm"]; ?>								    
								});								
							}

						},50);
					});
				</script>

			<?php

			$R = Oxs::G("BD")->GetEnd();

			return $R;
		}

		static function Checkbox($Name,$Value=NULL,$Param=NULL){
			if( $Value==1 or $Value=="on" )
				return "<input type=checkbox style=\"".$Param["style"]."\" class=\"".$Param["class"]."\" name=".$Name." ".$Param["attr"]." checked>";
			else
				return "<input type=checkbox style=\"".$Param["style"]."\" class=\"".$Param["class"]."\" name=".$Name." ".$Param["attr"].">";
		}

		static function hidden($Name,$Value=0,$Param=NULL){		
			return "<input type=hidden style=\"".$Param["style"]."\" class=\"".$Param["class"]."\" name=".$Name." value=\"".htmlspecialchars($Value)."\" ".$Param["attr"]." >";
		}

		//	имя, занчение , класс , стиль
		static function Button($name , $Value = "Кнопка",$Param=NULL){
			return "<button name = \"".$name."\" class=\"".$Param["class"]."\" style=\"".$Param["style"]."\" ".$Param["attr"]." \">".$Value."</button>";
		}
}
?>
