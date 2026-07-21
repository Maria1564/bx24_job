<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
/*
 * CONSULT ADD FORM
 */
class ConsulComponent extends CBitrixComponent {

	private function addItems() {
		if (!isset($_POST['NAME']))
			return;
		$s = strtotime($_REQUEST['DATE']);
		$_REQUEST['DATE_ACTIVE_FROM'] = date('d.m.Y', $s) . ' ' . $_REQUEST['TIME'];
		$_REQUEST['PROPERTY']['TYPE'] = Service::TYPE_CONSALT_ID;
		if($_REQUEST['PROPERTY']['SERVICE']==""){
			//$this->arResult['ERROR']
		}
		$_REQUEST['PROPERTY']['CREATED'] = "SITE";
		$arResutl = Service::save($_REQUEST);
		$this->arResult["error"] = $arResutl['error'];
		//l($arResutl);
		//TYPE
		if($this->arParams['ACTION'] == 'ADD'){
		    	header('location:/consult/edit/?id=' . $arResutl['ID'] . '&success=y');
			exit;
		}
		if($this->arParams['ACTION'] == 'EDIT'){
		    	header('location:/consult/edit/?id=' . $arResutl['ID'] . '&success=y');
			exit;
		}
		if ($arResutl['newRecord']) {
			
		}
		if (isset($_POST['BTN_UPDATE'])) {
			//header('location:/service/' . $arResutl['ID'] . '/');
			//exit;
		}

		//header('location:?action=success&id=' . $arResutl['ID']);
		//header('location:/clients/' . $arResutl['CLIENT_ID'] . '/');
	}

	public function executeComponent() {
		global $USER;
		$this->addItems();
		//Если в запросе есть ID услуги

		if ($_REQUEST['service_id'] > 0 && $this->arParams['ACTION'] == 'ADD') {
			// Услуга
			$this->arResult['PROPERTY']["SERVICE"] = Service::getServiceById($_REQUEST['service_id']);
			// Клиент
			$clientID = $this->arResult['PROPERTY']["SERVICE"]['PROPERTIES']['CLIENT']['VALUE'];
			$this->arResult["CLIENT"] = Client::getClientById($clientID);
			// Менеджер
		}

		if ($_REQUEST['id'] > 0) {
			$this->arResult["SERVICE"] = Service::getServiceById($_REQUEST['id']);
			$this->setData($this->arResult["SERVICE"]);
			//Если у консультации есть связь со услугой то получаем данные
			$linkedServiceID = $this->arResult["SERVICE"]['PROPERTIES']['SERVICE']['VALUE'];
			if($linkedServiceID>0){
			   $this->arResult['PROPERTY']["SERVICE"] = Service::getServiceById($linkedServiceID);
			}
			//l($this->arResult["CLIENT"] );
		}
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
	//	l($allManager);
		//l($manager_id);
		$this->arResult["MANAGER"] = $allManager[$manager_id];
		if ($this->startResultCache()) {

			$this->includeComponentTemplate();
		}
	}

	public function setData($arInput) {


		//l($arInput);
		$_REQUEST['NAME'] = $arInput['NAME'];
		$_REQUEST['PREVIEW_TEXT'] = $arInput['PREVIEW_TEXT'];

		$s = strtotime($arInput['DATE_ACTIVE_FROM']);
		$_REQUEST['DATE'] = date('Y-m-d', $s);
		$_REQUEST['TIME'] = date('H:i', $s);

		foreach ($arInput['PROPERTIES'] as $code => $arr) {
			$_REQUEST['PROPERTY'][$code] = $arr['VALUE'];
		}
		$_REQUEST['client_id'] = $arInput['PROPERTIES']['CLIENT']['VALUE'];
	}

}

?>
