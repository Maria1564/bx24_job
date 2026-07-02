<?php

//Сохраняем изменения в системе в журнале.
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("HCEventClass", "updateEvent"));
AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("HCEventClass", "AddEvent"));

class HCEventClass {

	function updateEvent(&$arFields) {
		log2file('updateEvent', $arFields);
		$ChangeHistory = new ChangeHistory();
		if (isset($arFields['PREVIEW_TEXT'])) {
			$arFields['PREVIEW_TEXT'] = "";
		}
		if (isset($arFields['NAME'])) {
			$arFields['NAME'] = "";
		}
		unset($arFields['WF']);
		unset($arFields['RESULT']);
		unset($arFields['IBLOCK']);
		unset($arFields['ACTIVE']);
		unset($arFields['SEARCHABLE_CONTENT']);
		$ChangeHistory->add("IBLOCK_ID=" . $arFields['IBLOCK_ID'], ChangeHistory::ACTION_EDIT, "0", json_encode($arFields), $arFields['ID']);
	}

	function AddEvent(&$arFields) {
		log2file('AddEvent', $arFields);

		$ChangeHistory = new ChangeHistory();
		$type = $arFields['PROPERTY_VALUES']['TYPE']['VALUE'];
		if ($type == Service::TYPE_SERVICE_ID) {
			$type = 'service';
		}
		if ($type == Service::TYPE_CONSALT_ID) {
			$type = 'consult';
		}
		
		$ChangeHistory->add("IBLOCK_ID=" . $arFields['IBLOCK_ID'], ChangeHistory::ACTION_ADD, "0", json_encode(['service_type' => $type]), $arFields['ID']);
	}

}
