<?
	
	require($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/class/PHPExcel.php');
	//exit;
	$this->setFrameMode(true);
	$arManagers = Helper::getManagers();
	

	$arTitle = [
	//"LOG"=>"Log",
	"N" => "",
	"NAME" => "Мероприятие",	
	"TYPE" => "Тип",
	"CLIENT" => "Клиент",
	"CONTACT" => "Контакт",
	"PERIOD_A" => "Дата начала",
	"PERIOD_B" => "Дата завершения",
	"PREVIEW_TEXT" => "Описание",
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
	
	foreach ($arResult["ITEMS"] as $arItem){
		$contacts = Contact::getClientContactsId($idContact = $arItem["PROPERTIES"]["CONTACT"]["VALUE"]);
		foreach($contacts as $contact){
			if($GLOBALS['arFilter']['PROPERTY_CONTACT'] && !in_array($contact["ID"], $GLOBALS['arFilter']['PROPERTY_CONTACT'])){
				continue;
			}
			$client = Client::getClientById($contact["CLIENT"]);
			
			$N++;
			$arExel = [
			"N"=>$N,
			"NAME" => $arItem["NAME"],
			"TYPE" => "Мероприятие",
			"PREVIEW_TEXT" => $arItem["PREVIEW_TEXT"],
			"CLIENT" => $client["NAME"],
			"CONTACT" => $contact["NAME"],
			"PERIOD" => $arItem["DATE_ACTIVE_FROM"] . '' . ($arItem["DATE_ACTIVE_TO"] != "" ? '- ' . $arItem["DATE_ACTIVE_TO"] : '' ),
			"PERIOD_A" => $arItem["DATE_ACTIVE_FROM"],
			"PERIOD_B" => $arItem["DATE_ACTIVE_TO"],
			];
			
			$celN = 0;
			foreach ($arTitle as $code => $title) {
				
				$word = $arCels[$celN];
				$celN++;
				$cel = $word . $lineN;
				$sheet->setCellValueExplicit($cel, $arExel[$code], PHPExcel_Cell_DataType::TYPE_STRING);
			}
			$lineN++;
			
		}
	}
	
	/*
	foreach ($arResult["ITEMS"] as $arItem) {
		//Берем из кеша
		$log = '';
		//$arClient = Client::getClientById($arItem['PROPERTIES']['CLIENT']['VALUE']);
		$arClient = $arItem['CLIENT'];
		
		$STATUS = "";
	//	if ($arItem['PROPERTIES']['TYPE']['VALUE_XML_ID'] != 'CONSULT') {
			
			if ($arItem['PROPERTIES']['STATUS']['VALUE'] == Service::STATUS_ACTIVE)
			$STATUS = "В работе";
			else
			$STATUS = "Завершен";
	//	}
		
		
		//убираем у даты точное время
		$arTemp = explode(" ",$arItem["DATE_ACTIVE_FROM"]);
		$arItem["DATE_ACTIVE_FROM"] = $arTemp[0];
		if($arItem["DATE_ACTIVE_TO"]){
			$arTemp = explode(" ",$arItem["DATE_ACTIVE_TO"]);
			$arItem["DATE_ACTIVE_TO"] = $arTemp[0];
		}
		
		//$arClient['TYPE_NAME_INN'] = str_replace("ИНН:","",$arClient['TYPE_NAME_INN']);
		//$arClient['TYPE_NAME_INN'] = str_replace("quot;",'"',$arClient['TYPE_NAME_INN']);
		
		
		
		$SMS_VOTE = $arItem['PROPERTIES']['SMS_VOTE']['VALUE'];
		$SMS_TEXT = '';
		$SMS_DATE_SEND='';
		
		if($SMS_VOTE !=""){
			//$raitingArray  = $raiting->getServiceRaitingArray($arItem['ID']);
			$raitingArray  = $arItem['RAITING'];
			$SMS_TEXT = $raitingArray['UF_SMS_TEXT'];
			$SMS_DATE_SEND=date('d:m:Y H:i:s',$raitingArray['UF_SMS_SEND_DATE']);
		}
		
		
		$log.= $arItem["COUNT_N"].' ';
		//	$log.=$arItem["DATE_ACTIVE_FROM"] . '' . ($arItem["DATE_ACTIVE_TO"] != "" ? '- ' . $arItem["DATE_ACTIVE_TO"] : '' );
		
		//Успешно реализовано?
		$STATUS_WORK_DONE= '';
		if($arItem['PROPERTIES']['STATUS']['VALUE'] != Service::STATUS_ACTIVE){
		
			$BX24_STATUS_EXT = $arItem['PROPERTIES']['BX24_STATUS_EXT']['VALUE'];
			if($BX24_STATUS_EXT){
				$STATUS_WORK_DONE = 'Успешно реализован';
			}
			//Отказ от услуги
			$CLIENT_REFUSED = $arItem['PROPERTIES']['CLIENT_REFUSED']['VALUE'];
			if($CLIENT_REFUSED==1){
				$STATUS_WORK_DONE = 'Отказ от услуги';
			}
		}
		$N++;
		$arExel = [
		"N"=>$N,
		"LOG"=>$arItem['PROPERTIES']['CLIENT_REFUSED'],
		"NAME" => $arItem["NAME"],
		"TYPE" => "Мероприятие",
		"PREVIEW_TEXT" => $arItem["PREVIEW_TEXT"],
		"CLIENT" => 
		"MANAGER" => $arManagers[$arItem['PROPERTIES']['MANAGER']['VALUE']]['FIO'],
		"PERIOD" => $arItem["DATE_ACTIVE_FROM"] . '' . ($arItem["DATE_ACTIVE_TO"] != "" ? '- ' . $arItem["DATE_ACTIVE_TO"] : '' ),
		"PERIOD_A" => $arItem["DATE_ACTIVE_FROM"],
		"PERIOD_B" => $arItem["DATE_ACTIVE_TO"],
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
	}*/
	
	
	
	
	
	
	
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
