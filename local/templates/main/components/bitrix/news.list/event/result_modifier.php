<?php
	
	/*
		ПОлучаем отправленные СМС
	*/
	$elementsIds = [];
	foreach ($arResult["ITEMS"] as $arItem) {
		$elementsIds[] =$arItem['ID'];
	}
	//l($elementsIds);
	if(count($elementsIds)>0){
		$raiting = new Raiting();
		$raitingArr = $raiting->getServiceRaitingArray($elementsIds);
		//l($raitingArr);
		foreach ($arResult["ITEMS"] as &$arItem) {
			foreach ($raitingArr as $arr) {
				if($arr['UF_SERVICE_ID'] == $arItem['ID']){
					$arItem['SMS_DATA'] = $arr;			   
				}
			}
		}
	}
	
	
	
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
	
