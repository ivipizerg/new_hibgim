<?php
	function GetTextAfter($string,$word){
		$Temp=NULL;
		$Pos=strpos($string,$word);
		
		if(!empty($Pos)){
			for($i=$Pos+(strlen($word)),$j=0;$i<strlen($string);$i++,$j++){
				$Temp=$Temp.$string[$i];
			}
		}
		return $Temp;
	}
	
	function GetTextBefore($string,$word){
		$Temp=NULL;
		$Pos=strpos($string,$word);
		
		if(!empty($Pos)){
			for($i=0,$j=0;$i<=($Pos-1);$i++,$j++){
				$Temp=$Temp.$string[$i];
			}
		}
		return $Temp;
	}
    
    	function GetCountStr($string,$word){
		return substr_count($string,$word);
	}
	
	function MakeMassivOfString($Maker,$String){
		return $Links=explode($Maker,$String);
	}
?>