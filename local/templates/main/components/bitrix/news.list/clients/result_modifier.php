<?php

foreach ($arResult["ITEMS"] as &$arItem) {
	//Получаем все не закрытые задачи для клиента
	$arItem['ACTIVE_WORKS_COUNT'] = Client::getActiveServicesCount($arItem['ID']);
	$arItem['SERVICE_COUNT'] = Client::getServiceCountDone($arItem['ID']);
   $arItem['CONSULT_COUNT'] = Client::getConsultCount($arItem['ID']);
	//Послдний контакт
	$arItem['LAST_CONTACT_DATE'] = getLastActiveData($arItem['ID']);
}

function getLastActiveData($id) {
	//
	//l($id);
	$res = CIBlockElement::GetList(
			['DATE_ACTIVE_FROM' => 'DESC'], ['IBLOCK_ID' => IBLOCK_ID_SERVICE, 'PROPERTY_CLIENT' => $id], false, ['nPageSize' => 1], array('IBLOCK_ID', 'ID'));
	if ($el = $res->Fetch()) {
		return $el['ACTIVE_FROM'];
	}
	return '';
}

