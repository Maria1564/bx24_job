<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Loader;

Loader::includeModule("highloadblock");

use Bitrix\Highloadblock as HL;

class ServiceListComponent extends CBitrixComponent {

	private function addItems() {

	}

	public function executeComponent() {
		global $USER;
	
	
		if ($this->startResultCache()) {
			$this->addItems();
			$this->includeComponentTemplate();
		}
	}

}

?>