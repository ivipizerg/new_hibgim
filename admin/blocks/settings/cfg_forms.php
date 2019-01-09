<?php
		
	if(!defined("OXS_PROTECT"))die("protect");	

	class settings_cfg_forms extends BlocksSingleLib{

		function __construct($Path,$params=null){			
			parent::__construct($Path,$params);
		}	

		function GetMasterPasswordForm(){

			Oxs::G("BD")->Start();
			
			echo Oxs::G("languagemanager")->T("enterMasterPassword")."<br><br>";		
		
			Oxs::I("field");
			echo field::Password("master_password",null, array(  "class"=>"form-control oxs_textbox_settings_cfg_forms"  , "style" => "width:250px;" ,  "auto_clear" => Oxs::G("languagemanager")->T("enterMasterPassword") ) );	
			
			?>
			<br>
			<button style="width:70px;" class='btn btn-default oxs_yes_settings_cfg_forms' ><?php echo Oxs::G("languagemanager")->T("ok") ?></button> 
			<button class='btn btn-default oxs_no_settings_cfg_forms'><?php echo Oxs::G("languagemanager")->T("cancel") ?></button></div>

			<script type="text/javascript">			
				
				jQuery(".oxs_no_settings_cfg_forms").bind("click",function(){
					oxs_black_screen.Off();					
				});

				jQuery(".oxs_yes_settings_cfg_forms").bind("click",function(){
					//	Добавляем паарметр ask
					storage.AddParam(  "masterPassword" , jQuery("[name=master_password]").val() );		
					//	Возвращаем перехват нажатий окном поиска					
					datablocks_manager.ExecBlock(  "settings:cfg"  , storage.get() ,"admin/" + "settings:cfg"  + ".html" ); 						
				});	

				//	Обработка enter
				jQuery(".oxs_textbox_settings_cfg_forms").bind("keydown",function(e){					
					//   Вход по интеру
				    if(e.keyCode==13){ 				      	
				        //	Добавляем паарметр ask
						storage.AddParam(  "masterPassword" , jQuery("[name=master_password]").val() );		
						//	Возвращаем перехват нажатий окном поиска					
						datablocks_manager.ExecBlock(  "settings:cfg"  , storage.get() ,"admin/" + "settings:cfg"  + ".html" ); 			
				    }					
				});	
				
			</script>

			<?php
			
			return Oxs::G("BD")->GetEnd();
		}
	} 
