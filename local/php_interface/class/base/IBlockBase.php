<?php

/*
 * Класс для  реализации функционала изрбранное
 */

class IBlockBase {

	const STATUS_ACTIVE = 1;
	const STATUS_CLOSED = 2;
	const TYPE_SERVICE = 'SERVICE';
	const TYPE_CONSALT = 'CONSULT';
	const TYPE_SERVICE_ID = 1;
	const TYPE_CONSALT_ID = 2;

	public static $statuses = [
		self::STATUS_ACTIVE => "в работе",
		self::STATUS_CLOSED => "завершен"
	];

	public static function save($arInput) {

		$ELEMENT_ID = $arInput['ID'];

		$arItem = false;
		if ($ELEMENT_ID > 0) {
			$rsItems = CIBlockElement::GetList(
				[], 
				array('IBLOCK_ID' => IBLOCK_ID_SERVICE, "ID" => $ELEMENT_ID), false, false, array());
			$arItem = $rsItems->GetNext();
		}
		$el = new CIBlockElement;
		$arLoadProductArray = [];
		$arLoadProductArray['PROPERTY_VALUES'] = $arInput['PROPERTY'];
		$arLoadProductArray['IBLOCK_ID'] = IBLOCK_ID_SERVICE;
		$arLoadProductArray['ACTIVE'] = "Y";
		$arLoadProductArray['DATE_ACTIVE_FROM'] = $arInput['DATE_ACTIVE_FROM'];
		$arLoadProductArray['NAME'] = $arInput['NAME'];
		$arLoadProductArray['PREVIEW_TEXT'] = $arInput['PREVIEW_TEXT'];
		$arLoadProductArray['PROPERTY_VALUES']['STATUS'] = Service::STATUS_ACTIVE;
		$arLoadProductArray['PROPERTY_VALUES']['TYPE']['VALUE'] = Service::TYPE_SERVICE_ID;

		l($arLoadProductArray);
		$newRecord = "N";
		if (!$arItem) {
			$newRecord = "Y";
			$ELEMENT_ID = $el->Add($arLoadProductArray);
		} else {
			$res = $el->Update($arItem['ID'], $arLoadProductArray);
			//echo '<br>Есть запись ID: ' . $arItem['ID'] . ' : ' . $data['offerId'].' Данны обновлены '.$updText;		
		}
		return [
			'newRecord' => $newRecord,
			'ID' => $ELEMENT_ID,
		];
	}

}
