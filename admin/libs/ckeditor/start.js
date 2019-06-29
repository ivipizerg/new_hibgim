oxs_ckeditor_start = function(name){
	
	var b = CKEDITOR.replace(name);			
	var flag = false; 
	var _this = this;

	this.updateSize = function(){
		 var top = (jQuery("[name=" + name + "]").next().offset()).top;
	    var pan = jQuery("[name=" + name + "]").next().find("#cke_1_top").outerHeight();
	    var edit_w = jQuery("[name=" + name + "]").next().outerHeight();
	    var wind = jQuery(window).outerHeight();
	    var bott = wind - ( edit_w  + top );
	    flag = true;
	    b.resize( null , bott +  edit_w - 50) ;
	}

	CKEDITOR.on( 'instanceReady', function( evt ) {		 
	  	_this.updateSize();	   
	} );	

	oxs_events.add(window,"resize",function(){		
		_this.updateSize();
	});
}