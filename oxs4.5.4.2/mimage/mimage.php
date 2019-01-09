<?php

if(!defined("OXS_PROTECT"))die("Wrong start point");

class mimage extends MultiLib{

	private $Resourse;

	private $w;
	private $h;

	private $x;
	private $y;

	private $w_original;
	private $h_original;
	private $type;


	//	Параметр random - имя конечных изображений будет ункалным
	//////////////////////////////////////////////
	function __construct($Path){
		parent::__construct($Path);

		if(!extension_loaded("gd")){
			Oxs::error("Не найден gd для работы с изображениями");
		}
	}

	//	Здать путь к изображению с которым будем работтаь
	public function SetImage($Image){
		/*echo "!".$_SERVER["SCRIPT_NAME"]."!";
		echo "!".Oxs::GetBack()."!";
		echo "!".Oxs::GetRoot()."!";*/

		$this->Image=Oxs::GetBack().$Image;

		if(is_file($this->Image)){
			$this->Msg("Файл ".$this->Image." подключен","GOOD");
		}else{
			$this->Msg("Файл ".$this->Image." НЕ подключен","ERROR");
		}

		list($this->w_original, $this->h_original, $this->type) = getimagesize($this->Image);
		$this->w=$this->w_original;
		$this->h=$this->h_original;

		$types = array('','','jpeg','png');
		$ext = $types[$this->type];

		if ($ext) {
				$func = 'imagecreatefrom'.$ext;
				$this->Resourse = $func($this->Image);
				imageAlphaBlending($this->Resourse, false);
				imageSaveAlpha($this->Resourse, true);
				$this->Msg("mimage: Изображение загружено в память","GOOD");
		} else {
				$this->Msg("mimage: Некорректный формат файла","ERROR", 0x1 );
				return 0;
		}
	}


	//	Получить путь изображения с которым работаем
	public function GetPath(){
			return $this->Image;
	}

	public function ResizeW($w){
		$this->Resize($w,0);
	}

	public function ResizeH($h){
		$this->Resize(0,$h);
	}

	//	Вывести преобразованный фай в браузер
	//	!!! Перед вызовом не должно быть не одного тега или символа
	function Show($File=NULL){
		imageAlphaBlending($this->Resourse, false);
				imageSaveAlpha($this->Resourse, true);
		$types = array('','gif','jpeg','png');
		$ext = $types[$this->type];

		header("Content-type: image/".$ext);
		imagepng($this->Resourse);
	}

	//	Сохранить преобразованный файл на диск
	//	Если в пути не указать расширение файла, то будет подставлено
	//	роднео расширение файла
	function Save($Path=NULL){
		if($Path==NULL)$Path=$this->Image;
		else{$Path=Oxs::GetBack().$Path;}

		$Ex=Oxs::GetLib("url")->GetExt($Path);
		if(empty($Ex)){

			$types = array('','gif','jpeg','png');
			$ext = $types[$this->type];
			$Path=$Path.".".$ext;
		}

		imagepng($this->Resourse,$Path);

		if(is_file($Path)){
			$this->Msg("mimage: Файл ".$Path." успешно сохранен","GOOD");
		}else
			$this->Msg("mimage: Файл ".$Path." НЕ сохранен","ERROR");		

	}

	//	Очистка
	function Clean(){
		$this->w=0;
		$this->h=0;
	}

	//	Функция уменьшает изображение так что бы оно влезло
	//	в указанный прямоугольник без транформации размеров
	//	$w и $h ширина и высота прямоугольника
	///////////////////////////////////////////////////////////////
	public function ResizeImage($w,$h){

		if($w <= 0 || $h <= 0 ){
			$this->Msg("Входящие данные не могут быть <= 0 ","ERROR");
			return 0;
		}

		$w_i=imagesx($this->Resourse);
		$h_i=imagesy($this->Resourse);

		//	Вычисляем пропорции что будет меньше то и будем уменьшать
		$w_end=$w_i/$w;
		$h_end=$h_i/$h;

		//	Если пропорция ширины меньше уменьшаемпо высоте
		if($w_end<$h_end){
			$this->ResizeH($h);
		}
		//	иначе рубим по ширине
		else{
			$this->ResizeW($w);
		}
	}


	//	Фунция вырезает максимальный кусок из картиники что бы он влез
	//	в указанный прямоугольник
	//	$w и $h ширина и высота прямоугольника
	//////////////////////////////////////////////////
	public function Eject($w,$h){
		$MaxW=imagesx($this->Resourse);
		$MaxH=imagesy($this->Resourse);

		if($w>$MaxW ){$w=$MaxW;} if($h>$MaxH ){$h=$MaxH;}

		$w_i=$MaxW;
		$h_i=$MaxH;

		//	Вычисляем пропорции что будет меньше то и будем уменьшать
		$w_end=$w_i/$w;
		$h_end=$h_i/$h;

		//	Если пропорция ширины меньше уменьшаемпо высоте
		if($w_end>$h_end){
			$this->ResizeH($h);
			$this->Crop( ($this->w-$w)/2 , 0 , $w,$h);

		}
		//	иначе рубим по ширине
		else{
			$this->ResizeW($w);
			$this->Crop( 0 ,($this->h-$h)/2 ,$w,$h);
		}
	}

	//	Именить размеры картинки с растягиванием
	//	Картинка будет подогнана под указанный размер
	//	недостащие части будут растянуты лишние сжаты
	function Resize($w, $h) {

		if($w < 0 || $h < 0 ){
			$this->Msg("Входящие данные не могут быть <= 0 ","ERROR");
			return 0;
		}

		$this->Clean();

		if (!$h) $h = $w/($this->w_original/$this->h_original);
		if (!$w) $w = $h/($this->h_original/$this->w_original);

		if($w <= 0 || $h <= 0){
			$this->Msg("Ошибка переданных данных","ERROR");
			return 0;
		}

		$this->w=$w;
		$this->h=$h;

		$img_o = imagecreatetruecolor($this->w, $this->h);

		imageAlphaBlending($img_o, false);
		imageSaveAlpha($img_o, true);

		imagecopyresampled( $img_o , $this->Resourse  , 0, 0 , 0 , 0, $this->w, $this->h , $this->w_original , $this->h_original );
		$this->Resourse=$img_o;

	}

	//	Вырезать кусок картинки
	//	x и y это координаты начала вырезки
	//	w и h это ширина и высота вырезаемого куска
	function Crop($x,$y,$w,$h) {

		$this->Clean();

		$MaxW=imagesx($this->Resourse);
		$MaxH=imagesy($this->Resourse);

		if($w>$MaxW ){$w=$MaxW;} if($h>$MaxH ){$h=$MaxH;}

		if($x < 0 || $y < 0 || $w <= 0 || $h <= 0){
			$this->Msg("Ошибка переданных данных","ERROR");
			return 0;
		}

		$img_o = imagecreatetruecolor($w, $h);

		imageAlphaBlending($img_o, false);
		imageSaveAlpha($img_o, true);

		imagecopy($img_o, $this->Resourse, 0, 0, $x, $y, $w, $h);
		$this->Resourse=$img_o;
	}

}


?>
