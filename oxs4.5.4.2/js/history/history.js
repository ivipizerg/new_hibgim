
function oxs_js_history(){

    var _this = this;
    this.codes = new Array();  
    this.CurrentID=0;  
   
    this.GoTo = function(code,name,replace){

        if(replace==undefined) replace = false;        
    
        if(!replace){ 
            _this.CurrentID++;
            console.log("Переход по истории:" + code + name);          
            _this.codes[_this.CurrentID]=code;   
            history.pushState( _this.CurrentID , name , name); 
            _this.codes[_this.CurrentID]();
        }
        else{       
            console.log("Перезапись истории:" + code + name);      
            _this.codes[_this.CurrentID]=code; 
            history.replaceState( _this.CurrentID , name , name);       
            _this.codes[_this.CurrentID]();            
        }  
    }

     this.Add = function(code,name,replace){
        if(replace==undefined) replace = false;        
    
        if(!replace){ 
            _this.CurrentID++;
            console.log("Доабвление записи в историю:" + code + name);          
            _this.codes[_this.CurrentID]=code;   
            history.pushState( _this.CurrentID , name , name); 
        }
        else{       
            console.log("Перезапись записи в итсории:" + code + name);      
            _this.codes[_this.CurrentID]=code; 
            history.replaceState( _this.CurrentID , name , name);
        }  
    }

    this.GoCurrent = function(){
        _this.codes[_this.CurrentID]();   
    }   

    window.addEventListener('popstate', function(e){      

        console.log("popstate " + _this.codes[e.state]); 

        if(_this.codes[e.state]!=undefined)_this.codes[e.state]();
        else window.history.back();       
        
    });
}
