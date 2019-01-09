oxs_js_ajaxexec = function(Path,SOURCES,Code,WinObj,ajax_object){

	var _this = this;	

	this.Exec = function( Lib , P , Foo){		

		Param = {};

		Param.Lib = Lib;
		Param.SOURCES = SOURCES;
		Param.P = P;
		Param.Code = Code;	
		Param.WinObj = WinObj;			

		eval(ajax_object).POST( Path + "js/ajaxexec/ajax_resiver.php", Param , Foo );
		
	}

}
