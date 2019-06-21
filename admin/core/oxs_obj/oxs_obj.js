oxs_oxs_obj = function(_log){
     var _this = this;  
     
     this.ObjList = new Array();
     this.i=0;

     this.add = function(ObjName){
          if(_log) console.log("oxs_obj: Добавляю обьект: " + ObjName);
          this.ObjList[this.i] = ObjName;
          this.i++;
     }
     
     this.clear = function(){
        
          if(_log)  console.log("Чищу обьекты...");
          
          for(var j = 0; j < this.i; j++ ){
               console.log("Удаляю обьект " + this.ObjList[j]);
               
               //   Вызовем деструктор если о несть и удалим обьект
               try{
                    window[this.ObjList[j]].des();
               }catch(err){

               }
              
               window[this.ObjList[j]]=undefined;
               delete window[this.ObjList[j]];               
          }

          this.i=0;
     }     
}