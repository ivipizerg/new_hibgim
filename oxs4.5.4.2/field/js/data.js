oxs_field_js_data = function(name,config){

	eval("\
		$( \"[name=" + name + "]\" ).datepicker(eval({" + crypto_base64.D(config) + "}));\
	");

    jQuery("[name=" + name + "]").change(function(){							
		a = jQuery(this).val();
		jQuery(this).focus();
		jQuery(this).val(a);
	});
}
  
