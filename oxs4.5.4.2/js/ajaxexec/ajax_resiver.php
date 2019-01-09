<?php
          
     define("OXS_PROTECT",TRUE);

     session_start();  

     include("../../oxs_fw.php");
     Oxs::SetRoot($_POST["OXS_AJAX_ROOT"]);
     $SOURCES = explode( "," ,  $_POST["SOURCES"]);    

     Oxs::Init(...$SOURCES);

     Oxs::L("protector")->CheckToken();

     $JSON = Oxs::L("JSON");
          
     try{
          Oxs::G("BD")->Start(); 
          if(!empty($_POST["Code"]))Oxs::G($_POST["Code"])->AjaxExec($_POST["P"]);
          
          Oxs::G($_POST["Lib"])->AjaxExec($_POST["P"]);
          $Return = Oxs::G("BD")->GetEnd();

          $JSON->Add( $Return , "value" );
          $JSON->Add( Oxs::G($_POST["Lib"])->GetAjaxCode($_POST["P"]) , "code" );

          $C=Oxs::L("calendar");
          $JSON->Add( "[".$C->GetDataTime()."] Ответ из: ".$_POST["Lib"] . "<br>Параметры:".($JSON->GetFromText($_POST["P"]))." <br>Код возврата: ". Oxs::G($_POST["Lib"])->GetAjaxCode($_POST["P"]) ."<br>". Oxs::G($_POST["Lib"])->GetAjaxText($_POST["P"]) , "logger" ); 
          $JSON->Add( "". Oxs::G($_POST["Lib"])->GetAjaxText($_POST["P"]) , "ErrorText" ); 
          $JSON->Add( Oxs::G($_POST["Lib"])->GetAjaxData() , "AjaxData" ); 
         
          echo $JSON->GetJSONWithLog();
     }catch(Throwable $e){           
          Oxs::G("BD")->CloseAll();
          $JSON->Add( -999 , "code" );
          $JSON->Add( "<br>Параметры:".($JSON->GetFromText($_POST["P"]))."<br> Ошибка при выполнении ".$_POST["Lib"].": <br> <br> ".$e." <br> <br>"  , "logger" );            
          echo $JSON->GetJSONWithLog();
     } catch (Exception $e) {
          //   php 5
           Oxs::G("BD")->CloseAll();          
          $JSON->Add( -998 , "code" );
          $JSON->Add( "<br>Параметры:".($JSON->GetFromText($_POST["P"]))."<br> Ошибка при выполнении ".$_POST["Lib"].": <br> <br> ".$e." <br> <br>"  , "logger" );
          echo $JSON->GetJSONWithLog();
     }      

     
