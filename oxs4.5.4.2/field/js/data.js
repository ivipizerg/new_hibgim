oxs_field_js_data = function(name,config){

	eval("\
		$( \"[name=" + name + "]\" ).datepicker(eval({" + crypto_base64.D(config) + "}));\
	");

    js_oxs_events_field_data.add("[name=" + name + "]","blur",function(){
		jQuery(this).removeClass("auto_clear_ch");	
	});
}
  
