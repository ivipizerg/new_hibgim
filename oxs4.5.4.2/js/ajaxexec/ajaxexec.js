oxs_js_ajaxexec = function(Path,Code,SOURCES,WinObj,ajax_object){

	var _this = this;	

	this.Exec = function( Lib , Params , Foo){		

		Param = {};
		Param.oxs_system_ajax_data = {};
		
		Param.P = Params;

		Param.oxs_system_ajax_data.Lib = Lib;
		Param.oxs_system_ajax_data.Code = Code;	
		Param.oxs_system_ajax_data.SOURCES = SOURCES;	
		Param.oxs_system_ajax_data.WinObj = WinObj;			

		eval(ajax_object).POST( Path + "js/ajaxexec/ajax_resiver.php", Param , Foo );
		
	}

}
