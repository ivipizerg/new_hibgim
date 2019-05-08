<?php
          
     define("OXS_PROTECT",TRUE);     

     if($_POST["form"]==1){
          $_POST["oxs_system_ajax_data"]["OXS_AJAX_ROOT"] = $_POST["RP"];
          $_POST["oxs_system_ajax_data"]["Lib"] = $_POST["Lib"];
          $_POST["oxs_system_ajax_data"]["Code"] = $_POST["Code"];
          $_POST["oxs_system_ajax_data"]["SOURCES"] = $_POST["SOURCES"];
          $_POST["oxs_system_ajax_data"]["OXS_TOKEN_NAME"] = $_POST["TN"];
          $_POST["oxs_system_ajax_data"]["OXS_TOKEN"] = $_POST["T"];
     }    

     include("../../oxs_fw.php");
     
     Oxs::Start();   

     Oxs::SetRoot($_POST["oxs_system_ajax_data"]["OXS_AJAX_ROOT"]);  
     $SOURCES = explode( "," , $_POST["oxs_system_ajax_data"]["SOURCES"] );
     Oxs::setSourses(...$SOURCES);

     session_start(); 

     Oxs::L("protector")->CheckToken($_POST["oxs_system_ajax_data"]["OXS_TOKEN_NAME"],$_POST["oxs_system_ajax_data"]["OXS_TOKEN"]);

     $JSON = Oxs::L("JSON");
          
     try{        

          Oxs::G("BD")->Start();          

          if(!empty($_POST["oxs_system_ajax_data"]["Code"]))Oxs::G($_POST["oxs_system_ajax_data"]["Code"])->AjaxExec($_POST["P"]);
          
          Oxs::G($_POST["oxs_system_ajax_data"]["Lib"])->AjaxExec($_POST["P"]);
          $Return = Oxs::G("BD")->GetEnd();        

          $JSON->Add( $Return , "value" );
          $JSON->Add( Oxs::G($_POST["oxs_system_ajax_data"]["Lib"])->GetAjaxCode($_POST["P"]) , "code" );

          $C=Oxs::L("calendar");
          $JSON->Add( "[".$C->GetDataTime()."] Ответ из: ".$_POST["oxs_system_ajax_data"]["Lib"] . "<br>Параметры:".($JSON->GetFromText($_POST["P"]))." <br>Код возврата: ". Oxs::G($_POST["oxs_system_ajax_data"]["Lib"])->GetAjaxCode($_POST["P"]) ."<br>". Oxs::G($_POST["oxs_system_ajax_data"]["Lib"])->GetAjaxText($_POST["P"]) , "logger" ); 
          $JSON->Add( "". Oxs::G($_POST["oxs_system_ajax_data"]["Lib"])->GetAjaxText($_POST["P"]) , "ErrorText" ); 
          $JSON->Add( Oxs::G($_POST["oxs_system_ajax_data"]["Lib"])->GetAjaxData() , "AjaxData" ); 
         
          echo $JSON->GetJSONWithLog();
     }catch(\Throwable $e){     
          Oxs::G("BD")->CloseAll();
          $JSON->Add( -999 , "code" );
          $JSON->Add( "<br>Параметры:".($JSON->GetFromText($_POST["P"]))."<br> 999 Ошибка при выполнении ".$_POST["oxs_system_ajax_data"]["Lib"].": <br> <br> ".$e." <br> <br>"  , "logger" );  
          echo $JSON->GetJSONWithLog();
          return false;
     } catch (\Exception $e) {
          //   php 5
          echo "Хуй2";
          Oxs::G("BD")->CloseAll();          
          $JSON->Add( -998 , "code" );
          $JSON->Add( "<br>Параметры:".($JSON->GetFromText($_POST["P"]))."<br> 998 Ошибка при выполнении ".$_POST["oxs_system_ajax_data"]["Lib"].": <br> <br> ".$e." <br> <br>"  , "logger" );
          echo $JSON->GetJSONWithLog();
          return false;
     }      

     
