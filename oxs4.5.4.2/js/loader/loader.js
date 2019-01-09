oxs_js_loader = function(){
     var _this=this;

      oxs_ = function(object,Foo,error_type){
      var Interval;
      var Protector=0;

      if(error_type==undefined){
           error_type=true;
      }

      Interval=setInterval(function(){
           //console.log("try: " + object);
           if(Protector>=20){
              clearTimeout(Interval);
              if(error_type==false)
                  throw new Error("oxs_: не удалось дождаться появления обьекта " + object);
              else
                  console.warn("oxs_: не удалось дождаться появления обьекта " + object);
           }

           if(typeof window[object] != 'undefined'){
                clearTimeout(Interval);
                Foo();
           }else{
                Protector++;
           }
      },20);
  }

}


