function oxs_js_oxs_event_item (code_on,code_off,code_string){
	
	var _this=this;	
	
	this.code_on = code_on;
	this.code_off = code_off;
	this.code_string = code_string;
}


function oxs_js_oxs_event_type (obj,Type,_log){
	
	var _this=this;	

	this.Type = Type;	
	this.Obj = obj;	
	this.itemsList = [];

	this._add = function(F){

		for(z=0;z<_this.itemsList.length;z++){
			if(_this.itemsList[z].code_string==F.toString().replace(/\s+/g,'')){
				if(_log) console.log("!!!!дубликат кода  у типа "  + _this.Type + " обьекта " + this.Obj);
				return true;
			}
		}

		return false;
	}

	this.add = function(F){
		if(this._add(F)) return;

		if(_log) console.log(">> добавляю код к типу "  + this.Type);
		
		this.itemsList.push(new oxs_js_oxs_event_item(
		function(){
			$(function(){
				//$(_this.Obj).on(_this.Type,F);
				$(_this.Obj).each(function(e){
					this.addEventListener(_this.Type,F,false);
				});
			});			
		},function(){
			$(function(){
				//$(_this.Obj).off(_this.Type,F);
				$(_this.Obj).each(function(e){
					this.removeEventListener(_this.Type,F);
				});
				
			});		
		},F.toString().replace(/\s+/g,'')));

		this.itemsList[(this.itemsList.length - 1)].code_on();
	}

	/*this.addGlobal = function(F){
		if(this._add(F)) return;

		console.log(">> добавляю глобальный код  к типу "  + this.Type);

		this.itemsList.push(new oxs_js_oxs_event_item(
		function(){
			$("html").on(_this.Type,_this.Obj,F);
		},function(){
			$("html").off(_this.Type,_this.Obj);
		},F.toString().replace(/\s+/g,'')));

		this.itemsList[(this.itemsList.length - 1)].code_on();
	}*/

	this.clear = function(F){
		if(F == undefined){
			//console.log("Очищаю все коды...");		
			for (var key in _this.itemsList) {
				if(_log) console.log("Очищаю и выполняю код обьекта " +  this.Obj + " типа " + this.Type);	
			  	_this.itemsList[key].code_off();
				delete _this.itemsList[key];
			}
		}else{
			for (var key in _this.itemsList) {				
				if(_this.itemsList[key].code_string==F.toString().replace(/\s+/g,'')){
					if(_log) console.log("Очищаю и выполняю код обьекта " +  this.Obj + " типа " + this.Type);	
					_this.itemsList[key].code_off();
					delete _this.itemsList[key];
				}	
			}
		}
	}
}

function oxs_js_oxs_event_obj(Obj,_log){

	var _this=this;	

	this.Obj = Obj;	
	this.typesList = [];

	this._add = function(Type){		
		if(this.typesList[Type]==undefined)
			this.typesList[Type] = new oxs_js_oxs_event_type(Obj,Type,_log);		
	}

	this.add = function(Type,F){

		//console.log(">> добавляю к обьекту " + this.Obj + " тип " + Type);

		this._add(Type,F);
		this.typesList[Type].add(F);
	}

	/*this.addGlobal = function(Type,F){

		//console.log(">> добавляю к глобальному обьекту " + this.Obj + " тип " + Type);

		this._add(Type,F);
		this.typesList[Type].addGlobal(F);
	}*/

	this.clear = function(Type,F){
		
		if(Type == undefined){
			//console.log("Очищаю все типы...");		  	
			for (var key in _this.typesList) {
				if(_log) console.log("Очищаю тип: " + key);		  				  	
			  	_this.typesList[key].clear();
				delete _this.typesList[key];
			}
		}else{
			_this.typesList[Type].clear(F);
			delete _this.typesList[Type];
		}	
	}
}

function oxs_js_oxs_events(_log){	

	var _this=this;

	if( _log == undefined ){
		_log = true;
	}		
	
	this.mobjList = [];

	this._add = function(mObj){
		if(this.mobjList[mObj]==undefined)
			this.mobjList[mObj] = new oxs_js_oxs_event_obj(mObj,_log);
	}

	this.add = function(mObj,Type,F){	

		if(_log) console.log(">> Вешаю событие на обьект " + mObj + " тип " + Type);

		this._add(mObj);		
		this.mobjList[mObj].add(Type,F);
	}

	/*this.addGlobal = function(mObj,Type,F){	

		//console.log(">> Вешаю глобальное событие на обьект " + mObj);

		this._add(mObj);		
		this.mobjList[mObj].addGlobal(Type,F);		
	}*/

	this.clear = function(mObj,Type,F){
		if(mObj==undefined){
			//console.log("Очищаю все обьекты...");		  	
			
			for (var key in _this.mobjList){	
				if(_log) console.log("Очищаю обьект: " + key);		  	
			  	this.mobjList[key].clear();
			  	delete this.mobjList[key];
			}
		}else{
			this.mobjList[mObj].clear(Type,F);
			delete this.mobjList[mObj];
		}
	}
}
