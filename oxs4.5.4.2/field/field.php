<?php

	if(!defined("OXS_PROTECT"))die("Wrong start point");

	class field extends SingleLib{

		function __construct($Path,$params=null){
			parent::__construct($Path,$params);
		}

		static function Text($Name,$Value=NULL,$Param=NULL){

			Oxs::G("BD")->Start();			

			if(!empty($Param["auto_clear"])){				

				Oxs::J("js.oxs_events");

				//	Используем Rand что бы каждый раз был создан новый обьект иначе при работе с аякс
				//	Возникнет ситуация что обьект уже создан и новый созадвать не будет
				if(empty($Param["auto_clear_class"]))$Param["auto_clear_class"]="auto_clear_ch";				
				Oxs::G("js.loader")->ReGetObject("field:autoclear" , array ( $Name , $Param["auto_clear"] , $Param["auto_clear_class"] , addslashes($Value)) , "autoclear_".Rand() );
			}

			if(empty($Param["type"]))$Param["type"]="text";

			if($Param["type"]=="password"&&!empty($Param["auto_clear"])){
				echo "<input type=text type_ch=true name = ".$Name." value=\"".htmlspecialchars($Value)."\" class=\"".$Param["class"]."\" style=\"".$Param["style"]."\" ".$Param["attr"]." >";
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
		
		static function Data($Name ,$Value=NULL, $Param=NULL){
			Oxs::G("BD")->Start();			

				Oxs::J("crypto.base64");
				Oxs::J("js.oxs_events");	

				$Param["attr"] .= "  autocomplete=off  ";

				echo field::Text($Name ,$Value, $Param);
				Oxs::RJ("field.js:data",array($Name,Oxs::G("crypto.base64")->E($Param["config"])));

			return Oxs::G("BD")->getEnd();
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
