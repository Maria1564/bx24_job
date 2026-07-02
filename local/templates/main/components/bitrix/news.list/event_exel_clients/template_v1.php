<?

require($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/class/PHPExcel.php');
//exit;
$this->setFrameMode(true);
$arManagers = Helper::getManagers();

//Переменная для определения страницы
$isConsultPage = $GLOBALS['arFilter']['PROPERTY_TYPE'] == Service::TYPE_CONSALT_ID?true:false;

/*
*
*  Поля для Услуг
*
*/
$arTitle = [
   
	"NAME" => "Услуга",
	"CLIENT" => "Клиент",
	"INN" => "ИНН",
	"MANAGER" => "Ответсвтенный",
	"PERIOD_A" => "Дата создания",
	"PERIOD_B" => "Дата завершения",
	"STATUS" => "Статус",
	"PREVIEW_TEXT" => "Описание",
	"SMS_VOTE" => "смс оценка",
	"SMS_COMMENT" => "смс  комментарий",
	"SMS_DATE_SEND" => "дата отправки смс",
	"DIRECTION" => "Направление",
	
];
/*
*
*  Поля для Консультаций
*
*/
if($isConsultPage){
	$arTitle = [
	 "LOG"=>"Log",
	"NAME" => "Услуга",
	"UNIQ" => "Уникальный клиент",
	"CLIENT" => "Клиент",
	"INN" => "ИНН",
	"CLIENT_TYPE" => "Тип клиента",
	"MANAGER" => "Ответсвтенный",
	"PERIOD_A" => "Дата создания",
	"PERIOD_B" => "Дата завершения",
	"STATUS" => "Статус",
	"PREVIEW_TEXT" => "Описание",
	"SMS_VOTE" => "смс оценка",
	"SMS_COMMENT" => "смс  комментарий",
	"SMS_DATE_SEND" => "дата отправки смс",
	
];
	//$arTitle["UNIQ"] = 'Уникальный клиент';
}
if($arParams['ALL_DATA_PAGE']){
	$arTitle['TYPE'] = "Тип";
	$arTitle['WORK_PROCCESS'] = "В работе/Завершена";
}

$arCels = 'ABCDEFGHIJKLMNOPQRSTUVW';
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
foreach ($arResult["ITEMS"] as $arItem) {
	//Берем из кеша
	$log = '';
	//$arClient = Client::getClientById($arItem['PROPERTIES']['CLIENT']['VALUE']);
	$arClient = $arItem['CLIENT'];
	
	$STATUS = "";
	if ($arItem['PROPERTIES']['TYPE']['VALUE_XML_ID'] != 'CONSULT') {

		if ($arItem['PROPERTIES']['STATUS']['VALUE'] == Service::STATUS_ACTIVE)
			$STATUS = "В работе";
		else
			$STATUS = "Завершен";
	}
	
	
	//убираем у даты точное время
	$arTemp = explode(" ",$arItem["DATE_ACTIVE_FROM"]);
	$arItem["DATE_ACTIVE_FROM"] = $arTemp[0];
	if($arItem["DATE_ACTIVE_TO"]){
	   $arTemp = explode(" ",$arItem["DATE_ACTIVE_TO"]);
	   $arItem["DATE_ACTIVE_TO"] = $arTemp[0];
	}
	
	//$arClient['TYPE_NAME_INN'] = str_replace("ИНН:","",$arClient['TYPE_NAME_INN']);
	//$arClient['TYPE_NAME_INN'] = str_replace("quot;",'"',$arClient['TYPE_NAME_INN']);
	
	
	/*
	*
	*  Получаем СМС данные для услуги!
	*/
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
	$arExel = [
	   // "LOG"=>$log,
		"LOG"=>$arItem["COUNT_N"],
		"NAME" => $arItem["NAME"],
		"TYPE" => $arItem['PROPERTIES']['TYPE']['VALUE_XML_ID']== 'CONSULT'?'консультация':'услуга',
		"PREVIEW_TEXT" => $arItem["PREVIEW_TEXT"],
		"CLIENT" => $arClient['NAME'],
		"INN" => $arClient['INN'],
		//Тип клиента ORG_TYPE
		"CLIENT_TYPE" => $arClient['ORG_TYPE'],
		"MANAGER" => $arManagers[$arItem['PROPERTIES']['MANAGER']['VALUE']]['FIO'],
		"STATUS" => $STATUS,
		//"PERIOD" => $arItem["DATE_ACTIVE_FROM"] . '' . ($arItem["DATE_ACTIVE_TO"] != "" ? '- ' . $arItem["DATE_ACTIVE_TO"] : '' ),
		"PERIOD_A" => $arItem["DATE_ACTIVE_FROM"],
		"PERIOD_B" => $arItem["DATE_ACTIVE_TO"],
		"SMS_VOTE" => $SMS_VOTE,
	    "SMS_COMMENT" => $SMS_TEXT,
		"SMS_DATE_SEND" => $SMS_DATE_SEND,
		"DIRECTION" => $arItem['PROPERTIES']['DIRECTION']['VALUE'],
	];
	
	if($isConsultPage && $_REQUEST['CLIENT_UNIQ'] != "Y"){
	//$arItem["COUNT_N"] - если больше нуля, то получается есть консультации с датой пораньше и не является уникальным в текущем году
	   $arExel["UNIQ"] = $arItem["COUNT_N"] > 0?0:1;
	    //$arExel["UNIQ"].=' | '. $arItem["COUNT_N"];
    }
	if($_REQUEST['CLIENT_UNIQ'] == "Y"){
	  $arExel["UNIQ"] =1;
	}

	$celN = 0;
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


$filePath = $_SERVER['DOCUMENT_ROOT'] . "/upload/csv/" . $APPLICATION->GetTitle() . ".xls";

$fileName = str_replace($_SERVER['DOCUMENT_ROOT'], "", $filePath);
$objWriter = new PHPExcel_Writer_Excel5($xls);
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