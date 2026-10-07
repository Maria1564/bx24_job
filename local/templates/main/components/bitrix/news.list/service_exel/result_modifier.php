<?php
	
	header('Content-Type: application/json');
	global $USER;
	
	$isConsultPage = $GLOBALS['arFilter']['PROPERTY_TYPE'] == Service::TYPE_CONSALT_ID?true:false;
	
	$filePath = $_SERVER['DOCUMENT_ROOT'] . "/upload/excel_processing/" . $USER->GetID() . ".json";
	$folder = $_SERVER['DOCUMENT_ROOT'] . "/upload/excel_processing/" . $USER->GetID().'/';
	
	//Параметры фильтров
	$DATE_TO =  false;
	if($_REQUEST['DATE_TO']){
	    $s = strtotime($_REQUEST['DATE_TO']);
		$DATE_TO = date('d.m.Y 23:59:59', $s);
	}
	
	$DATE_FROM =  false;
	if($_REQUEST['DATE_FROM']){
	    $s = strtotime($_REQUEST['DATE_FROM']);
		$DATE_FROM = date('d.m.Y 00:00:01', $s);
	}

	if ($arParams['ALL_DATA_PAGE'] == 'Y') {
		$serviceFilter = (array)$GLOBALS[$arParams["FILTER_NAME"]];
		$serviceFilter['IBLOCK_ID'] = IBLOCK_ID_SERVICE;
		$serviceFilter['ACTIVE'] = 'Y';

		$combinedItems = [];
		$rsServices = CIBlockElement::GetList(
			[$_SESSION['sort']['name'] ?: 'DATE_ACTIVE_FROM' => $_SESSION['sort']['order'] ?: 'DESC'],
			$serviceFilter,
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
		while ($obService = $rsServices->GetNextElement()) {
			$fields = $obService->GetFields();
			$fields['PROPERTIES'] = $obService->GetProperties();
			$combinedItems[] = $fields;
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

		$arEventItems = [];
		$rsEvents = CIBlockElement::GetList(
			[$_SESSION['sort']['name'] ?: 'DATE_ACTIVE_FROM' => $_SESSION['sort']['order'] ?: 'DESC'],
			$arEventFilter,
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
		while ($event = $rsEvents->Fetch()) {
			$eventId = (int)$event['ID'];
			if (!isset($arEventItems[$eventId])) {
				$arEventItems[$eventId] = [
					'ID' => $eventId,
					'IBLOCK_ID' => (int)$event['IBLOCK_ID'],
					'NAME' => $event['NAME'],
					'PREVIEW_TEXT' => $event['PREVIEW_TEXT'],
					'DATE_ACTIVE_FROM' => $event['DATE_ACTIVE_FROM'],
					'ACTIVE_FROM' => $event['ACTIVE_FROM'],
					'DATE_ACTIVE_TO' => $event['DATE_ACTIVE_TO'],
					'ACTIVE_TO' => $event['ACTIVE_TO'],
					'IS_EVENT' => true,
					'PROPERTIES' => [
						'CONTACT' => ['VALUE' => []],
						'MANAGER' => ['VALUE' => $event['PROPERTY_MANAGER_VALUE']],
						'STATUS' => ['VALUE' => $event['PROPERTY_STATUS_VALUE']],
						'TYPE' => [
							'VALUE_XML_ID' => 'EVENT',
							'VALUE_ENUM' => 'Мероприятие',
						],
						'CLIENT' => ['VALUE' => ''],
						'SMS_VOTE' => ['VALUE' => ''],
						'BLUE_CLIENT' => ['VALUE' => ''],
						'DIRECTION' => ['VALUE' => ''],
						'MONEY' => ['VALUE' => ''],
						'MONEY2' => ['VALUE' => ''],
						'MONEY3' => ['VALUE' => ''],
						'FINANCE_SOURCE' => ['VALUE' => ''],
						'CLIENT_REFUSED' => ['VALUE' => ''],
						'BX24_STATUS_EXT' => ['VALUE' => ''],
					],
				];
			}
			if ($event['PROPERTY_CONTACT_VALUE']) {
				$arEventItems[$eventId]['PROPERTIES']['CONTACT']['VALUE'][] = $event['PROPERTY_CONTACT_VALUE'];
			}
		}

		$arResult["ITEMS"] = array_merge($combinedItems, array_values($arEventItems));
		usort($arResult["ITEMS"], function ($a, $b) {
			$sortName = $_SESSION['sort']['name'] ?: 'DATE_ACTIVE_FROM';
			$sortOrder = $_SESSION['sort']['order'] ?: 'DESC';
			if ($sortName == 'NAME') {
				$result = strcasecmp($a['NAME'], $b['NAME']);
			} else {
				$result = MakeTimeStamp($a['DATE_ACTIVE_FROM']) <=> MakeTimeStamp($b['DATE_ACTIVE_FROM']);
			}
			return $sortOrder == 'ASC' ? $result : -$result;
		});
		$arResult['NAV_RESULT'] = (object)[
			'PAGEN' => 1,
			'SIZEN' => max(count($arResult["ITEMS"]), 1),
			'NavRecordCount' => count($arResult["ITEMS"]),
		];
	}
	
	
	
	/* 
		Вычисляем уникальнось клиента
		Используется только для  выгрузки консультаций
		
	*/
	require '_unique_client.php';
	require '_clear_items.php';
	
	$raiting = new Raiting();
	
	foreach ($arResult["ITEMS"] as &$arItem) {
		$arItem = clearFileds( $arItem);
		$arItem['PROPERTIES'] = clearPropertyArray(  $arItem['PROPERTIES']);
		
		if($arItem['PROPERTIES']['CLIENT']['VALUE']){
			$arClient =  Client::getClientById($arItem['PROPERTIES']['CLIENT']['VALUE']);
			$arClient['TYPE_NAME_INN'] = str_replace("ИНН:","",$arClient['TYPE_NAME_INN']);
			$arClient['TYPE_NAME_INN'] = str_replace("quot;",'"',$arClient['TYPE_NAME_INN']);
			if(strpos($arClient['TYPE_NAME_INN'],'ООО')!==false){
				$arClient['PROPERTIES']['ORG_TYPE']['VALUE'] = "ООО";
			}
			if(strpos($arClient['TYPE_NAME_INN'],'ИП')!==false){
	            $arClient['PROPERTIES']['ORG_TYPE']['VALUE'] = "ИП";
			}
			$arItem['CLIENT'] = [
			'TYPE_NAME_INN' => $arClient['TYPE_NAME_INN'],
			'NAME' => $arClient['NAME'],
			'INN' => $arClient['PROPERTIES']['INN']['VALUE'],
			'EMAIL' => $arClient['PROPERTIES']['EMAIL']['VALUE'],
			'PHONE' => $arClient['PROPERTIES']['PHONE']['VALUE'],
			'ORG_TYPE' =>$arClient['PROPERTIES']['ORG_TYPE']['VALUE'],
			'ADDRESS' =>$arClient['PROPERTIES']['ADDRESS']['VALUE'],
			'BLUE_CLIENT' => $arClient['PROPERTIES']['BLUE_CLIENT']['VALUE'],
			];
		}	
		$arItem['RAITING'] =  $raiting->getServiceRaitingArray($arItem['ID']);		
	}
	
	if($_REQUEST['ACTION']!='MAKE_FILE'){
		if ( ($arResult['NAV_RESULT']->PAGEN-1) * $arResult['NAV_RESULT']->SIZEN < $arResult['NAV_RESULT']->NavRecordCount){			
			if (!file_exists($folder)) {     
				mkdir($folder, 0777, true); 
			}
			$filePath = $folder.''.$arResult['NAV_RESULT']->PAGEN. ".json";
			if($arResult['NAV_RESULT']->PAGEN == 1){
				clearFolder($folder);
			}			
			file_put_contents($filePath , json_encode($arResult["ITEMS"]));
			echo json_encode([
			"MODE"=>"PROCESSING",
			"COUNT"=>count($arr),
			"COUNT2"=>count($arResult["ITEMS"]),
			"PAGEN" =>$arResult['NAV_RESULT']->PAGEN,
			"SIZEN" =>$arResult['NAV_RESULT']->SIZEN,
			"NAV_RESULT" =>(int)($arResult['NAV_RESULT']->NavRecordCount),
			]);
			exit;
			
		}
	}
	
	//Если все данные закешировались!
	if( $_REQUEST['ACTION']=='MAKE_FILE' || (($arResult['NAV_RESULT']->PAGEN-1) * $arResult['NAV_RESULT']->SIZEN >= $arResult['NAV_RESULT']->NavRecordCount )  ){
		//Получаем все данные из папки 
		$arResult["ITEMS"] = [];
		foreach (glob($folder.'*') as $file) {
			if($file){
				$f = file_get_contents($file);
				$arr = json_decode(file_get_contents($file) , true);
				if($arr){
					$arResult["ITEMS"] = array_merge(  $arr,$arResult["ITEMS"]);
				}
			}
		}		
	}
	
	
	
	function clearFolder($folder) {
		if (file_exists($folder)) {
			foreach (glob($folder.'*') as $file) {
				unlink($file);
			}
		}
	}
