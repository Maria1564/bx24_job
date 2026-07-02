<?php

use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\UserTable as CUser;

/*
 * Класс для  реализации функционала изрбранное
 */

class ChangeHistory {

	var $HL_ID = 4;

	//Обьект записи

	const ACTION_ADD = "add";
	const ACTION_EDIT = "edit";
	const ACTION_DELETE = "delete";
	const OBJECT_TYPE_IBLOCK = 1;

	function __construct() {
		Loader::includeModule("highloadblock");
		Loader::includeModule("main");
		$hlblock = HL\HighloadBlockTable::getById($this->HL_ID)->fetch();
		$this->entity = HL\HighloadBlockTable::compileEntity($hlblock);
	}

	public static function getLastContactForClinet($clinet_id) {
		$arFilter = [
			"UF_OBJECT" => ["LOGINC" => "OR", "IBLOCK_ID=" . IBLOCK_ID_SERVICE, "IBLOCK_ID=" . IBLOCK_ID_SERVICE],
			"UF_OBJECT_ID" => $clinet_id,
		];
		$entity_data_class = $this->entity->getDataClass();
		$rsData = $entity_data_class::getList(
				[
					"select" => array("*"),
					"order" => array("ID" => "DESC"),
					"filter" => $arFilter,
					"limit" => 1,
		]);
		if ($arData = $rsData->Fetch()) {
			l($arData);
		}
	}

	public function getLastModificationsForService($id) {
		$arFilter = [
			 //"UF_OBJECT" => "IBLOCK_ID=" . IBLOCK_ID_SERVICE,
			"UF_OBJ_ID" => $id,
		];
		$entity_data_class = $this->entity->getDataClass();
		$rsData = $entity_data_class::getList(
				[
					"select" => array("*"),
					"order" => array("ID" => "DESC"),
					"filter" => $arFilter,
					"limit" => 30,
		]);
		$allManagers = Helper::getManagers();
		while ($arData = $rsData->Fetch()) {
			$arResult[$arData["ID"]] = $arData;

			$objectText = '';
			$arValue = json_decode($arData['UF_VALUE'], true);
			if ($arData['UF_OBJECT'] == 'IBLOCK_ID=2') {
				
			}
			$text = '';
			if ($arValue['service_type'] == 'service') {
				$text = ' услугу';
			}
			if ($arValue['service_type'] == 'consult') {
				$text = ' консультацию';
			}
			if(isset($arValue['DATE_ACTIVE_TO'])){
				$text = ' изменил статус';
				if($arValue['DATE_ACTIVE_TO']!=""){
					$text.= ' на "закрыт"';
				}else {
					$text.= ' на "открыт"';
				}
			}
			if($arData['UF_FIELD_NAME']=='raiting'){
				$text = ' изменил оценку';
			}
			$arResult[$arData["ID"]] = date("d-m-Y H:i:s", $arData['UF_DATE_TIMESTAMP']) . " " .
				$allManagers[$arData["UF_USER_ID"]]["FIO"] . " 
				" . $this->getActionTextById($arData["UF_ACTION"]) . " " . $text;
		}
		return $arResult;
	}

	public function getActionTextById($UF_ACTION) {
		if ($UF_ACTION == ChangeHistory::ACTION_ADD)
			return 'создал(a)';
		if ($UF_ACTION == ChangeHistory::ACTION_EDIT)
			return 'изменил(a)';
		if ($UF_ACTION == ChangeHistory::ACTION_DELETE)
			return 'удалил(a)';
	}

	public static function setCustomAction($action){
		$_SESSION['ch_action'] = $action;
		
	}
	public function add($object, $action, $fileName, $value, $id) {
		global $USER;
		$entity_data_class = $this->entity->getDataClass();
		if($_SESSION['ch_action']!=""){
			$action = $_SESSION['ch_action'];
		}
		$resutlt = $entity_data_class::add([
				//"UF_DATE" => date("Y-m-d H:i:s"),
				'UF_DATE_TIMESTAMP' => time(),
				"UF_USER_ID" => $USER->GetID(),
				'UF_OBJECT' => $object,
				"UF_ACTION" => $action,
				"UF_FIELD_NAME" => $fileName,
				'UF_VALUE' => $value,
				'UF_OBJ_ID' => $id,
				]
		);
		$_SESSION['ch_action'] = "";
		//l(date("Y-m-d H:i:s"));
		//l($resutlt);
	}

}
