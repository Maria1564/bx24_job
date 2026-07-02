<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Loader;

Loader::includeModule("highloadblock");

use Bitrix\Highloadblock as HL;

class ServiceListComponent extends CBitrixComponent {

	private function addItems() {

		if (!isset($_POST['NAME']))
			return;
		$s = strtotime($_REQUEST['DATE']);
		$_REQUEST['DATE_ACTIVE_FROM'] = date('d.m.Y', $s) . ' ' . $_REQUEST['TIME'];
		$arResutl = Service::save($_REQUEST);
		l($arResutl);
		if ($arResutl['newRecord']) {
			
		}
		header('location:?action=success&id=' . $arResutl['ID']);
	}

	public function executeComponent() {
		global $USER;
		if ($_REQUEST['client_id'] > 0) {
			$this->arResult["CLIENT"] = Client::getClientById($_REQUEST['client_id']);
		}
		$allManager = Helper::getManagers();
		$manager_id = 0;
		if ($_REQUEST['PROPERTY']['MANAGER'] > 0) {
			$manager_id = $_REQUEST['PROPERTY']['MANAGER'];
		} else {
			$manager_id = $USER->GetID();
		}
		$this->arResult["MANAGER"] = $allManager[$manager_id];
		if ($this->startResultCache()) {
			$this->addItems();
			$this->includeComponentTemplate();
		}
	}

}

?>