function oxs_js_codebox(log){	

	var _this = this;

 	this.ParamMass={};
 	this.Code = {}; 	
 	this.Tags = [];
 	this.Chanels = [];

 	this.ClearParams = function(){
 		_this.ParamMass={};
 	}

 	this.renameTag = function(Chanel,OldTag,NewTag){
 		if(Chanel==undefined) Chanel = "default";	
 		_this.Code[Chanel][OldTag] = _this.Code[Chanel][NewTag];		
 	}

 	//	Добавить паарметры дял передачи в выполянемый код
 	this.AddParam = function(ParamName,ParamValue){ 		
 		_this.ParamMass[ParamName] = ParamValue; 		
 	}

 	//	Доабвить код для выполнения
 	this.AddCode = function(Code,Chanel,Tag){ 
 		
 		var ifChanelExist = false;
 		var ifTagExist = false;

 		if(Chanel==undefined) Chanel = "default";	
 		if(Tag==undefined) Tag = "default";
 			
 		//	Ищем есть ли уже такой кана лв массиве каналов
 		for (var i=0; i<=(_this.Chanels.length-1); i++) {		
		    if(_this.Chanels[i]==Chanel){
		    	ifChanelExist = true;
		    	break;
		    }
		}

		//	Если канал не наден создаем его
		//	и созадем массив 
		if(!ifChanelExist){
			_this.Chanels.push(Chanel);
			_this.Tags[Chanel] = new Array();
			_this.Code[Chanel] = new Array();
		}
		//////////////////////////////////////////////////

		//	ПРоверяем есть л ив этом канале такой же тег
		for (var i=0; i<=(_this.Tags[Chanel].length-1); i++) {		
		    if(_this.Tags[Chanel][i]==Tag){
		    	ifTagExist = true;
		    	break;
		    }
		}

		if(!ifTagExist){
			//	Добавляем тэг
			_this.Tags[Chanel].push(Tag);
		}
		
 		_this.Code[Chanel][Tag]=Code;
 		return ;
 	} 		
	
	this.ExecCode = function(Data,Chanel,Tag){			

		if(Chanel==undefined) Chanel = "default";	
 		if(Tag==undefined) Tag = "all";

		for (var i=0; i<=(_this.Chanels.length-1); i++) {
			if(Chanel==_this.Chanels[i]){
				console.log("Выполняю канал " + Chanel);

				if(Tag!="all"){
					for (var j=(_this.Tags[_this.Chanels[i]].length-1); j>=0; j--) {
						 if(_this.Tags[_this.Chanels[i]][j] == Tag){
						 	 console.log("Выполняю Tag " + _this.Tags[_this.Chanels[i]][j]);
							_this.Code[_this.Chanels[i]][_this.Tags[_this.Chanels[i]][j]](Data);
						 }
					}
					return ;
				}
				
				for (var j=(_this.Tags[_this.Chanels[i]].length-1); j>=0; j--) {
					 console.log("Выполняю Tag " + _this.Tags[_this.Chanels[i]][j]);
					_this.Code[_this.Chanels[i]][_this.Tags[_this.Chanels[i]][j]](Data);
				}		

				break;		
			}
		}		
	}	
}
