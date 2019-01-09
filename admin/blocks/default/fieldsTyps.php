 <?php
	if(!defined("OXS_PROTECT"))die("protect");

	class default_fieldsTyps extends BlocksSingleLib{
		
		function __construct($Path){	
			parent::__construct($Path);	
		}

		function text($Field,$Data){			
			Oxs::I("field");	
			if($Field["no_change"]) $attr = " disabled ";
			return $Field["description"].field::Text($Field["system_name"],$Data,array( "attr"=>$attr , "class"=>"form-control oxs_field_value" , "style" => "margin-top:3px;".$Field["field_style"] , "auto_clear" => $Field["form_name"]) );			
		}

		function textArea($Field,$Data){			
			Oxs::I("field");	
			if($Field["no_change"]) $attr = " disabled ";
			return $Field["description"].field::TextArea($Field["system_name"],$Data,array( "attr"=>$attr , "class"=>"form-control oxs_field_value" , "style" => "margin-top:3px; ".$Field["field_style"] ) );			
		}

		function checkbox($Field,$Data){
			Oxs::I("field");		
			if($Field["no_change"]) $attr = " disabled ";	
			return "<table style='padding:0px; margin:0px;'><tr><td valing=middle style='padding-top:2px;'>".field::Checkbox($Field["system_name"],$Data,array( "attr"=>$attr , "class"=>"form-check-input oxs_field_value" , "style" => "margin-top:0px;margin-right:10px;" ) )."</td><td valing=middle>".$Field["form_name"]."</td></tr></table><i>".$Field["description"]."</i>";				
		}

		function hidden($Field,$Data){			
			Oxs::I("field");	
			return field::hidden($Field["system_name"],$Data,array( "class"=>"oxs_field_value" ) );			
		}		

		function file($Field,$Data){			

			//	Создем поле для указания файла
			Oxs::I("field");	

			Oxs::G("BD")->Start();

			?>
				<STYLE>
					.oxs_file_field{						
						opacity: 0;
						margin-top:-50px;
						height: 50px;
					}

					.oxs_file_field_box_<?php echo $Field["system_name"];?>{					
						height: 50px;
						background: url('admin/tpl/default/img/Files-Download-File-icon.png') no-repeat; 
						background-size: 50px 50px; 		
						cursor: pointer;
						padding-left: 60px;	
						display: table-cell;
						vertical-align: middle;	
						width: 400px;						
					}
					
				</STYLE>
			
			<input type=hidden name = "<?php echo $Field["system_name"];?>" class="oxs_field_value <?php echo $Field["system_name"];?>" >

			<?php

			if(empty($Field["file_setting"]["multiple"])){
				$Text = "Укажите файл для загрузки или перетащите из папки";
				echo $Field["description"]."<div class=oxs_file_field_box_".$Field["system_name"].">".$Text."</div>".field::File("oxs_file_name_".$Field["system_name"],array( "class"=>"oxs_file_field" , "smart" => true , "object_name" => "oxs_file_".$Field["system_name"]) )."";
			}
			else{
				$Text = "Укажите файлы для загрузки или перетащите их папки";
				echo $Field["description"]."<div class=oxs_file_field_box_".$Field["system_name"].">".$Text."</div>".field::File("oxs_file_name_".$Field["system_name"],array( "class"=>"oxs_file_field" , "smart" => true , "multiple" => true ,  "object_name" => "oxs_file_".$Field["system_name"]) )."";
			}
			
			?>
				<script type="text/javascript">
					
					jQuery(function(){

						//	Устанавливаем форматы
						<?php echo "oxs_file_".$Field["system_name"];?>.SetFormats("<?php echo $Field["file_setting"]["format"];?>");

						//	Выбрали файлы
						<?php echo "oxs_file_".$Field["system_name"];?>.EndSelect = function(){
							this.SaveAllFile("admin/files/tmp/");
							oxs_message.Loading("Загрузка файла"); 
						};

						//	Сохранили файлы
						<?php echo "oxs_file_".$Field["system_name"];?>.EndSave = function(file,file_name){							
							
							if(file_name=="{oxs_error}"){
								oxs_message.show("Ошибка загрузки файла");
								oxs_message.LoadingStop(); 
							}

							jQuery(".<?php echo $Field["system_name"];?>").attr("value" , file_name);
							jQuery(".oxs_file_field_box_<?php echo $Field["system_name"];?>").text(file.name);
							
							setTimeout(function(){
								oxs_message.LoadingStop(); 
							},300);
						};

						//	Прогресс
						<?php echo "oxs_file_".$Field["system_name"];?>.Progress = function(e,index,files){		
							try{
								message_window.set( (index + 1) + "/" + files.length + " Загрузка файла " + files[index]["name"] + " " + Math.ceil((e.loaded/e.total) * 100) + "%" )	;	
							}catch(err){}				
												
						};

						//	Обрабоктао ишбок
						<?php echo "oxs_file_".$Field["system_name"];?>.LocalChekFile = function(file,i,e){
							if(e=="empty"){
								oxs_message.show("Файлы подходят по размеру");								
								return 1
							}else{
								oxs_message.show(e);
								return 0;
							}
						};					

					});					

				</script>				
			
			<?php

			return Oxs::G("BD")->GetEnd();			
		}

		function textarea_editor($Field,$Data){				
			Oxs::I("field");	
			if($Field["no_change"]) $attr = " disabled ";
			return $Field["description"].field::Text($Field["system_name"],$Data,array( "attr"=>$attr , "class"=>"form-control oxs_field_value" , "style" => "margin-top:3px;" , "auto_clear" => $Field["form_name"]) );		
		}
	}
 
