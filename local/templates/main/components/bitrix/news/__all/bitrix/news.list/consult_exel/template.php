<?

//require($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/class/PHPExcel.php');
//Консультация;
$this->setFrameMode(true);
$arManagers = Helper::getManagers();
$arTitle = [
	"NAME" => "Консультация",
	"CLIENT" => "Клиент",
	"MANAGER" => "Ответсвтенный",
	"PERIOD" => "Период оказания услуги",
	"STATUS" => "Статус",
	"PREVIEW_TEXT" => "Описание",
];
$arCels = 'ABCDEFGHIJKLMNOPQRSTUVW';
$sheet = $GLOBALS['$sheet'];
$lineN = $GLOBALS['line_n'];

$lineN+=4;
$celN = 0;
foreach ($arTitle as $title) {

	$word = $arCels[$celN];
	$celN++;
	$cel = $word . $lineN;
	$sheet->setCellValue($cel, $title);
	$sheet->getStyle($cel)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$sheet->getStyle($cel)->getFill()->getStartColor()->setRGB('4169E1');

	$sheet->getColumnDimensionByColumn($celN - 1)->setAutoSize(true);

	$sheet->getStyle($cel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
}
$lineN+=1;
foreach ($arResult["ITEMS"] as $arItem) {
	$arClient = Client::getClientById($arItem['PROPERTIES']['CLIENT']['VALUE']);
	$STATUS = "";
	if ($arItem['PROPERTIES']['TYPE']['VALUE_XML_ID'] != 'CONSULT') {

		if ($arItem['PROPERTIES']['STATUS']['VALUE'] == Service::STATUS_ACTIVE)
			$STATUS = "В работе";
		else
			$STATUS = "Завершен";
	}
	$arExel = [
		"NAME" => $arItem["NAME"],
		"PREVIEW_TEXT" => $arItem["PREVIEW_TEXT"],
		"CLIENT" => $arClient['~NAME'],
		"MANAGER" => $arManagers[$arItem['PROPERTIES']['MANAGER']['VALUE']]['FIO'],
		"STATUS" => $STATUS,
		"PERIOD" => $arItem["DATE_ACTIVE_FROM"] . '' . ($arItem["DATE_ACTIVE_TO"] != "" ? '- ' . $arItem["DATE_ACTIVE_TO"] : '' ),
	];
	$celN = 0;
	$GLOBALS['excel']['consult'][] = $arExel;
	foreach ($arTitle as $code => $title) {

		$word = $arCels[$celN];
		$celN++;
		$cel = $word . $lineN;
		$sheet->setCellValueExplicit($cel, $arExel[$code], PHPExcel_Cell_DataType::TYPE_STRING);
	}
	$lineN++;
}

$GLOBALS['line_n']  = $lineN;


