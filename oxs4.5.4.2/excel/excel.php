<?php

if(!defined("OXS_PROTECT"))die("Wrong start point");

class excel extends MultiLib{

	private $objPHPExcel;
	private $NameToDrop; 
	private $xls;

	function __construct($Path){	

		//	Подключаем PHPexcel
		include_once( Oxs::GetBack(). $Path . "excel/PHPExcel-1.8/Classes/PHPExcel.php");
		$this->objPHPExcel = new PHPExcel();
		parent::__construct($Path);
	}

	function Open($FileName){

		$this->Msg("Открываю файл ".$FileName,"MESSAGE");		

		include_once( Oxs::GetBack(). $this->Path . "excel/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php");		

		// Открываем файл		
		$this->xls = PHPExcel_IOFactory::load( Oxs::GetBack().$FileName );

		if(Oxs::G("file")->CheckFile($FileName)){
			$this->Msg("Успех ".$FileName,"GOOD");
		}else{
			$this->Msg("Не удалось открыть файл ".$FileName,"ERROR");
		}	

		return Oxs::G("file")->CheckFile($FileName);
	}

	function Close(){
		unset($this->xls);
	}

	function IfSheetExist($SheetName){
		
		try{
			$this->xls->setActiveSheetIndexByName($SheetName);
		}catch(Exception  $e){			
			return 0;
		}

		return 1;
	}

	function GetSheetNames(){
		return $this->xls->getSheetNames();
	}

	function getSheetCount(){		
		return   $this->xls->getSheetCount();
	}

	function GetPhpExcel(){
		return $this->objPHPExcel;
	}

	function GetNameToDrop(){
		return $this->NameToDrop;
	}

	//	Бросает файл в браузер через открытие новой вкладки
	//	Не влияет на текущее состояние страницы
	function DropInBrowser($FileName=NULL){

		if($FileName==NULL){
			$this->Msg("Не указано имя файла","ERROR");
			return 0;
		}else{
			$this->NameToDrop = $FileName;
		}

		//	Создание защиты
		$P = Oxs::LoadLib("protector");
		$P->SetToken("excel_drop_in_browser");

		//	Подготавливаем данные для передачи
		$_SESSION["obj"] = serialize($this);
		$_SESSION["root"] = Oxs::GetRoot();	
		$_SESSION["token"] = $P->GetToken("excel_drop_in_browser");;	

		?>
		<script type="text/javascript">
			jQuery(function(){
				window.open('oxs/excel/DropInBrowser.php', '_blank');
			});
		</script>
		<?php		
	}

	function Save($Name){
		$objWriter = new PHPExcel_Writer_Excel2007($this->objPHPExcel);
		$objWriter->save( Oxs::GetBack() . $Name );
	}

	function Parse($sheet=1){		

		$this->Msg("Приступаю к парсингу файла " . $FileName,"MESSAGE");
		
		// Устанавливаем индекс активного листа
		try{
			$this->xls->setActiveSheetIndexByName($sheet);
		}catch(Exception  $e){			
			return $this->Msg("Не найдена вкладка \"".$sheet."\" в переданном файле ексель","ERROR");
		}
		
		// Получаем активный лист
		$sheet = $this->xls->getActiveSheet();		

		$T=0;
		$R=0;

		// Получили строки и обойдем их в цикле
		$rowIterator = $sheet->getRowIterator();			

		foreach ($rowIterator as $row) {
			// Получили ячейки текущей строки и обойдем их в цикле
			$cellIterator = $row->getCellIterator();				

			$T++;
			$R=0;					
				
			foreach ($cellIterator as $cell) {				
				$Ret[$T][$R]["value"] = $cell->getCalculatedValue();
				//$Ret[$T][$R]["backgound"]=$cell->GetStyle()->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->getRGB();
				$R++;

			}
		}
		
		return $Ret;		
	}
	
}
