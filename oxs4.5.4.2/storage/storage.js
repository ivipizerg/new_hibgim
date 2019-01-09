function oxs_storage(__log){	

	var _this=this;
	this._log = __log;
	if(this._log==undefined) this._log = true;
		
	this.ParamMass={};

	//	Добавить паарметры дял передачи в выполянемый код
 	this.AddParam = function(ParamName,ParamValue){  	 	
 		if(this._log){
 			console.log("Добавляю данные в хранилище: " + ParamName);		
 			console.log("Значение данных: ");	
 			console.log(ParamValue);		
 		}
 		
 		_this.ParamMass[ParamName] = ParamValue; 		
 	}

 	this.getParam = function(ParamName){

 		if(this._log){
 			console.log("Получаю данные из хранилища: " + ParamName);
 			console.log("Значение данных:" );
 			if(ParamName==undefined) console.log( _this.ParamMass);
 			else console.log( _this.ParamMass[ParamName]); 					
 		}

 		if(ParamName==undefined) return _this.ParamMass;
 		return _this.ParamMass[ParamName];
 	}

 	//	Добавить паарметры дял передачи в выполянемый код
 	this.add = function(ParamName,ParamValue){ 		
 		_this.AddParam(ParamName,ParamValue);	
 	}

 	this.get = function(ParamName){ 		
 		return _this.getParam(ParamName);	
 	}

 	this.clear = function(){
 		if(this._log){
 			console.log("Очищаю хранилище"); 			
 		}
 		_this.ParamMass={};
 	}

 	this.remove = function(ParamName){

 		if(this._log){
 			console.log("Удаляю данные из хранилища: " + ParamName); 			
 		}

 		return delete _this.ParamMass[ParamName];
 	}	
}
