<?php

use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\UserTable as CUser;

class HLClass {

	var $HL_ID = 4;

	var $entity = null;

	function __construct() {
		Loader::includeModule("highloadblock");
		Loader::includeModule("main");
		$hlblock = HL\HighloadBlockTable::getById($this->HL_ID)->fetch();
		$this->entity = HL\HighloadBlockTable::compileEntity($hlblock);
	}

	public function getList($arFilter = []) {
		$entity_data_class = $this->entity->getDataClass();
		$rsData = $entity_data_class::getList(
				[
					"select" => array("*"),
					"order" => array("ID" => "DESC"),
					"filter" => $arFilter
		]);
		//Если есть то обновляем
		while ($arData = $rsData->Fetch()) {
			$arResult[$arData["ID"]] = $arData;
		}
		return $arResult;
	}

	public static function remove($arr) {
		
	}

	public function get($CODE) {
		global $USER;
		$entity_data_class = $this->entity->getDataClass();
		$rsData = $entity_data_class::getList(
				array("select" => array("*"),
					"order" => array("ID" => "ASC"),
					"filter" => array(
						"UF_CODE" => $CODE,
						'UF_USER_ID' => $USER->GetID())
				)
		);

		//Если есть то обновляем
		if ($arData = $rsData->Fetch()) {
			return json_decode($arData['UF_VALUE'],true);
		}
		return false;
	}
	
	public function add($CODE, $VALUE) {
		global $USER;
		$entity_data_class = $this->entity->getDataClass();
		$rsData = $entity_data_class::getList(
				array("select" => array("*"),
					"order" => array("ID" => "ASC"),
					"filter" => array(
						"UF_CODE" => $CODE,
						'UF_USER_ID' => $USER->GetID())
				)
		);

		//Если есть то обновляем
		if ($arData = $rsData->Fetch()) {
			$entity_data_class::update($arData['ID'], ["UF_VALUE" => json_encode($VALUE)]);
		}
		//Добавляем
		else {
			$entity_data_class::add([
				"UF_CODE" => $CODE,
				'UF_USER_ID' => $USER->GetID(),
				"UF_VALUE" => json_encode($VALUE)]
			);
		}
	}

}
