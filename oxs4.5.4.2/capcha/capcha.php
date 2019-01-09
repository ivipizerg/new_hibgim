<?php
	
	class capcha{
		
		private $Oxs;	
		private $Protector;	
		private $path_to_oxs;	

		function __construct($Oxs,$Param){
			
			$this->Oxs=$Oxs;			
			$this->path_to_oxs=$Param["path_to_oxs"];	
			$this->Protector=1;			

			$T=session_id();
			if(empty($T)) {
				$this->Oxs->AddMessage("Не найдена сессия для хранения капчи создам сам, но возможны проблемы","WARNING,PROTECTORE.WARNING");				
				session_start();
			}
		}

		function GetVersion(){
			$Cfg=$this->Oxs->GetVar("cfg");
			return $Cfg->Get("Version",$this->path_to_oxs."capcha/version.php");
		}		

		function init($Param){			
			return 1;
		}

		private function generate_code(){    
	          
	          $chars = 'abdefhknrstyz23456789'; // Задаем символы, используемые в капче. Разделитель использовать не надо.
	          $length = rand(4, 4); // Задаем длину капчи, в нашем случае - от 4 до 7
	          $numChars = strlen($chars); // Узнаем, сколько у нас задано символов
	          $str = '';
	          for ($i = 0; $i < $length; $i++) {
	            $str .= substr($chars, rand(1, $numChars) - 1, 1);
	          } // Генерируем код

	        // Перемешиваем, на всякий случай
	            $array_mix = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
	            srand ((float)microtime()*1000000);
	            shuffle ($array_mix);
	        // Возвращаем полученный код	         
	        return implode("", $array_mix);
	    }

		function GetCapchaBase64(){

			$T=session_id();
			if(empty($T)) {
				$this->Oxs->AddMessage("Не найдена сессия для токена ".$name." создам сам, но возможны проблемы","WARNING,PROTECTORE.WARNING");				
				session_start();
			}

			$captcha = $this->generate_code();
			$_SESSION['oxs_captcha']=$captcha;			

			// Отправляем браузеру Header'ы
	       /* header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");                   
	        header("Last-Modified: " . gmdate("D, d M Y H:i:s", 10000) . " GMT");
	        header("Cache-Control: no-store, no-cache, must-revalidate");         
	        header("Cache-Control: post-check=0, pre-check=0", false);           
	        header("Pragma: no-cache");       */                                    
	       
	       //header ("Content-type: image/png");
	    	// Количество линий. Обратите внимание, что они накладываться будут дважды (за текстом и на текст). Поставим рандомное значение, от 3 до 7.
	        $linenum =4; 
	    
	    	// Шрифты для капчи. Задавать можно сколько угодно, они будут выбираться случайно
	        $font_arr = array();
	            $font_arr[0]["fname"] = "DroidSans.ttf";	// Имя шрифта. Я выбрал Droid Sans, он тонкий, плохо выделяется среди линий.
	            $font_arr[0]["size"] = rand(20, 30);				// Размер в pt
	    	// Генерируем "подстилку" для капчи со случайным фоном
	       
	        $im = imagecreate (120,40); 
	    	// Рисуем линии на подстилке
	        for ($i=0; $i<$linenum; $i++)
	        {
	            $color = imagecolorallocate($im, 250, 250, 250); // Случайный цвет c изображения
	            imageline($im, rand(0, 20), rand(1, 50), rand(150, 180), rand(1, 50), $color);
	        }
	       
	        $color = imagecolorallocate($im, rand(0, 200), 0, rand(0, 200)); // Опять случайный цвет. Уже для текста.

	        // Накладываем текст капчи				
	        $x = rand(0, 35);        
	       
	        imagettftext ($im, rand(20, 24), rand(2, 4), $x, rand(24, 34), $color, $this->path_to_oxs."/capcha/DroidSans.ttf", $captcha);
	        

	    	// Опять линии, уже сверху текста
	        for ($i=0; $i<$linenum; $i++)
	        {
	            $color = imagecolorallocate($im, rand(0, 255), rand(0, 200), rand(0, 255));
	            imageline($im, rand(0, 20), rand(1, 50), rand(150, 180), rand(1, 50), $color);
	        }

	        ob_start();
			ImagePNG ($im);	
			ImageDestroy ($im);
			$imagedata = ob_get_contents();
			ob_end_clean();
			return 	"data:image/png;base64,".base64_encode($imagedata);
			
	        
		}

		function GetCapchaImg(){			
			$R=$this->GetCapchaBase64();
			return "<img src=\"data:image/png;base64,".$R."\">";	
		}

		function GetCapchaImgAjax(){
			$D=$this->Oxs->GetLib("doc",NULL,"OXS_SYSTEM_DOC");
			$D->jQuery();
			$R=$this->GetCapchaBase64();
			$id="oxs_capcha_id_".time();

			$Pro=$this->Oxs->LoadLib("protector");
			$Pro->SetToken("oxs_capcha_protector");			
			?>
			<script>
			jQuery(function(){
				jQuery('.<?php echo $id; ?>').click(function(){
					
					jQuery.ajax({
						url: "<?php echo $this->path_to_oxs;?>/capcha/capcha_ajax.php",	
						async: false,				
						data: { protect: "<?php echo $Pro->GetToken("oxs_capcha_protector");?>" , sSID: "<?php echo session_id();?>" },			
						type: "POST",		

						success:  function (data){				
							jQuery('.<?php echo $id?>').attr('src',data);
						}
					});

				});
			});
			</script>

			<?php
			echo "<img style=\"cursor:pointer;\" class=".$id." src=\"".$R."\">";	
		}

		function GetCapcha(){
			return $_SESSION['oxs_captcha'];
		}

		function ConfirmCapcha($Capcha){
			if($Capcha==$_SESSION['oxs_captcha']) return 1;
			else return 0;
		}
	}		
?>