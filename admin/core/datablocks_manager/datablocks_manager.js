oxs_datablocks_manager = function(){

     var _this = this; 

     var _lastBlock = "";
     var _lastURL = "";     

     //   no_calcel_message - не убирать сообщение, нужн оесли вы делаете редирект на другой блок
     //   а сообщенеи с предыдущего вам убирать не нужно
     //   replace - перехзаписать текущюу ссылку
     this._ExecBlock = function(Block,Param,URL,replace,no_calcel_message){ 

          console.log("Запрос на сервер...");
          console.log("Блок: " + Block);
          console.log(Param);
          console.log("URL:" + URL);

          _this._lastBlock = Block;
          _this._lastURL = URL;

          if(replace==undefined) replace = false;
          if(no_calcel_message==undefined) no_calcel_message = false;

          //   Msg , Code , Text , Data , log_item
          function Foo(Input){  

               console.log("В ответе есть массив Data");
               console.log(Input.Data);

               if(!no_calcel_message) oxs_message.LoadingStop();               
               
               //   Ошбика PHP
               if(Input.Code==-1000){
                    oxs_message.show(Input.Msg);          
               }else
               if(Input.Code==-999){
                    oxs_message.show(Input.Msg);          
               }else               
               //   -1 Вывод информации без перехода
               if(Input.Code==-1){                               
                    oxs_message.show(Input.Text);                   
               //   1 - вывод информаци ис переходом   
               }else if(Input.Code==1){                    
                    if(Input.Text!="undefined" && Input.Text!="")
                         oxs_message.show(Input.Text); 
                    _this._ExecBlock( Input.Data["nextStep"] , Param , "admin/" + Input.Data["nextStep"] + ".html" , false ,true);                     
               //   Диалог
               }else if(Input.Code==2){ 
                     jQuery(".oxs_main_container_dialog").html( Input.Data["dialog"] );  
               }else{                    
                    H.GoTo(function(){                           
                         
                         console.log("Очищаю все ресурсы блока...");     
                        
                         //   Очищаем все события
                         js_oxs_events.clear();
                         oxs_events.clear();  
                         //   Очищаем все подгруженные обьекты
                         oxs_obj.clear();
                         //   Уменьшаем TTL жизни обьектов в хранилище
                         ex_storage.TTLdeciment();
                         //   Очищаем коды черного жкрана
                         oxs_black_screen.removeCode();

                         if(Input.Data!=undefined)ex_storage.add("block_name",Input.Data["block_name"]);
                         if(Input.Data!=undefined)ex_storage.add("block_action",Input.Data["block_action"]);                           
                                                
                         jQuery(".container_for_load_content").html(Input.Msg);  
                             
                         //   Шлем событие ресайза
                         //   Обычным Jquery Оно не шлеться
                         window.dispatchEvent(new Event('resize'));                     

                         if(Input.Code == 3){
                              if(Input.Text!="undefined" && Input.Text!="")
                              oxs_message.show(Input.Text); 
                         } 
                         
                    }, URL  );                  
               }
          } 

          if(!no_calcel_message) oxs_message.Loading();  
         
          aj_auth.Exec( "datablocks_manager:ajax" ,  { block: Block , param:Param }  , Foo );
     } 

     this.ExecBlock = function(Block,Param,URL,replace){            
          _this._ExecBlock(Block,Param,URL,replace);
     }
}