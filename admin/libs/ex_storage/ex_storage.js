//	Обьект добавляет к данным ТТЛ, ТТЛ будет уменьшаться каждое обновление страницы
//	И в зависимости от ТТЛ данные будут самоочищаться
//	ТТЛ 0 - переменная живет вечно
//	ТТЛ 1 - перменная перейдет будет очищена при ближайшем переходе
//	ТТЛ 2 - переменная попадет на следующую страницу и прои переходе на третюю будет очищена и туда уже не попадет

function oxs_ex_storage(log){
	var _this = this;
	storage._log = true;

	this.add = function(ParamName,ParamValue,TTL){
		
		if(TTL==undefined){
			TTL = 2
		}

		storage.add(ParamName, { "value" : ParamValue , "TTL" :  TTL } );
	}

	this.get = function(ParamName){
		a = storage.get(ParamName);
		if(a == undefined || ParamName == undefined ) return a;
		return a["value"];
	}

	this.remove = function(ParamName){
		storage.remove(ParamName);
	}

	this.clear = function(){
		storage.remove(clear);
	}

	this.TTLdeciment = function(oxs_Exception){
		for (var item in storage.ParamMass) {	

			flag=false;						

			if( oxs_Exception != undefined ){
				for(i=0;i<oxs_Exception.length;i++){
					console.log(">>>" + oxs_Exception[i]);
					if(oxs_Exception[i] == item["value"] ){
						flag=true;
						break;
					}
				}
			}

			if(flag) continue;

			if(storage.ParamMass[item]["TTL"]==0) continue;
			else{
				storage.ParamMass[item]["TTL"]--;
				if(storage.ParamMass[item]["TTL"]==0){
					storage.remove(item);
				}
			}		    
		}
	}
}