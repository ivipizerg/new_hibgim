oxs_JSON_json = function(){
	
	this.E = function(o_JSON){
		return JSON.stringify(o_JSON);
	}

	this.D = function(text){
		return JSON.parse(text);
	}
}