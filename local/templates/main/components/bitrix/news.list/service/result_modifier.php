<?php
	if ($arParams['ALL_DATA_PAGE'] == 'Y' && $_REQUEST['exel'] != "y") {
		$sortName = $_SESSION['sort']['name'] ?: 'ACTIVE_FROM';
		$sortOrder = $_SESSION['sort']['order'] ?: 'DESC';
		$pageSize = (int)$arParams['NEWS_COUNT'];
		$pageSize = $pageSize > 0 ? $pageSize : 25;
		$pageNum = (int)($_REQUEST['PAGEN_1'] ?: 1);
		$pageNum = $pageNum > 0 ? $pageNum : 1;

		$combinedRows = [];
		$serviceFilter = (array)$GLOBALS[$arParams["FILTER_NAME"]];
		$serviceFilter['IBLOCK_ID'] = IBLOCK_ID_SERVICE;
		$serviceFilter['ACTIVE'] = 'Y';

		$rsServices = CIBlockElement::GetList(
			[],
			$serviceFilter,
			false,
			false,
			[
				'ID',
				'NAME',
				'DATE_ACTIVE_FROM',
				'ACTIVE_FROM',
			]
		);
		while ($service = $rsServices->Fetch()) {
			$combinedRows[] = [
				'SOURCE' => 'SERVICE',
				'ID' => (int)$service['ID'],
				'NAME' => $service['NAME'],
				'DATE_ACTIVE_FROM' => $service['DATE_ACTIVE_FROM'],
				'ACTIVE_FROM' => $service['ACTIVE_FROM'],
			];
		}

		$arEventFilter = [
			'IBLOCK_ID' => 7,
			'ACTIVE' => 'Y',
		];
		if ($_REQUEST['DATE_FROM']) {
			$arEventFilter['>=DATE_ACTIVE_FROM'] = date('d.m.Y 00:00:01', strtotime($_REQUEST['DATE_FROM']));
		}
		if ($_REQUEST['DATE_TO']) {
			$arEventFilter['<=DATE_ACTIVE_FROM'] = date('d.m.Y 23:59:59', strtotime($_REQUEST['DATE_TO']));
		}
		if (!empty($GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MANAGER'])) {
			$arEventFilter['PROPERTY_MANAGER'] = $GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MANAGER'];
		}

		$rsEvents = CIBlockElement::GetList(
			[],
			$arEventFilter,
			false,
			false,
			[
				'ID',
				'NAME',
				'DATE_ACTIVE_FROM',
				'ACTIVE_FROM',
			]
		);
		while ($event = $rsEvents->Fetch()) {
			$combinedRows[] = [
				'SOURCE' => 'EVENT',
				'ID' => (int)$event['ID'],
				'NAME' => $event['NAME'],
				'DATE_ACTIVE_FROM' => $event['DATE_ACTIVE_FROM'],
				'ACTIVE_FROM' => $event['ACTIVE_FROM'],
			];
		}

		usort($combinedRows, function ($a, $b) use ($sortName, $sortOrder) {
			if ($sortName == 'NAME') {
				$result = strcasecmp($a['NAME'], $b['NAME']);
			} else {
				$aTime = MakeTimeStamp($a['DATE_ACTIVE_FROM'] ?: $a['ACTIVE_FROM']);
				$bTime = MakeTimeStamp($b['DATE_ACTIVE_FROM'] ?: $b['ACTIVE_FROM']);
				$result = $aTime <=> $bTime;
			}

			return $sortOrder == 'ASC' ? $result : -$result;
		});

		$totalCount = count($combinedRows);
		$pageRows = array_slice($combinedRows, ($pageNum - 1) * $pageSize, $pageSize);
		$serviceIds = [];
		$eventIds = [];
		foreach ($pageRows as $row) {
			if ($row['SOURCE'] == 'EVENT') {
				$eventIds[] = $row['ID'];
			} else {
				$serviceIds[] = $row['ID'];
			}
		}

		$itemsByKey = [];
		if (!empty($serviceIds)) {
			$rsPageServices = CIBlockElement::GetList(
				[],
				['IBLOCK_ID' => IBLOCK_ID_SERVICE, 'ID' => $serviceIds],
				false,
				false,
				[
					'ID',
					'IBLOCK_ID',
					'NAME',
					'PREVIEW_TEXT',
					'DATE_ACTIVE_FROM',
					'ACTIVE_FROM',
					'DATE_ACTIVE_TO',
					'ACTIVE_TO',
				]
			);
			while ($obService = $rsPageServices->GetNextElement()) {
				$fields = $obService->GetFields();
				$fields['PROPERTIES'] = $obService->GetProperties();
				$fields['DISPLAY_ACTIVE_FROM'] = FormatDate($arParams['ACTIVE_DATE_FORMAT'] ?: 'd.m.Y', MakeTimeStamp($fields['DATE_ACTIVE_FROM']));
				$fields['DETAIL_PAGE_URL'] = ($fields['PROPERTIES']['TYPE']['VALUE_XML_ID'] == 'CONSULT' ? '/consult/' : '/service/') . $fields['ID'] . '/';
				$itemsByKey['SERVICE_' . $fields['ID']] = $fields;
			}
		}

		if (!empty($eventIds)) {
			$rsPageEvents = CIBlockElement::GetList(
				[],
				['IBLOCK_ID' => 7, 'ID' => $eventIds],
				false,
				false,
				[
					'ID',
					'IBLOCK_ID',
					'NAME',
					'PREVIEW_TEXT',
					'DATE_ACTIVE_FROM',
					'ACTIVE_FROM',
					'DATE_ACTIVE_TO',
					'ACTIVE_TO',
					'PROPERTY_CONTACT',
					'PROPERTY_MANAGER',
					'PROPERTY_STATUS',
				]
			);
			while ($event = $rsPageEvents->Fetch()) {
				$eventId = (int)$event['ID'];
				if (!isset($itemsByKey['EVENT_' . $eventId])) {
					$itemsByKey['EVENT_' . $eventId] = [
						'ID' => $eventId,
						'IBLOCK_ID' => (int)$event['IBLOCK_ID'],
						'NAME' => $event['NAME'],
						'PREVIEW_TEXT' => $event['PREVIEW_TEXT'],
						'DATE_ACTIVE_FROM' => $event['DATE_ACTIVE_FROM'],
						'ACTIVE_FROM' => $event['ACTIVE_FROM'],
						'DISPLAY_ACTIVE_FROM' => $event['DATE_ACTIVE_FROM'],
						'DATE_ACTIVE_TO' => $event['DATE_ACTIVE_TO'],
						'ACTIVE_TO' => $event['ACTIVE_TO'],
						'DETAIL_PAGE_URL' => '/event/' . $eventId . '/',
						'IS_EVENT' => true,
						'PROPERTIES' => [
							'CONTACT' => ['VALUE' => []],
							'MANAGER' => ['VALUE' => $event['PROPERTY_MANAGER_VALUE']],
							'STATUS' => ['VALUE' => $event['PROPERTY_STATUS_VALUE']],
							'TYPE' => [
								'VALUE_XML_ID' => 'EVENT',
								'VALUE_ENUM' => 'Мероприятие',
							],
						],
					];
				}
				if ($event['PROPERTY_CONTACT_VALUE']) {
					$itemsByKey['EVENT_' . $eventId]['PROPERTIES']['CONTACT']['VALUE'][] = $event['PROPERTY_CONTACT_VALUE'];
				}
			}
		}

		$arResult["ITEMS"] = [];
		foreach ($pageRows as $row) {
			$key = $row['SOURCE'] . '_' . $row['ID'];
			if (isset($itemsByKey[$key])) {
				$arResult["ITEMS"][] = $itemsByKey[$key];
			}
		}

		$arResult['NAV_RESULT'] = (object)[
			'PAGEN' => $pageNum,
			'SIZEN' => $pageSize,
			'NavRecordCount' => $totalCount,
		];

		$query = $_GET;
		unset($query['PAGEN_1']);
		$baseUrl = $APPLICATION->GetCurPage() . (empty($query) ? '?' : '?' . http_build_query($query) . '&');
		$pageCount = (int)ceil($totalCount / $pageSize);
		$fromRecord = $totalCount > 0 ? (($pageNum - 1) * $pageSize + 1) : 0;
		$toRecord = min($pageNum * $pageSize, $totalCount);
		$navString = '<div class="modern-page-navigation">';
		$navString .= '<span>Новости ' . $fromRecord . ' - ' . $toRecord . ' из ' . $totalCount . '</span><br>';
		if ($pageCount > 1) {
			$navString .= $pageNum > 1 ? '<a href="' . $baseUrl . 'PAGEN_1=1">Начало</a> | <a href="' . $baseUrl . 'PAGEN_1=' . ($pageNum - 1) . '">Пред.</a> | ' : 'Начало | Пред. | ';
			$pages = range(1, min(5, $pageCount));
			for ($i = max(1, $pageNum - 2); $i <= min($pageCount, $pageNum + 2); $i++) {
				$pages[] = $i;
			}
			$pages[] = $pageCount;
			$pages = array_values(array_unique($pages));
			sort($pages);
			$previousPage = 0;
			foreach ($pages as $i) {
				if ($previousPage > 0 && $i > $previousPage + 1) {
					$navString .= '... ';
				}
				$navString .= $i == $pageNum ? '<span>' . $i . '</span> ' : '<a href="' . $baseUrl . 'PAGEN_1=' . $i . '">' . $i . '</a> ';
				$previousPage = $i;
			}
			$navString .= $pageNum < $pageCount ? '| <a href="' . $baseUrl . 'PAGEN_1=' . ($pageNum + 1) . '">След.</a> | <a href="' . $baseUrl . 'PAGEN_1=' . $pageCount . '">Конец</a>' : '| След. | Конец';
		}
		$navString .= '</div>';
		$arResult["NAV_STRING"] = $navString;
	}
	
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
	
