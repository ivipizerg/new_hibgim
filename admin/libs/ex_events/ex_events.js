function oxs_ex_events(){

	var _this=this;	

	this.blocksObjectList = [];		

	this.add = function(Obj,Type,F,block){		

		if(block==undefined){
			block = storage.get("block_name") + ":" + storage.get("block_action");
		}

		console.log(">>Вешаю событие на " + Obj + " Тип:" + Type + " Блок:" + block);

		if(block==undefined) return;

		if(this.blocksObjectList[block]==undefined){
			this.blocksObjectList[block] = new oxs_js_oxs_events();
		}
		
		this.blocksObjectList[block].add(Obj,Type,F);		
	}

	/*this.addGlobal = function(Obj,Type,F,block){		

		if(block==undefined){
			block = storage.get("block_name") + ":" + storage.get("block_action");
		}

		//console.log(">>Вешаю глобальное событие на " + Obj + " Тип:" + Type + " Блок:" + block);

		if(block==undefined) return;

		if(this.blocksObjectList[block]==undefined){
			this.blocksObjectList[block] = new oxs_js_oxs_events();
		}
		
		this.blocksObjectList[block].addGlobal(Obj,Type,F);		
	}*/

	this.clear = function(block,Obj,Type,F){	

		console.log(Object.keys(_this.blocksObjectList));
		console.log(Object.keys(_this.blocksObjectList).length);

		if(Object.keys(_this.blocksObjectList).length==0) return ;

		if(block==undefined){
			//console.log("<<<Очищаю все блоки");		  	
			for (var key in _this.blocksObjectList){					
				console.log("Очищаю блок: " + key);		  	
				_this.blocksObjectList[key].clear();
				delete _this.blocksObjectList[key];				
			}
		}else{
			_this.objList[block].clear(Obj,Type,F);
			delete _this.objList[block];
		}		
	}
}
 