oxs_docs_js_docs_files_events = function(){
	
	oxs_events.add(".docs_files_board_add_files","click",function(){ 		
		
		ex_storage.add("dir","files/tmp");		
		ex_storage.add("multiple"  , "multiple");
		ex_storage.add("object"  , "docs_js_docs_files_events");				

		datablocks_manager.ExecBlock("files_manager:form",ex_storage.get(),null,null);
	});


	//	события загрузки
	this.success = function(e){
		
	}

	/*this.start = function(){

	}*/

	/*this.status = function(){

	}*/

	/*this.error = function(){

	}*/
}

