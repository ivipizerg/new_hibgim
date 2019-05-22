oxs_docs_js_docs_files_events = function(){
	
	oxs_events.add(".docs_files_board_add_files","click",function(){ 
		
		aj_auth.Exec("files_manager:ajax",{ "action":"formLoadFiles" , param: { "name":"docs_js_docs_files_events" , "multiple":"multiple" } , "dir":"files/tmp" },function(Input){
			jQuery(".files_board_tmp_zone").html(Input.Msg);			
		});

	});


	//	события загрузки
	this.success = function(){

	}

	this.start = function(){

	}

	this.status = function(){

	}

	this.error = function(){

	}
}

