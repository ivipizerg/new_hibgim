oxs_field_js_data = function(name,config){		
	eval ( " $( \"[name=" + name + "]\" ).flatpickr( {" + (crypto_base64.D(config)) + " } );" );	  
}
  
