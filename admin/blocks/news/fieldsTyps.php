 <?php
	if(!defined("OXS_PROTECT"))die("protect");

	Oxs::I("default:fieldsTyps");

	class news_fieldsTyps extends default_fieldsTyps{
		
		function __construct($Path){	
			parent::__construct($Path);	
		}	

		function cat_tree($Field,$Data){
			return Oxs::G("default.tree:fieldsTyps")->cat_tree($Field,$Data);
		}

		function mini_img($Field,$Data){

			Oxs::G("BD")->Start();

			$D = Oxs::L("dialog");
			$D->setName("dialog_" . $name."_img");		

			Oxs::J("news.js:mini_img_controller",array($Field["system_name"]));

			//	Так как форма была оформлена как блок даных вызываем её как блок данных
			//////////////////////////////////////////////////////////////////////
			Oxs::G("datablocks_manager")->Params=Array();
			$this->setP("dir","files/tmp");												//	куда грузим
			$this->setP("multiple","");													//	мультивыбор
			$this->setP("controller","news_js_mini_img_controller");					//	обьект обработчик событий
			$this->setP("name",$Field["system_name"]);									//	имя формы(должно быть уникально)
			$this->setP("MAX_UPLOAD",Oxs::G("img_settings:model")->get("max_count"));	//	Кодичестов файлов
			$this->setP("MAX_SIZE",Oxs::G("img_settings:model")->get("max_size"));		//	Размерфайла

			echo $D->build();
			echo Oxs::G("files_manager:form")->Exec();

			?>

			<script type="text/javascript">
				$(function(){

				oxs_events.clear(".oxs_select_mini_img","click"	);
				oxs_events.add(".oxs_select_mini_img","click",function(){
						 aj_auth.Exec("files_manager",{ action: "get_form" , type: "img_add_ckeditor" ,  page: 1 , search: 5 , name: name , category_list: [ 5 , 6 ] , class_img: "oxs_mini_img_item" } , function(Input){
					    	jQuery(".oxs_main_container_dialog").html(Input.Msg); 	
					    });
					});

				});
			</script>

			<?php

			if(empty($Data)){	
				return $Field["description"]."<div class='oxs_select_mini_img' style='float:right;cursor:pointer;text-decoration: underline;'>Выбрать</div><br><div class=show_mini_img_area style='background-size:cover ;background-position: center; margin:auto;width:250px; height:170px;display:none;'></div>".Oxs::G("BD")->getEnd();
			}else{				
				?>
				<script type="text/javascript">
					$(function(){
						$(".oxs_dialog_load_files_zone_mini_img").hide();
						news_js_mini_img_controller.deleteButton();
						ex_storage.add("data-file","");
						ex_storage.add("data-original-file","");
						ex_storage.add("data-fix-file-name","<?php echo $Data;?>",1);	
					});									

				</script>
				<?php

				return $Field["description"]."<div class='oxs_select_mini_img' style='float:right;cursor:pointer;text-decoration: underline;'>Выбрать</div><br><div class=show_mini_img_area data-fix=1 data-file=".$Data." style='background-image : url(\"files/news_img/thumbs/". $Data ."\"); background-size:cover ;background-position: center; margin:auto;width:250px; height:170px;'><img class=oxs_delete_mini_img style='float:right;cursor:pointer;' width=40 src='admin/tpl/default/img/cancel.png'></div>".Oxs::G("BD")->getEnd();
			}			
		}		
	}
 
