<?

require($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/class/PHPExcel.php');
//exit;
$this->setFrameMode(true);
if($_GET["PROP"]["ORG_TYPE"][0] == 4){
	$arTitle = [
		"NAME" => "Название",
		"PHONE" => "Телефон",
		"EMAIL" => "email",
		"INN" => "Инн",
		"OGRN" => "Огрн",
		//"PREVIEW_TEXT" => "Описание",
		"SERVICE_COUNT" => "Количество услуг",
		"LAST_CONTACT_DATE" => "Последний контакт",
		"MANAGER" => "Менеджер",
		"BLUE_CLIENT" => "Приоритетный клиент",
		"ORG_TYPE" => "Тип клиента",
		"SZ" => "Самозанятый",
		"OBSHEPIT" => "Общепит",
		"PROFESSIONS" => "Профессия",
		"COUNTRIES" => "Страна",
	];
}
else{
	$arTitle = [
		"NAME" => "Название",
		"PHONE" => "Телефон",
		"EMAIL" => "email",
		"INN" => "Инн",
		"OGRN" => "Огрн",
		//"PREVIEW_TEXT" => "Описание",
		"SERVICE_COUNT" => "Количество услуг",
		"LAST_CONTACT_DATE" => "Последний контакт",
		"MANAGER" => "Менеджер",
		"BLUE_CLIENT" => "Приоритетный клиент",
		"ORG_TYPE" => "Тип клиента",
		"OBSHEPIT" => "Общепит",
		"PROFESSIONS" => "Профессия",
		"COUNTRIES" => "Страна",
	];
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
$sheet->setTitle('Таблица умножения');


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
	
	
	//убираем у даты точное время
	$arTemp = explode(" ",$arItem["LAST_CONTACT_DATE"]);
	$arItem["LAST_CONTACT_DATE"] = $arTemp[0];
	
	if($_GET["PROP"]["ORG_TYPE"][0] == 4){
		$arExel = [
			"NAME" => $arItem["NAME"],
			"PREVIEW_TEXT" => $arItem["PREVIEW_TEXT"],
			"SERVICE_COUNT" => $arItem["SERVICE_COUNT"],
			"LAST_CONTACT_DATE" => $arItem["LAST_CONTACT_DATE"],
			"MANAGER" => $arItem['MANAGER'],
			"PHONE" => $arItem['PHONE'],
			"EMAIL" => $arItem['EMAIL'],
			"INN" => $arItem['INN'],
			"OGRN" => $arItem['OGRN'],
			"BLUE_CLIENT" => $arItem['BLUE_CLIENT'],
			"ORG_TYPE" => $arItem['ORG_TYPE'],
			"SZ" => $arItem['SZ'],
			"OBSHEPIT" => $arItem['OBSHEPIT'],
			"PROFESSIONS" => $arItem['PROFESSIONS'],
			"COUNTRIES" => $arItem['COUNTRIES'],
		];
	}
	else{
		$arExel = [
			"NAME" => $arItem["NAME"],
			"PREVIEW_TEXT" => $arItem["PREVIEW_TEXT"],
			"SERVICE_COUNT" => $arItem["SERVICE_COUNT"],
			"LAST_CONTACT_DATE" => $arItem["LAST_CONTACT_DATE"],
			"MANAGER" => $arItem['MANAGER'],
			"PHONE" => $arItem['PHONE'],
			"EMAIL" => $arItem['EMAIL'],
			"INN" => $arItem['INN'],
			"OGRN" => $arItem['OGRN'],
			"BLUE_CLIENT" => $arItem['BLUE_CLIENT'],
			"ORG_TYPE" => $arItem['ORG_TYPE'],
			"OBSHEPIT" => $arItem['OBSHEPIT'],
			"PROFESSIONS" => $arItem['PROFESSIONS'],
			"COUNTRIES" => $arItem['COUNTRIES'],
		];
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
	header("Content-Disposition: attachment; filename=matrix.xls");

	//header("Content-Disposition: attachment; filename=matrix.xls");

// Выводим содержимое файла
	//$objWriter = new PHPExcel_Writer_Excel5($xls);
	//$objWriter->save('php://output');
}

$filePath = $_SERVER['DOCUMENT_ROOT'] . "/upload/csv/" . $APPLICATION->GetTitle() . ".xlsx";

$fileName = str_replace($_SERVER['DOCUMENT_ROOT'],"",$filePath);
//$objWriter = new PHPExcel_Writer_Excel5($xls);
$objWriter = new PHPExcel_Writer_Excel2007($xls);

if(file_exists($filePath)){
	unlink($filePath);
}

$objWriter->save($filePath);
header('Content-Type: application/json');
//echo download_send_headers("1");
echo json_encode(['fileName' => $fileName]);

/*
		"NAME" => $arItem["~NAME"],
		"PREVIEW_TEXT" => $arItem["PREVIEW_TEXT"],
		"SERVICE_COUNT" => $arItem["SERVICE_COUNT"],
		"LAST_CONTACT_DATE" => $arItem["LAST_CONTACT_DATE"],
		"MANAGER" => $arManagers[$arItem["PROPERTIES"]['MANAGER']['VALUE']]['FIO'],
		"PHONE" => $arItem['PROPERTIES']['PHONE']['VALUE'],
		"EMAIL" => $arItem['PROPERTIES']['EMAIL']['VALUE'],
		"INN" => $arItem['PROPERTIES']['INN']['VALUE'],
		"OGRN" => $arItem['PROPERTIES']['OGRN']['VALUE'],
		*/
