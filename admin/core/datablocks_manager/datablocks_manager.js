oxs_datablocks_manager = function(){

     var _this = this; 

     var _lastBlock = "";
     var _lastURL = "";     

     //   no_calcel_message - не убирать сообщение, нужн оесли вы делаете редирект на другой блок
     //   а сообщенеи с предыдущего вам убирать не нужно
     //   replace - перехзаписать текущюу ссылку
     this._ExecBlock = function(Block,Param,URL,replace,no_calcel_message){ 

          console.log(Block,Param,URL);

          _this._lastBlock = Block;
          _this._lastURL = URL;

          if(replace==undefined) replace = false;
          if(no_calcel_message==undefined) no_calcel_message = false;

          function Foo(Msg,Code,Text,Data){  

               console.log("Дата пришла");
               console.log(Data);

               if(!no_calcel_message) oxs_message.LoadingStop();               
               
               //   -1 Вывод информации без перехода
               if(Code==-1){                               
                    oxs_message.show(Text);                   
               //   1 - вывод информаци ис переходом   
               }else if(Code==1){                    
                    if(Text!="undefined" && Text!="")
                         oxs_message.show(Text); 
                    _this._ExecBlock( Data["nextStep"] , Param , "admin/" + Data["nextStep"] + ".html" , false ,true);                     
               //   Диалог
               }else if(Code==2){                                            
                     jQuery(".oxs_main_container_dialog").append(  Data["dialog"] );  
               }else{                    
                    H.GoTo(function(){                           
                         
                         console.log("Clearing data... ");     
                        
                         //   Очищаем все события
                         oxs_events.clear();  
                         //   Очищаем все подгруженные обьекты
                         oxs_obj.clear();
                         //   Уменьшаем TTL жизни обьектов в хранилище
                         ex_storage.TTLdeciment();

                         ex_storage.add("block_name",Data["block_name"]);
                         ex_storage.add("block_action",Data["block_action"]);                           
                                                
                         jQuery(".container_for_load_content").html(Msg);  
                             
                         //   Шлем событие ресайза
                         //   Обычным Jquery Оно не шлеться
                         window.dispatchEvent(new Event('resize'));                     

                         if(Code == 3){
                              if(Text!="undefined" && Text!="")
                              oxs_message.show(Text); 
                         } 
                         
                    }, URL  );                  
               }
          } 

          if(!no_calcel_message) oxs_message.Loading();          

          //   Включаем Вывод лога
          aj_auth.Exec( "datablocks_manager:ajax" ,  { block: Block , param:Param }  , Foo );
     } 

     this.ExecBlock = function(Block,Param,URL,replace){            
          _this._ExecBlock(Block,Param,URL,replace);
     }
}