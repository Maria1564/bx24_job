<?php
	
	/*
	$elementsIds = [];
	foreach ($arResult["ITEMS"] as &$arItem) {
		foreach($arItem["PROPERTIES"]["CONTACT"]["VALUE"] as $contact){
			
		}
	}
	
	print_r($arResult["ITEMS"]);
	*/
	
	if ($_REQUEST['exel'] == "y") {
		$allManagers = Helper::getManagers();
		$arTitle = [
		"NAME" => "Услуга",
		"CLIENT" => "Клиент",
		"MANAGER" => "Ответсвтенный",
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
			"MANAGER" => $allManagers[$arItem['PROPERTIES']['MANAGER']['VALUE']]['FIO'],
			];
		}
		
			
			
			$fileName = createCSVFile($APPLICATION->GetTitle(), $arTitle, $arExel);
			$APPLICATION->RestartBuffer();
			header('Content-Type: application/json');
			//echo download_send_headers("1");
			echo json_encode(['fileName' => $fileName]);
			exit;
	}
	
