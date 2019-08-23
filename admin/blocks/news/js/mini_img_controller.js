oxs_news_js_mini_img_controller = function(name){

	var _this = this;

	this.deleteButton = function(){
		oxs_events.clear(".oxs_delete_mini_img");
        oxs_events.add(".oxs_delete_mini_img","click",function(){
        	
        	$(".oxs_dialog_load_files_zone_mini_img").show(); 
        	$('.show_mini_img_area').hide();               	

        	//	Если есть парамтер data-file-fix то значит режим редактирования
        	if($('.show_mini_img_area').attr("data-fix")==1){
        		console.log("Удаление при фиксации");

        		//	Удалим флаг редактирования
        		$('.show_mini_img_area').attr("data-fix","");
        		ex_storage.add("data-fix-file-name","");	   	

        		aj_auth.Exec("news:remove",{action:"rm_rmp" , file: $('.show_mini_img_area').attr("data-file") , fix:ex_storage.get("fixingId") },function(I){
                    ex_storage.add("data-file","");
                    ex_storage.add("data-original-file","");                    		
            		oxs_message.show(I.Text);                		
            	});
        	}else{
        		console.log("Удаление при доабвлении");
        		aj_auth.Exec("news:remove",{action:"rm_rmp" , file: $('.show_mini_img_area').attr("data-original-file")},function(I){                		
            		oxs_message.show(I.Text);  

                    ex_storage.add("data-file","");
                    ex_storage.add("data-original-file","");              		
            	});
        	}                	
        });
	}

	 _this.deleteButton();

	this.change = function(e){			
       	_this.file = e;             
	}

	this.success = function(a){	
		
		ex_storage.add("data-file",a.Data["file_name"]);
		ex_storage.add("data-original-file",a.Data["original_file_name"]);

		$('.show_mini_img_area').attr("data-file",a.Data["file_name"]);
		$('.show_mini_img_area').attr("data-original-file",a.Data["original_file_name"]);		

		var e = _this.file;	
		
		if (_this.file[0].type.match('image.*')) {
            var reader = new FileReader();
            reader.onload = function (e) {            	
                
                //	Все окей, удаляем зону загруки показываем картинку
                //	добавляем крестик для удаления              
                window["dialog_" + name] = undefined;
                delete window["dialog_" + name];
                
                $(".oxs_dialog_load_files_zone_mini_img").hide();
                $('.show_mini_img_area').show().css('background-image', 'url(' + e.target.result + ')' ) ;
                $('.show_mini_img_area').html("<img class=oxs_delete_mini_img style='float:right;cursor:pointer;' width=40 src='admin/tpl/default/img/cancel.png'>") ;

               _this.deleteButton();
            }

            reader.onloadstart=function(){
            	$(".oxs_dialog_load_files_zone_mini_img").show(); 
				$('.show_mini_img_area').html("<div style='text-align:center;'><br><br><br><br>Обработка...</div>") ;			
				$('.show_mini_img_area').show();  
            }

            reader.readAsDataURL(e[0]);
        } else {            
            return false;
        }  		
	}

	this.end = function(e){	
		
	}
}