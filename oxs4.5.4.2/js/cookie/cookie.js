function oxs_js_cookie(log){	

	var _this=this;
	
	this.get_cookie = function ( cookie_name ){
	  var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );	 
	  if ( results )
	    return ( unescape ( results[2] ) );
	  else
	    return null;
	}

	//	Если не передать дату то будет бескоенчая
	this.set_cookie = function ( name, value, exp_y, exp_m, exp_d, path, domain, secure )
	{
	  var cookie_string = name + "=" + escape ( value );	 
	  if ( exp_y ){
	    var expires = new Date ( exp_y, exp_m, exp_d );
	    cookie_string += "; expires=" + expires.toGMTString();
	  }
	 
	  if ( path )
	        cookie_string += "; path=" + escape ( path );
	 
	  if ( domain )
	        cookie_string += "; domain=" + escape ( domain );
	  
	  if ( secure )
	        cookie_string += "; secure";
	  
	  document.cookie = cookie_string;
	}
	
}
