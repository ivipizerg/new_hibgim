<?php

	if(!defined("OXS_PROTECT"))die("protect");

	class message_window extends CoreSingleLib{			

		function __construct($_Path,$Params=null){		
			parent::__construct($_Path,$Params);			
		}

		function Error($Text){
			return "<ul class='oxs_logger_ul_style_error'><li>".$Text."</li></ul>";			
		}

		function Good($Text){
			return "<ul class='oxs_logger_ul_style_good'><li>".$Text."</li></ul>";			
		}

		function Info($Text){
			return "<ul class='oxs_logger_ul_style_info'><li>".$Text."</li></ul>";			
		}

		function ErrorUL($Chanel){	
			return Oxs::G("logger")->GetUl( $Chanel , null , array( "ul_class" => "oxs_logger_ul_style_error" ) )  ;
		}

		function GoodUL($Chanel){	
			return Oxs::G("logger")->GetUl( $Chanel , null , array( "ul_class" => "oxs_logger_ul_style_good" ) )  ;
		}

		function InfoUL($Chanel){	
			return Oxs::G("logger")->GetUl( $Chanel , null , array( "ul_class" => "oxs_logger_ul_style_info" ) )  ;
		}
		
		function Init(){				

			//	Создадим окошко дял вывода ошибочек
			Oxs::G("js.window")->GetObject("message_window");

			?>

				<script type="text/javascript">
					
					jQuery(function(){

						_oxs_message = function(){
							
							var _this = this;	

							message_window.stick("right","bottom");
							message_window.hide();
							message_window.addClass("message_window");
							message_window.static();
					

							this.timeout_id;
							this.count=0;

							jQuery("html").on("mouseover",".message_window",function(){	
								if(_this.loadinstatus != 1)							
									clearInterval(_this.timeout_id);
							});

							jQuery("html").on("mouseout",".message_window",function(){	
								if(_this.loadinstatus != 1)															
									_this.timeout_id = setInterval(_this.Iteration,1000);
							});

							this.IterationBlink = function(){
								_this.ii++;
								//if(_this.ii%2==0)
									//jQuery(".oxs_message_window_counter").css("background-color","#eee");
								//else
									//jQuery(".oxs_message_window_counter").css("background-color","white");
							}

							this.Iteration = function(){
								_this.count--;
								
								//jQuery(".oxs_message_window_counter").html(_this.count);
								
								if(_this.count==1){
									clearInterval(_this.timeout_id);
									message_window.w.stop().hide();
								}					
							}

							this.show = function(Text){																						
								message_window.w.stop().show();
								message_window.set("<div class=oxs_message_window_text>" + Text + "</div>" + "<div class=oxs_message_window_counter></div>");
								_this.count=10;
								
								//jQuery(".oxs_message_window_counter").html(_this.count);

								clearInterval(_this.timeout_id);
								_this.timeout_id = setInterval(_this.Iteration,1000);
							}


							this.Loading = function(Text){	

								//console.log("!!!START");

								if(Text!=undefined){
									message_window.w.stop().show();
									message_window.set("<div class=oxs_message_window_text>" + Text + "</div>" + "<div class=oxs_message_window_counter></div>");
									_this.loadinstatus = 1;
									return ;
								}	

								_this.loadinstatus = 1;
								
								_this.i=0;
								_this.ii=0;	

								var l = new Array();
								l[0] = "<?php echo Oxs::G("languagemanager")->T("loading1");?>";
								l[1] = "<?php echo Oxs::G("languagemanager")->T("loading2");?>";
								l[2] = "<?php echo Oxs::G("languagemanager")->T("loading3");?>";
								l[3] = "<?php echo Oxs::G("languagemanager")->T("loading4");?>";
								
								message_window.w.stop().show();
								message_window.set("<div class=oxs_message_window_text>" + l[0] + "</div>" + "<div class=oxs_message_window_counter></div>");

								clearInterval(_this.LoadingInterval);

								_this.LoadingInterval = setInterval(function(){
									jQuery(".oxs_message_window_text").html(l[_this.i]);	
									_this.i++;
									if(_this.i==4)_this.i=0;
								},300);

								_this.timeout_id_blink = setInterval(_this.IterationBlink,300);

								return ;
							}

							this.LoadingStop = function(){								

								//console.log("!!!STOP");

								clearInterval(_this.LoadingInterval);
								clearInterval(_this.timeout_id_blink);
								
								message_window.w.stop().hide();

								_this.loadinstatus = 0;
								return ;
							}
						}

						oxs_message = new _oxs_message();	
											
					});
					
				</script>

			<?php
		}
		
	}

?>
