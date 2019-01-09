<?php

	function exit_modul($Param=NULL){
		
		echo "Вы зашли как: ".(Oxs::G("usermanager")->CurrentUser->Get("username"))." ";
		echo " <a href=\"logOut\" >Выход</a><br>";

		//	Нам приходит дата послежнег овхода в +0 UTC
		$C = Oxs::L("calendar" , array ( Oxs::G("usermanager")->CurrentUser->Get("last_enter") ) );

		//	Выводим на указанынй часовой пояс
		echo " Последнйи вход ". $C->get("GetDay", Oxs::G("storage")->get("UTC") ) . " " . $C->get("GetMountName", Oxs::G("storage")->get("UTC") , true ). " " . $C->get("GetYear", Oxs::G("storage")->get("UTC") ) . " в " . $C->get("GetTime", Oxs::G("storage")->get("UTC") ); 

		echo " <a href=\"index.php\" target=\"_blank\">Перейти на сайт</a><br>";
		

		?>

		<script type="text/javascript">
			
			jQuery(function(){

				function Foo(R,C,T,D){
					if(C==1){
						window.location.reload();
					}
				}

				jQuery("[href=logOut]").on("click",function(){
					aj_auth.Exec("autentificator:ajax" , { action:"logOut" } , Foo );
					return false;
				});
				
			});

		</script>


		<?php	
	}
?>

	

