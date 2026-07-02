<?php

foreach ($arResult["ITEMS"] as &$arItem) {
	//Получаем все не закрытые задачи для клиента
	$arItem['ACTIVE_WORKS_COUNT'] = Client::getActiveServicesCount($arItem['ID']);
	$arItem['SERVICE_COUNT'] = Client::getAllervicesCount($arItem['ID']);

	//Послдний контакт
	$arItem['LAST_CONTACT_DATE'] = getLastActiveDataS($arItem['ID']);
}



