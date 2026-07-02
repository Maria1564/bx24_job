<?


//КЛИЕНТ;
$this->setFrameMode(true);
$arManagers = Helper::getManagers();
$arTitle = [
	"NAME" => "Название",
	"PHONE" => "Телефон",
	"EMAIL" => "email",
	"INN" => "Инн",
	"OGRN" => "Огрн",
	//"PREVIEW_TEXT" => "Описание",
	"SERVICE_COUNT" => "Количество услуг",
	"LAST_CONTACT_DATE" => "Послдений контакт",
	"MANAGER" => "Менеджер",
];
$arCels = 'ABCDEFGHIJKLMNOPQRSTUVW';
$sheet = $GLOBALS['$sheet'];
$sheet->setTitle('Данные');

$celN = 0;
foreach ($arTitle as $title) {
	$word = $arCels[$celN];
	$celN++;
	$cel = $word . '1';
	$sheet->setCellValue($cel, $title);
	$sheet->getStyle($cel)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$sheet->getStyle($cel)->getFill()->getStartColor()->setRGB('FF8C00');
	$sheet->getColumnDimensionByColumn($celN - 1)->setAutoSize(true);
	$sheet->getStyle($cel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
}
$lineN = 2;
foreach ($arResult["ITEMS"] as $arItem) {
	$arExel = [
		"NAME" => $arItem["~NAME"],
		"PREVIEW_TEXT" => $arItem["PREVIEW_TEXT"],
		"SERVICE_COUNT" => $arItem["SERVICE_COUNT"],
		"LAST_CONTACT_DATE" => $arItem["LAST_CONTACT_DATE"],
		"MANAGER" => $arManagers[$arItem["PROPERTIES"]['MANAGER']['VALUE']]['FIO'],
		"PHONE" => $arItem['PROPERTIES']['PHONE']['VALUE'],
		"EMAIL" => $arItem['PROPERTIES']['EMAIL']['VALUE'],
		"INN" => $arItem['PROPERTIES']['INN']['VALUE'],
		"OGRN" => $arItem['PROPERTIES']['OGRN']['VALUE'],
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
$GLOBALS['line_n']  = $lineN;




