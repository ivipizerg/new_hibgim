oxs_field_autoclear = function(Name,text,ch_class,Value){          

     var _this = this;   

     if(jQuery("[name=" + Name +"]").attr("type")=="password"){
          jQuery("[name=" + Name +"]").attr("type","text");          
          jQuery("[name=" + Name +"]").attr("type_ch","true");
     }
     
     jQuery("[name=" + Name +"]").addClass(ch_class);

     jQuery("[name=" + Name +"]").val(text);

     js_oxs_events.clear("[name=" + Name +"]","focus");
     js_oxs_events.add("[name=" + Name +"]","focus",function(){         

          if(jQuery("[name=" + Name +"]").attr("type_ch")=="true"){
               jQuery("[name=" + Name +"]").attr("type","password");                   
               jQuery("[name=" + Name +"]").attr("type_ch","false");
          }       

          if(jQuery("[name=" + Name +"]").hasClass(ch_class)){
               jQuery(this).val("");
               jQuery("[name=" + Name +"]").removeClass(ch_class);  
          }         
     });
     
     js_oxs_events.clear("[name=" + Name +"]","blur");
     js_oxs_events.add("[name=" + Name +"]","blur", function(){
          if(jQuery(this).val()==""){

               if(jQuery("[name=" + Name +"]").attr("type")=="password"){
                    jQuery("[name=" + Name +"]").attr("type","text");                                       
                    jQuery("[name=" + Name +"]").attr("type_ch","true");
               }

               jQuery("[name=" + Name +"]").addClass(ch_class); 

               jQuery("[name=" + Name +"]").val(text);
          }        
     });

     if(Value!=undefined && Value!=""){         
          jQuery("[name=" + Name +"]").val(Value);
          jQuery("[name=" + Name +"]").removeClass(ch_class);  
     }    
}

