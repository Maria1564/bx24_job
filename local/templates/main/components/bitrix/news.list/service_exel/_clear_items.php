<?
	/*
		Очищаем массив от лишних полей.
		Так как при формировании итогового файла
		просиходит переполнение памяти
	*/
	$arTemp = [];
	foreach ($arResult["ITEMS"] as $i => $arItem) {
		
		$arTemp[$i] = [
		"NAME" => $arItem["NAME"],
		"TYPE" => !empty($arItem['IS_EVENT']) ? 'мероприятие' : ($arItem['PROPERTIES']['TYPE']['VALUE_XML_ID']== 'CONSULT'?'консультация':'услуга'),
		"IS_EVENT" => !empty($arItem['IS_EVENT']),
		"PREVIEW_TEXT" => $arItem["PREVIEW_TEXT"],
		"DATE_ACTIVE_FROM" => $arItem["DATE_ACTIVE_FROM"],
		"DATE_ACTIVE_TO" => $arItem["DATE_ACTIVE_TO"],
		];
		
		$arTemp[$i]['PROPERTIES']['SMS_VOTE']['VALUE'] = $arItem['PROPERTIES']['SMS_VOTE']['VALUE'];	
		$arTemp[$i]['PROPERTIES']['CLIENT']['VALUE'] = $arItem['PROPERTIES']['CLIENT']['VALUE'];	
		$arTemp[$i]['PROPERTIES']['BLUE_CLIENT']['VALUE'] = $arItem['PROPERTIES']['BLUE_CLIENT']['VALUE'];
		$arTemp[$i]['PROPERTIES']['DIRECTION']['VALUE'] = $arItem['PROPERTIES']['DIRECTION']['VALUE'];
		$arTemp[$i]['PROPERTIES']['MANAGER']['VALUE'] = $arItem['PROPERTIES']['MANAGER']['VALUE'];
		$arTemp[$i]['PROPERTIES']['STATUS']['VALUE'] = $arItem['PROPERTIES']['STATUS']['VALUE'];
		$arTemp[$i]['PROPERTIES']['MONEY']['VALUE'] = $arItem['PROPERTIES']['MONEY']['VALUE'];
		$arTemp[$i]['PROPERTIES']['MONEY2']['VALUE'] = $arItem['PROPERTIES']['MONEY2']['VALUE'];
		$arTemp[$i]['PROPERTIES']['MONEY3']['VALUE'] = $arItem['PROPERTIES']['MONEY3']['VALUE'];
		$arTemp[$i]['PROPERTIES']['FINANCE_SOURCE']['VALUE'] = $arItem['PROPERTIES']['FINANCE_SOURCE']['VALUE'];
		
		$arTemp[$i]['PROPERTIES']['CLIENT_REFUSED']['VALUE'] = $arItem['PROPERTIES']['CLIENT_REFUSED']['VALUE'];
		$arTemp[$i]['PROPERTIES']['BX24_STATUS_EXT']['VALUE'] = $arItem['PROPERTIES']['BX24_STATUS_EXT']['VALUE'];
	}
	
$arResult["ITEMS"] = $arTemp;
