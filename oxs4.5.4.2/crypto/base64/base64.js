 oxs_crypto_base64 = function(){

 	var _this = this;

 	this.E = function(text){ 	
	    return btoa(encodeURIComponent(text).replace(/%([0-9A-F]{2})/g,
	        function toSolidBytes(match, p1) {
	            return String.fromCharCode('0x' + p1);
	    }));
 	}

 	this.D = function(base64text){ 		
		return decodeURIComponent(atob(base64text).split('').map(function(c) {
		    return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
		}).join(''));
 	}
 }