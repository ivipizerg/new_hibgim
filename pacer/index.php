<?php

function separator($z = 5){
	for($i=0;$i<$z;$i++){
		echo "&nbsp;";
	}
}

include "../oxs4.5.4.2/oxs_fw.php";

Oxs::Start();
Oxs::SetRoot("hibgim/");
Oxs::setSourses("oxs4.5.4.2/","core/","admin/core/","pacer/lib/","admin/blocks/");
echo Oxs::G("dom")->ShowBase();
Oxs::G("js.ajaxexec")->GetObject("aj" , array( "log" => "on" , "start_code" => "application_front") );

//	Получаем не добавленный id новости
Oxs::G("DBLIB.IDE")->Init("cfg.php");
$R = Oxs::G("DBLIB.IDE")->DB()->Exec("SELECT * FROM `#__news_front` WHERE `added` = '0' ORDER BY `position` ASC");

echo "id:<span class=oxs_id>".$R[0]["id"]."</span> Позиция:<span class=oxs_position>".$R[0]["position"]."</span> Дата создания:<span class=oxs_create_data>" .$R[0]["create_data"]. "</span> Дата обновления: <span class=oxs_update_data>" . $R[0]["update_data"]."</span><br><br>"	;
echo "Название:<span class=oxs_name>".$R[0]["name"]."</span><br><br>";

echo "Короткий текст:".htmlspecialchars ($R[0]["short_text"])."<br><br>";
echo "<span style='display:none;' class=oxs_text_short>".$R[0]["short_text"]."</span>";


echo "Текст:".htmlspecialchars($R[0]["text"])."<br>";
echo "<span style='display:none;' class=oxs_text>".$R[0]["text"]."</span>";

echo "Счетчик:<span class=oxs_count>".$R[0]["count"]."</span><br>";

echo $R[0]["file"];

if(!empty($R[0]["file"])){
	if(Oxs::G("file")->isExist("files1/".$R[0]["file"])){
		echo separator(10)."Файл найден: "."<span class=oxs_mini_img style='color:green;'>".$R[0]["file"]."</span><br>";
	}else{
		echo "<span style='color:red;'>".separator(10)."Файл НЕ НАЙДЕН: ".$R[0]["file"]."</span><br>";
	}
}

//	Посмотрим нет ли картинки в коротком тексте
preg_match_all( "(<img.*?>)", $R[0]["short_text"] , $M );
if(count($M[0])>=1){
	echo "Есть изображение в короткой новости<br>";
	echo htmlspecialchars($M[0][0])."<br>";

	preg_match_all( "(src=.*?>)", $M[0][0] , $INNER );

	$filePath = rtrim($INNER[0][0],">");
	$filePath = ltrim($filePath,"src=");
	$filePath = trim($filePath,"\"");
	$filePath = ltrim($filePath,"admin/");
	$filePath = ltrim($filePath,"files/");

	preg_match_all( "(.*?(jpg|JPG|png|PNG))", $filePath  , $z );
	$filePath = $z[0][0];

	//print_r($z);

	$filePath = trim($filePath);
	$filePath = trim($filePath,"\"");

	echo $filePath;

	//	Смотрим есть ли файл на месте
	if(Oxs::G("file")->isExist("files1/".$filePath)){
		echo "Файл найден: ".separator(10)."<span class=oxs_mini_img  style='color:green;'>".$filePath."</span><br>";
	}else{
		echo "<span style='color:red;'>".separator(10)."Файл НЕ НАЙДЕН: ".$filePath."</span><br>";
	}

}

echo "<hr>";

//	Ищем изображения
////////////////////////////////////////////////////////////////////////
preg_match_all( "(<img.*?>)", $R[0]["text"] , $M );

echo "Найдено изображений:".count($M[0])."<br>";

if(count($M[0])>=1){
	for($i=0;$i<count($M[0]);$i++){

		echo ($i+1)." ".htmlspecialchars($M[0][$i])."<br>";

		preg_match_all( "(src=.*?>)", $M[0][$i] , $INNER );

		$filePath = rtrim($INNER[0][0],">");
		$filePath = ltrim($filePath,"src=");
		$filePath = trim($filePath,"\"");
		$filePath = ltrim($filePath,"admin/");
		$filePath = ltrim($filePath,"files/");

		preg_match_all( "(.*?(jpg|JPG|png|PNG))", $filePath  , $z );
		$filePath = $z[0][0];

		//print_r($z);

		$filePath = trim($filePath);
		$filePath = trim($filePath,"\"");

		//echo $filePath;

		$filePath = trim($filePath);
		$attr="";
		$attr = str_replace($INNER[0][0],"",$M[0][$i]);
		$attr = ltrim($attr,"<img");
		$attr = rtrim($attr,">");
		$attr = trim($attr);

		//	Смотрим есть ли файл на месте
		if(Oxs::G("file")->isExist("files1/".$filePath)){
			echo "Файл найден: ".separator(10)."<span class=oxs_img_files oxs_img_attr='".$attr."' oxs_img_src='".$INNER[0][0]."' oxs_img_tag='".$M[0][$i]."' style='color:green;'>".$filePath."</span><br>";
		}else{
			echo "<span style='color:red;'>".separator(10)."Файл НЕ НАЙДЕН: ".$filePath."</span><br>";
		}

		if(!empty($attr)){
			echo separator(10)."Атрибуты: ".$attr."</span><br>";
		}else{
			echo separator(10)."Атрибуты: пусто<br>";
		}

	}
}
/////////////////////////////////////////////////////////////////////////////

//	Ищем документы

echo "<div class=oxs_console style='border:1px solid red;'></div>";
?>
	<br><center>
		<select class=oxs_cat>
			<option value=2>Новости школы</option>
			<option value=3>Новости спорта</option>
			<option value=4>Новости культуры</option>
			<option value=5>Новости науки</option>
		</select><button class="oxs_send_data" >Отпарвить</button></center>

	<script type="text/javascript">
		$(function(){
			$(".oxs_send_data").click(function(){

				//	Собираем данные
				var data = {};
				data.oxs_name = $(".oxs_name").text();
				data.oxs_id = $(".oxs_id").text();
				data.oxs_position = $(".oxs_position").text();
				data.oxs_create_data = $(".oxs_create_data").text();
				data.oxs_update_data = $(".oxs_update_data").text();
				data.oxs_count = $(".oxs_count").text();
				data.oxs_mini_img = $(".oxs_mini_img").text();
				//data.oxs_text = $(".oxs_text").html();
				//data.oxs_text_short = $(".oxs_text_short").html();
				data.oxs_cat =  $(".oxs_cat").val();
				data.img=[];

				$(".oxs_img_files").each(function(){
					var x = {};
					x.file = $(this).text();
					x.oxs_img_src = $(this).attr("oxs_img_src");
					x.oxs_img_tag = $(this).attr("oxs_img_tag");
					x.oxs_img_attr = $(this).attr("oxs_img_attr");
					data.img.push(x);
				});

				aj.Exec("site",data,function(I){
					$(".oxs_console").html(I.Msg);
				});
			});
		});
	</script>
<?php
Oxs::ShowLog();
