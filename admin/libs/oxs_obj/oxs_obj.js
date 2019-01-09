oxs_oxs_obj = function(){
     var _this = this;      

     this.ObjList = new Array();
     this.i=0;

     this.add = function(ObjName){
          console.log("oxs_obj: Добавляю обьект: " + ObjName);
          this.ObjList[this.i] = ObjName;
          this.i++;
     }
     
     this.clear = function(){
        
          console.log("Чищу обьекты...");
          
          for(var j = 0; j < this.i; j++ ){
               console.log("Удаляю обьект " + this.ObjList[j]);
               //eval("try{"+this.ObjList[j] + ".Destruct();} catch(err){}");
               eval(" delete " + this.ObjList[j]);
          }

           this.i=0;
     }     
}