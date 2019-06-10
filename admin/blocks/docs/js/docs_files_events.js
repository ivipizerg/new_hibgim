oxs_docs_js_docs_files_events = function(Data){

	//	Активируем сортировку
	$( ".docs_files_board_add_files_sortable" ).sortable({
      revert: true
    });
	
	oxs_events.add(".docs_files_board_add_files","click",function(){ 		
		
		ex_storage.add("dir","files/tmp");		
		ex_storage.add("multiple"  , "multiple");
		ex_storage.add("object"  , "docs_js_docs_files_events");				

		datablocks_manager.ExecBlock("files_manager:form",ex_storage.get(),null,null);
	});


	//	события загрузки
	this.success = function(e){
		if(e.Code!=-1)
			jQuery(".docs_files_board_add_files_sortable").append("<div style='margin-top:5px;margin-bottom:5px;'><table border=0 width=100%><tr><td width=80%><input type=text class=form-control oxs_data_file_name = \"" + e.Data["file_name"] + "\" value=\"" + e.Data["original_file_name"] + "\" ></td><td width=10% align=center><img class=docs_files_board_add_files_sortable_img width=20 style='' src=" + Data["upDown"] + "> </td><td width=10% align=center><img  class=docs_files_board_add_files_sortable_img_close width=30 style='' src=" + Data["close"] + "> </td></tr></table></div>");
	}

	/*this.start = function(){

	}*/

	/*this.status = function(){

	}*/

	/*this.error = function(){

	}*/
}

