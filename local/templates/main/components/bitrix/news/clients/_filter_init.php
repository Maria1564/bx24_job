<?php

/**
 * Формирование фильтра для компонента список новостей.
 */
if ($_REQUEST['t']) {
	$_REQUEST['q'] = $_REQUEST['t'];
	$APPLICATION->IncludeComponent("bitrix:search.page", "get-array", Array(
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_TIME" => "0",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DEFAULT_SORT" => "rank",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "Y",
		"FILTER_NAME" => "",
		"NO_WORD_LOGIC" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Результаты поиска",
		"PAGE_RESULT_COUNT" => "1000",
		"RESTART" => "Y",
		"SHOW_WHEN" => "N",
		"SHOW_WHERE" => "N",
		"USE_LANGUAGE_GUESS" => "Y",
		"USE_SUGGEST" => "N",
		"USE_TITLE_RANK" => "Y",
		"arrFILTER" => array(
			1 => "iblock_clients",
		),
		"arrFILTER_iblock_catalog" => array(0 => "all",),
		"arrFILTER_iblock_clients" => array("1"),
		"arrWHERE" => ""
		), false
	);
	//l($GLOBALS['arSearchResult']);
	if (count($GLOBALS['arSearchResult']) > 0) {
		foreach ($GLOBALS['arSearchResult'] as $arr) {
			$GLOBALS[$arParams["FILTER_NAME"]]['ID'][] = $arr['ITEM_ID'];
		}
	} else {
		$GLOBALS[$arParams["FILTER_NAME"]]['ID'] = false;
	}
}

if ($_REQUEST['DATE_FROM']) {
	$s = strtotime($_REQUEST['DATE_FROM']);
	//$GLOBALS[$arParams["FILTER_NAME"]]['>=DATE_ACTIVE_FROM'] = date('d.m.Y 00:00:01', $s);
	$GLOBALS[$arParams["FILTER_NAME"]]['>=DATE_CREATE'] = date('d.m.Y 00:00:01', $s);
}
if ($_REQUEST['DATE_TO']) {
	$s = strtotime($_REQUEST['DATE_TO']);
	//$GLOBALS[$arParams["FILTER_NAME"]]['<=DATE_ACTIVE_FROM'] = date('d.m.Y 23:59:01', $s);
	$GLOBALS[$arParams["FILTER_NAME"]]['<=DATE_CREATE'] = date('d.m.Y 23:59:01', $s);
}
if ($_REQUEST['SERVICE_TYPE']) {
	if ($_REQUEST['SERVICE_TYPE'] == "SERVICE") {
		$arSubQuery = Array('IBLOCK_ID' => IBLOCK_ID_SERVICE, 'PROPERTY_TYPE' => Service::TYPE_SERVICE_ID);
	}
	if ($_REQUEST['SERVICE_TYPE'] == "CONSULT") {
		$arSubQuery = Array('IBLOCK_ID' => IBLOCK_ID_SERVICE, 'PROPERTY_TYPE' => Service::TYPE_CONSALT_ID);
	}
	//$arSubQuery = Array('IBLOCK_ID' => IBLOCK_ID_SERVICE, '>PROPERTY_CLIENT' => 0);
	$GLOBALS[$arParams["FILTER_NAME"]][] = [array('ID' => CIBlockElement::SubQuery('PROPERTY_CLIENT', $arSubQuery)),];
}
if ($_REQUEST['WORK_STATUS']) {
	//Есть активности
	if ($_REQUEST['WORK_STATUS'] == "1") {
		$arSubQuery = Array('IBLOCK_ID' => IBLOCK_ID_SERVICE, 'PROPERTY_STATUS' => Service::STATUS_ACTIVE);
		$GLOBALS[$arParams["FILTER_NAME"]][] = [array('ID' => CIBlockElement::SubQuery('PROPERTY_CLIENT', $arSubQuery)),];
	}
	//НЕТ активности
	/*
	 * НУжно получить клиентов у которых все задачи имеют статус закрыт Service::STATUS_CLOSED
	 */
	if ($_REQUEST['WORK_STATUS'] == "2") {
		$arSubQuery = Array('IBLOCK_ID' => IBLOCK_ID_SERVICE, '!=PROPERTY_STATUS' => "");
		$arSubQuery2 = Array('IBLOCK_ID' => IBLOCK_ID_SERVICE, 'PROPERTY_STATUS' => Service::STATUS_ACTIVE);
		$GLOBALS[$arParams["FILTER_NAME"]][] = [
			'LOGIC' => 'AND',
			array('ID' => CIBlockElement::SubQuery('PROPERTY_CLIENT', $arSubQuery)),
			array('!ID' => CIBlockElement::SubQuery('PROPERTY_CLIENT', $arSubQuery2))
		];
	}

	if ($_REQUEST['WORK_STATUS'] == "3") {
		$arSubQuery = Array('IBLOCK_ID' => IBLOCK_ID_SERVICE);
		$GLOBALS[$arParams["FILTER_NAME"]][] = [
			array('!ID' => CIBlockElement::SubQuery('PROPERTY_CLIENT', $arSubQuery)),
		];
	}
}

