<?php

if(!defined("OXS_PROTECT"))die("Wrong start point");

class js_loader extends SingleLib{

	function __construct($Path,$Params=NULL){
		parent::__construct($Path,$Params);
		$this->GetObject("js.loader");
	}

	function JS_INIT($class_name,$Param=NULL,$ui_name=NULL,$Reget=false){

		//echo $ui_name;

		if($ui_name==NULL){
			$ui_name = $class_name;
		}

		if($Reget){
			?>
				<script>
					jQuery(function(){										
						delete <?php echo $ui_name;?>;	
					});
				</script>
			<?php
		}

		?>
			<script>
				jQuery(function(){
					if(typeof <?php echo $ui_name;?> == "undefined")
						<?php echo $ui_name;?>=new oxs_<?php echo $class_name;?>( <?php for($i=0;$i<count($Param);$i++){ if( strripos($Param[$i],"notString:") === 0 ) echo str_replace("notString:", "", $Param[$i]); else echo "\"".$Param[$i]."\""; if($i!=count($Param) - 1) echo ",";} ?> );

				});
			</script>
		<?php

		return $ui_name;

	}

	function Check($Name){
		return $this->_GetObject($Name,null,null,null,true);
	}


	function ReGetObject($Name,$Param=NULL,$ui_name=NULL,$jsut_include=false){
		return $this->_GetObject($Name,$Param,$ui_name,null,null,true);
	}

	function GetObject($Name,$Param=NULL,$ui_name=NULL,$jsut_include=false){
		return $this->_GetObject($Name,$Param,$ui_name);
	}

	function IncludeObject($Name){
		$this->_GetObject($Name,$Param=NULL,$ui_name=NULL,true);
	}

	function _GetObject($Name,$Param=NULL,$ui_name=NULL,$jsut_include=false,$just_check=false,$Reget=false){

		/*echo "<br>===================================<br>";
		echo "".$Name."<br>";*/

		$D=Oxs::GetLib("dom");
		$D->jQuery();

		if(!is_array($Param)){
			$Param =  Array( $Param );
		}
		
		$old_name = $Name;

		//	Изем точку в имени
		$Path = str_replace(".","/",$Name);
		$Name = explode(".",$Name);
		$Name = $Name[count($Name)-1];

		if(strripos($Name,":")!==FALSE){
			$Name = explode(":",$Name);
			unset($Name[0]);
			$Name = $Name[1];

			$class_name = str_replace(":","_",$class_name);

			$Path = str_replace(":".$Name,"",$Path);

			$Tmp = explode("/",$Path);
			if($Tmp[count($Tmp)-1] == $Name){
				$class_name = str_replace("/","_",$Path);
			}else{
				$class_name = str_replace("/","_",$Path)."_".$Name;
			}

		}else{
			$class_name = str_replace("/","_",$Path);
		}

		/*echo "Name = " . $Name."<br>";
		echo "Path = " . $Path."<br>";
		echo "class_name = " . $class_name."<br>";*/

		for($i=0;$i<Oxs::GetPathCount();$i++){

			//echo "Ищу в: ". Oxs::GetPath($i).$Path."/".$Name.".js<br>";

			if($D->CheckJs(Oxs::GetPath($i).$Path."/".$Name.".js")){

				if($just_check) return true;

				//echo " Есть<br>";
				//echo Oxs::GetRoot().Oxs::GetPath($i).$Path."/".$Name.".js<br>";
				$D->LoadJsOnce(ltrim(Oxs::GetPath($i),"/").$Path."/".$Name.".js");
				if(!$jsut_include) $this->Msg("Создаю JS обьект " . $old_name, "GOOD");
				else $this->Msg("Подключаю JS обьект " . $old_name. " к проекту", "GOOD");
				if(!$jsut_include) return $this->JS_INIT($class_name,$Param,$ui_name,$Reget);	
				else return true;			
			}else{
				//echo " Нет<br>";
			}
		}

		if($just_check) return false;

		$this->Msg("НЕ удалось подключить JS обьект " . $old_name ."(oxs_".$class_name.")[".ltrim(Oxs::GetPath($i),"/").$Path."/".$Name.".js"."]", "ERROR");

	}
}
