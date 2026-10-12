<?php

if ($_REQUEST['exel'] == "y") {
	$allManagers = Helper::getManagers();
	$arTitle = [
		"NAME" => "Услуга",
		"CLIENT" => "Клиент",
		"PREVIEW_TEXT" => "Описание",
	];
	foreach ($arResult["ITEMS"] as $arItem) {
	
		if ($arItem['PROPERTIES']['CLINET']['VALUE'] > 1) {
		
			$arClient = Client::getClientById($arItem['PROPERTIES']['CLINET']['VALUE']);
		}
		$arExel[] = [
			"NAME" => $arItem["NAME"],
			"PREVIEW_TEXT" => $arItem["PREVIEW_TEXT"],
			"CLIENT" => $arClient['NAME'],
		];
	}



	$fileName = createCSVFile($APPLICATION->GetTitle(), $arTitle, $arExel);
	$APPLICATION->RestartBuffer();
	header('Content-Type: application/json');
	//echo download_send_headers("1");
	echo json_encode(['fileName' => $fileName]);
	exit;
}
	    