if ($_REQUEST['DATE_TO']) {
	$s = strtotime($_REQUEST['DATE_TO']);
	$GLOBALS[$arParams["FILTER_NAME"]]['<=DATE_ACTIVE_FROM'] = date('d.m.Y 23:59:59', $s);
}
if ($_REQUEST['MSP']) {
	if ($_REQUEST['MSP'] == "Y") {
		//$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MSP_VALUE'] = "Y";
		$GLOBALS[$arParams["FILTER_NAME"]]['!PROPERTY_MSP_TYPE_VALUE'] = false;
	}

	if ($_REQUEST['MSP'] == "N") {
		$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MSP_VALUE'] = "N";
	}

	if ($_REQUEST['MSP'] == "FALSE") {
		//$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MSP_TEXT'] = "";
		$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MSP'] = false;
		$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_INN'] = false;
		$_REQUEST['INN'] = false;
	}
}
if ($_REQUEST['INN']) {
	if ($_REQUEST['INN'] == "Y") {
		$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_INN'] = "%";
	}
	if ($_REQUEST['INN'] == "N") {
		$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_INN'] = false;
	}
}
// Направление!
if ($_REQUEST['PROP']["DIRECTION"]) {
	//Выбираем всех менеджеров у которых отвед совпадает с выбранным Департаментов
	
	
	/*
	$filer = ["UF_DIRECTIONS" => $_REQUEST['PROP']["DIRECTION"]];
	$sql = CUser::GetList(($by = "id"), ($order = "desc"), $filer);
	*/
	
	/*** fixed 22/04/26 если было выбрано несколько значений,то не работало ******/
	$directions = $_REQUEST['PROP']['DIRECTION'] ?? [];
	// приводим к массиву
	$directions = (array)$directions;
	// чистим
	$directions = array_values(array_filter(array_map('trim', $directions)));

	$filter = [];

	if (!empty($directions)) {
		$or = ['LOGIC' => 'OR'];

		foreach ($directions as $code) {
			$or[] = ['=UF_DIRECTIONS' => $code];        // только одно значение
			$or[] = ['%=UF_DIRECTIONS' => $code . ',%']; // в начале
			$or[] = ['%=UF_DIRECTIONS' => '%,' . $code . ',%']; // в середине
			$or[] = ['%=UF_DIRECTIONS' => '%,' . $code]; // в конце
		}

		$filter[] = $or;
	}

	$sql = Bitrix\Main\UserTable::getList([
		'select' => ['ID', 'NAME', 'LAST_NAME', 'UF_DIRECTIONS'],
		'filter' => $filter,
		'order' => ['ID' => 'DESC'],
	]);
	/*********/

	
	
	
	$arUsersId = [];
	while ($arUser = $sql->Fetch()) {

		$arUsersId[] = $arUser['ID'];
	}
	// l($arUsersId);
	// l($_REQUEST);
	//$_REQUEST['PROP']['MANAGER'] = '';
	if (count($arUsersId) > 0) {

		$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MANAGER'] = $arUsersId;
	} else {

		$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MANAGER'] = -1;
	}
}



if ($_REQUEST['PROP']["5BMANAGER"] > 0) {
	$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MANAGER'] = false;
}


foreach ($_REQUEST['PROP'] as $code => $value) {
	if ($value == "")
		continue;
	$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_' . $code] = $value;
}

