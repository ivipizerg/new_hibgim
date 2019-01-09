oxs_js_link = function(link_class){

	var _this = this;

	this.UserClick = function(e){
		return true;
	}

	this.Bind = function(link_cla){
		jQuery("html").on("click","." + link_cla,function(){
			if(_this.UserClick(this))location.href = jQuery("." + link_cla).attr("data-href");
		});
	}

	this.Bind(link_class);
}
