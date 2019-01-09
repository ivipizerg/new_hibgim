<?php

if(!defined("OXS_PROTECT"))die("Wrong start point");

class js_scroller2 extends SingleLib{

	function __construct($Path){
		parent::__construct($Path);			
	}

	function GetObject($Name="js_scroller2"){
		$D=Oxs()->GetLib("dom");
		$D->jQuery();
		$D->LoadJsOnce(OXS_PATH."/js/scroller2/scroller2.js");
		?>
			
			<script>
				jQuery(function(){
					if(typeof <?php echo $Name;?> == "undefined")
						<?php echo $Name;?>=new oxs_js_scroller2_init();										
				});
			</script>
		<?php
	}	
	
}

/*

	function Style($Param){
		?>
		<STYLE>
			.oxs_scroller_box<?php echo $this->sufix?>{
				position: relative;
				overflow:hidden;
				width: 180px;
				border: 1px solid black;
				<?php
					echo $Param["oxs_scroller_box"];
				?>			
			}

			.oxs_scroller_box_linear<?php echo $this->sufix?>{				
				position: relative;
				white-space:nowrap;				
				<?php
					echo $Param["oxs_scroller_box_linear"];
				?>		
			}

			.oxs_scroller_box_item<?php echo $this->sufix?>{
				display:inline-block;
				width: 40;
				height: 40px;
				<?php
					echo $Param["oxs_scroller_box_item"];
				?>		
			}

			.oxs_scroller_box_forward<?php echo $this->sufix?>{
				width: 40px;
				height: 40px;
				background: red;
				cursor: pointer;
				<?php
					echo $Param["oxs_scroller_box_forward"];
				?>	
				
			}

			.oxs_scroller_box_back<?php echo $this->sufix?>{
				width: 40px;
				height: 40px;
				background: green;
				cursor: pointer;
				<?php
					echo $Param["oxs_scroller_box_back"];
				?>					
			}
		</STYLE>
		<?php
	}	
	
}
*/
?>