// фильтр по уникальности в году
if(!empty($_REQUEST["UNIQUE"])){
	$firstMonth = '01.01.'.$_REQUEST["UNIQUE"]; //начало года
	$lastMonth = '31.12.'.$_REQUEST["UNIQUE"]; //конец года
	
	$l = ConvertTimeStamp(strtotime($firstMonth),"FULL");
	$r = ConvertTimeStamp(strtotime($lastMonth),"FULL");
	
	$arSelect = Array("ID", "IBLOCK_ID", "TIMESTAMP_X", "DATE_ACTIVE_FROM", "DATE_ACTIVE_TO", "PROPERTY_CLIENT");
	$arFilter = Array(
		'IBLOCK_ID' => IBLOCK_ID_SERVICE,
		'ACTIVE' => "Y",
		array(
			"LOGIC" => "OR",
			array(">DATE_ACTIVE_FROM" => $l, "<DATE_ACTIVE_FROM" => $r),
			array(">DATE_ACTIVE_TO" => $l, "<DATE_ACTIVE_TO" => $r),
		),
	);	
	$res = CIBlockElement::GetList(Array("timestamp_x" => "asc"), $arFilter, false, false, $arSelect);
	$test = 0;
	while($ob = $res->GetNextElement())
	{
		$id = $ob->GetFields();
		$arFields[] = $ob->GetFields();
		$id_clients[] = $id["PROPERTY_CLIENT_VALUE"];
		$test++;
	}
	function array_unique_key($array, $key) { 
		$tmp = $key_array = array(); 
		$i = 0; 
	 
		foreach($array as $val) { 
			if (!in_array($val[$key], $key_array)) { 
				$key_array[$i] = $val[$key]; 
				$tmp[$i] = $val; 
			} 
			$i++; 
		} 
		return $tmp; 
	}
	
	
	
	/****** fixed 13/11/24 добавляем клиентов у которых были и мероприятия *******/
	$arSelect_mer = Array("ID", "IBLOCK_ID", "TIMESTAMP_X", "DATE_ACTIVE_FROM", "DATE_ACTIVE_TO", "PROPERTY_CONTACT");
	$arFilter_mer = Array(
		'IBLOCK_ID' => 7,
		'ACTIVE' => "Y",
		array(
			"LOGIC" => "OR",
			array(">DATE_ACTIVE_FROM" => $l, "<DATE_ACTIVE_FROM" => $r),
			array(">DATE_ACTIVE_TO" => $l, "<DATE_ACTIVE_TO" => $r),
		),
	);	
	$res_mer = CIBlockElement::GetList(Array("timestamp_x" => "asc"), $arFilter_mer, false, false, $arSelect_mer);
	$test_mer = 0;
	while($ob_mer = $res_mer->GetNextElement())
	{
		$id_mer = $ob_mer->GetFields();

		$contact_id = $id_mer["PROPERTY_CONTACT_VALUE"];
		$client_info = Contact::getClientContactsId($contact_id);
		
		$id_clients_mer[] = $client_info[0]["CLIENT"];
		$test_mer++;
	}
	if($id_clients_mer)
	$id_clients = array_merge($id_clients,$id_clients_mer);
	
	
	/******* end fixed********/
	
	
	
	//$arFields = array_unique_key($arFields, 'PROPERTY_CLIENT_VALUE');
	
	/*
	foreach($arFields as $v){
		$result1 = $DB->CompareDates($v["DATE_ACTIVE_FROM"], $l); 
	    $result2 = $DB->CompareDates($v["DATE_ACTIVE_FROM"], $r); 
		// дата закрытия
		$result3 = $DB->CompareDates($v["DATE_ACTIVE_TO"], $l); 
	    $result4 = $DB->CompareDates($v["DATE_ACTIVE_TO"], $r); 
		if(($result1 == 1 && $result2 == -1) || ($result3 == 1 && $result4 == -1))
			$id_clients[] = $v["PROPERTY_CLIENT_VALUE"];
	}*/
	
	
	$GLOBALS[$arParams["FILTER_NAME"]]['ID'] = $id_clients;
	if(count($id_clients) == 0)
		$GLOBALS[$arParams["FILTER_NAME"]]['ID'] = 0;


}



$arManagers = Helper::getManagersExt();

$arIndustry = Helper::getOrgIndustry();
$arRegions = Helper::getRegions();
$arDirections = Helper::getDirections();

$arRAION_NEW = Helper::getListValue(Client::CLIENT_IBLOCK_ID, 'RAION_NEW');

?>