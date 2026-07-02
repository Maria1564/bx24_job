<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Loader;

Loader::includeModule("highloadblock");

use Bitrix\Highloadblock as HL;

class SmsvoteComponent extends CBitrixComponent {



	public function executeComponent() {
		if ($this->startResultCache()) {
			$this->includeComponentTemplate();
		}
	}

}

?>