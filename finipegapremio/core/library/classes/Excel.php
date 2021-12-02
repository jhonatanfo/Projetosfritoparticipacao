<?php

ini_set('display_errors',1);
ini_set('memory_limit','950M');
ini_set('max_execution_time', 1200); 

include_once(COREPATH.'resources/PHPExcel/PHPExcel.php');
include_once(COREPATH.'resources/PHPExcel/PHPExcel/IOFactory.php');

class Excel{

	public $objPHPExcel;
	public $index = -1;

	public static $allowedExtensions = array("xls","xlsx");


	public static function renderSimpleSheet($titleSheet="Untitle",$header=array(),$dados=array(),$infoSheet=array(),$extension="xlsx"){

		try{				

			$objPHPExcel = new PHPExcel();
			$objPHPExcel = self::createSheet($titleSheet,$objPHPExcel);
			$objPHPExcel = self::createHeader($header,$objPHPExcel);	
			$objPHPExcel = self::addValuesToSheet($dados,$objPHPExcel);
			self::render($objPHPExcel,$infoSheet,$extension);

		}catch(Exception $e){
			echo sprintf("Exceção capturada:  %s",$e->getMessage());
			die();
		}

	}

	public function addSheet($titleSheet="Untitle",$header=array(),$dados=array()){
		if($this->objPHPExcel == NULL){
			$this->objPHPExcel = new PHPExcel();
		}
		$this->index++;
		$this->objPHPExcel =  self::createSheet($titleSheet,$objPHPExcel=$this->objPHPExcel,$index=$this->index);
		$this->objPHPExcel = self::createHeader($header,$objPHPExcel=$this->objPHPExcel);
		$this->objPHPExcel = self::addValuesToSheet($dados,$objPHPExcel=$this->objPHPExcel);
	}

	public static function createSheet($titleSheet,$objPHPExcel,$index=0){
		$objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex($index)->setTitle($titleSheet);
		return $objPHPExcel;
	}

	public static function createHeader($header,$objPHPExcel){
		$col = 'A';
		foreach($header as $head){
			$objPHPExcel->getActiveSheet()->setCellValue($col."1", $head);    	
			$col++;
		}	
		return $objPHPExcel;
	}

	public static function addValuesToSheet($values,$objPHPExcel){
		if(is_array($values) && !empty($values)){
		    $row = 2;
			foreach($values as $value){
				$col = "A";
				foreach($value as $key => $_value){
					$_value = is_null($_value) || $_value == '' ? '--' : $_value;
					$objPHPExcel->getActiveSheet()->setCellValue($col.$row, $_value);    	
					$col++;
				}			
				$row++;
			}
		}else{
			$objPHPExcel->getActiveSheet()->setCellValue("A2", "Não possui valores");    	
		}	
		return $objPHPExcel;
	}

	public static function render($objPHPExcel,$infoSheet,$extension='xlsx'){

		if(isset($objPHPExcel->{'objPHPExcel'})){
			$objPHPExcel = $objPHPExcel->{'objPHPExcel'};
		}			
		

		$version = self::getVersionExcelByExtension($extension);

		$infoSheet = array(
							"creator" => (isset($infoSheet['creator']) ? $infoSheet['creator'] : "creator" ),
							"lastModifiedBy" => (isset($infoSheet['lastModifiedBy']) ? $infoSheet['lastModifiedBy'] : "lastModifiedBy" ),
							"title" => (isset($infoSheet['title']) ? $infoSheet['title'] : "title" ),
							"subject" => (isset($infoSheet['subject']) ? $infoSheet['subject'] : "subject" ),
							"description" => (isset($infoSheet['description']) ? $infoSheet['description'] : "description" ),
							"keywords" => (isset($infoSheet['keywords']) ? $infoSheet['keywords'] : "keywords" ),
							"category" => (isset($infoSheet['category']) ? $infoSheet['category'] : "category" ),
							"filename" => (isset($infoSheet['filename']) ? $infoSheet["filename"]."_".create_guid() : create_guid())
						   );

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getProperties()->setCreator($infoSheet['creator']);
		$objPHPExcel->getProperties()->setLastModifiedBy($infoSheet['lastModifiedBy']);
		$objPHPExcel->getProperties()->setTitle($infoSheet['title']);
		$objPHPExcel->getProperties()->setSubject($infoSheet['subject']);
		$objPHPExcel->getProperties()->setDescription($infoSheet['description']);
		$objPHPExcel->getProperties()->setKeywords($infoSheet['keywords']);
		$objPHPExcel->getProperties()->setCategory($infoSheet['category']);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $version);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		$header = sprintf('Content-Disposition: attachment;filename=%s.%s',$infoSheet["filename"],$extension);
		header($header);
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');	// Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objWriter->save('php://output'); 
		die();

	}
	
	public static function getVersionExcelByExtension($extension){
		$extension = strtolower($extension);
		$allowedExtensions = self::$allowedExtensions;
		if(!in_array($extension, $allowedExtensions)){
			throw new Exception("Extensão não permitida. As extensões permitidas são : ".implode(",",$allowedExtensions), 1);
		}
		$version = null;
		if($extension == "xls"){
			$version="Excel5";
		}
		if($extension == "xlsx"){
			$version = "Excel2007";
		}
		return $version;
	}	


}
