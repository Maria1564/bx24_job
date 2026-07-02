<?
	
	require($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/class/PHPExcel.php');
	//exit;
	$this->setFrameMode(true);
	$arManagers = Helper::getManagers();
	

	$arTitle = [
	//"LOG"=>"Log",
	"N" => "",
	"NAME" => "Мероприятие",	
	"CONTACT" => "Контакт",
	"CLIENT" => "Клиент",
	"INN" => "ИНН",
	"BLUE_CLIENT" => "Голубой клиент",
	"PHONE" => "Телефон",
	"EMAIL" => "E-mail",
	"SVO" => "Участник СВО",
	];

	
	

	
	
	$arCels = 'ABCDEFGHIJKLMNOPQRSTUVWX';
	// Подключаем класс для вывода данных в формате excel
	//require_once('PHPExcel/Writer/Excel5.php');
	// Создаем объект класса PHPExcel
	$xls = new PHPExcel();
	// Устанавливаем индекс активного листа
	$xls->setActiveSheetIndex(0);
	// Получаем активный лист
	$sheet = $xls->getActiveSheet();
	// Подписываем лист
	$sheet->setTitle('АРБКО');
	
	
	$celN = 0;
	foreach ($arTitle as $title) {
		
		$word = $arCels[$celN];
		$celN++;
		$cel = $word . '1';
		$sheet->setCellValue($cel, $title);
		$sheet->getStyle($cel)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$sheet->getStyle($cel)->getFill()->getStartColor()->setRGB('EEEEEE');
		
		$sheet->getColumnDimensionByColumn($celN - 1)->setAutoSize(true);
		
		$sheet->getStyle($cel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	}
	
	
	
	$lineN = 2;
	$N = 0;
	foreach ($arResult["ITEMS"] as $arItem) {
		//Берем из кеша
		$log = '';
		//$arClient = Client::getClientById($arItem['PROPERTIES']['CLIENT']['VALUE']);
		//$arClient = $arItem['CLIENT'];
		
		foreach($arItem["CONTACTS"] as $contact){

			$N++;
			$arExel = [
			"N"=>$N,
			"NAME" => $arItem["NAME"],
			"CONTACT" => $contact["NAME"],
			"CLIENT" => $contact['CLIENT'],	
			"INN" => $contact['INN'],
			"BLUE_CLIENT" => $contact['BLUE_CLIENT'],
			"PHONE" => $contact['PHONE'],
			"EMAIL" => $contact['EMAIL'],
			"SVO" => $contact['SVO'],
			];
			
				//$arItem["COUNT_N"] - если больше нуля, то получается есть консультации с датой пораньше и не является уникальным в текущем году
				$arExel["UNIQ"] = $arItem["COUNT_N"] > 0?0:1;
				//$arExel["UNIQ"].=' | '. $arItem["COUNT_N"];
			
			if($_REQUEST['CLIENT_UNIQ'] == "Y"){
				$arExel["UNIQ"] =1;
			}
			
			$celN = 0;
			//log2file('_log',$arExel);
			foreach ($arTitle as $code => $title) {
				
				$word = $arCels[$celN];
				$celN++;
				$cel = $word . $lineN;
				$sheet->setCellValueExplicit($cel, $arExel[$code], PHPExcel_Cell_DataType::TYPE_STRING);
				//$sheet->getColumnDimension($cel)->setAutoSize(true);
				//$sheet->getStyle($cel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			
			
			$lineN++;
		}	
	}
	
	
	
	
	
	
	
	if (false) {
		// Выводим HTTP-заголовки
		header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$APPLICATION->GetTitle().".xls");
		
		// Выводим содержимое файла
		$objWriter = new PHPExcel_Writer_Excel5($xls);
		$objWriter->save('php://output');
		exit;
	}
	
	
	$filePath = $_SERVER['DOCUMENT_ROOT'] . "/upload/csv/" . $APPLICATION->GetTitle() . ".xlsx";
	
	$fileName = str_replace($_SERVER['DOCUMENT_ROOT'], "", $filePath);
	$objWriter = new PHPExcel_Writer_Excel2007($xls);
	//ob_end_clean();
	if(file_exists($filePath)){
		unlink($filePath);
	}
	$objWriter->save($filePath);
	
	//echo download_send_headers("1");
	//echo json_encode(['fileName' => $fileName]);
	//Получаем все данные
	echo json_encode([
	"MODE"=>"DONE",
	'fileName' => $fileName,
	"COUNT"=>count($arResult["ITEMS"]),
	"PAGEN" =>$arResult['NAV_RESULT']->PAGEN,
	"SIZEN" =>$arResult['NAV_RESULT']->SIZEN,
	"NAV_RESULT" =>$arResult['NAV_RESULT']->NavRecordCount,
	]);
exit;
