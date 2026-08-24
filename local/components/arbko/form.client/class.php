<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

class ServiceListComponent extends CBitrixComponent {

	private function addItems() {

		if (!isset($_REQUEST['NAME']))
			return;
		//l($_REQUEST);
		//exit;
	
		if ($_REQUEST['PROPERTY']['ORG_TYPE'] == "INDIVIDUAL") {
			//$_REQUEST['PROPERTY']['ORG_TYPE'] = Client::ORG_TYPE_INDIVIDUAL_ID;
		} else {
			//$_REQUEST['PROPERTY']['ORG_TYPE'] = Client::ORG_TYPE_OOO_ID;
		}
		//Если не заполнен ИНН то клиент становится ФИЗ лицом
		if ($_REQUEST['PROPERTY']['INN'] == "" && $_REQUEST['PROPERTY']['ORG_TYPE'] != Client::ORG_TYPE_FIZ_ID) {
			//$_REQUEST['PROPERTY']['ORG_TYPE'] = Client::ORG_TYPE_FIZ_ID;
		}
		
		
		
		if ($_REQUEST['client_id'] == null) {
			//$_REQUEST['DATE_ACTIVE_FROM'] = date('d.m.Y H:i:s');
		}
		$_REQUEST['PROPERTY']['CREATED'] = "SITE";
		
		
		// fixed 26/01/2026 - номер "Общий контакт клиента"
		// заменяем на full номер плагина js
		if(isset($_REQUEST["phone_full"]) && !empty($_REQUEST["phone_full"])){
			$_REQUEST['PROPERTY']['PHONE'] = $_REQUEST["phone_full"];
		}

		$requiredFields = [
			'NAME' => 'Название ИП или организации',
			'PROPERTY.INN' => 'ИНН',
			'PROPERTY.CONTACT_NAME' => 'Общий контакт клиента: имя',
			'PROPERTY.PHONE' => 'Общий контакт клиента: телефон',
			'PROPERTY.EMAIL' => 'Общий контакт клиента: email',
			'PROPERTY.RAION_NEW' => 'Регион',
			'PROPERTY.OGRN' => 'ОГРН',
			'PROPERTY.ADDRESS' => 'ЮР. АДРЕС',
			'PROPERTY.OKVED' => 'ОКВЭД',
			'PROPERTY.MSP_TYPE' => 'Тип МСП',
			'PROPERTY.DEPARTMENT' => 'Направление',
			'PROPERTY.INDUSTRY' => 'Реальная деятельность',
			'PROPERTY.INDUSTRIAL_SECTORS' => 'Отрасли промышленности',
		];

		$errors = [];
		foreach ($requiredFields as $path => $label) {
			$value = null;
			if ($path === 'NAME') {
				$value = $_REQUEST['NAME'];
			} else {
				$code = substr($path, strlen('PROPERTY.'));
				$value = $_REQUEST['PROPERTY'][$code];
			}
			if (is_array($value)) {
				$value = array_filter($value, function ($item) {
					return trim((string)$item) !== '';
				});
				if (count($value) === 0) {
					$errors[] = $label;
				}
				continue;
			}
			if (trim((string)$value) === '') {
				$errors[] = $label;
			}
		}

		if (!empty($errors)) {
			$this->arResult["error"] = 'Заполните обязательные поля: ' . implode(', ', $errors);
			return false;
		}
		

		$arResutl = Client::save($_REQUEST, false);
		$this->arResult["error"] = $arResutl['error'];
	
		if(isset($_REQUEST['CONTACT'])){
		  foreach($_REQUEST['CONTACT']['NAME'] as $i => $name ){
		     $arContact = [
			  "ID"=>$_REQUEST['CONTACT']['ID'][$i],
			  "NAME"=>$name,
			  "ACTIVE"=>$_REQUEST['CONTACT']['ACTIVE'][$i],
			  "PREVIEW_TEXT"=>$_REQUEST['CONTACT']['PREVIEW_TEXT'][$i],
			  "POST"=>$_REQUEST['CONTACT']['POST'][$i] ?? '',
			  "PHONE"=>$_REQUEST['CONTACT']['PHONE'][$i],
			  "EMAIL"=>$_REQUEST['CONTACT']['EMAIL'][$i],
			  "CLIENT"=>$arResutl['ID'],
			 ];
			 $result = Contact::save($arContact);
		 //  l($arContact);
		   
		  // l($result);
		  }
		
		}
	//	l($_REQUEST);
	//	exit;
		if($this->arResult["error"]!=""){
			return false;
		}
		
		
		
		
		if (isset($_REQUEST['BTN_UPDATE'])) {
			header('location:/clients/edit/?id=' . $arResutl['ID'] . '&success=Y');
			exit;
		}
		if (isset($_REQUEST['BTN_SAVE'])) {
			header('location:/clients/' . $arResutl['ID'] . '/');
			exit;
		}
		if ($arResutl['newRecord'] == "Y" && $arResutl['error'] == false) {

			if (isset($_REQUEST['BTN_SAVE'])) {
				header('location:/clients/' . $arResutl['ID'] . '/');
			}
			if (isset($_REQUEST['BTN_ADD_AND_ADD_SERVICE'])) {
				header('location:/service/add/?client_id=' . $arResutl['ID'] . '/');
			}
			if (isset($_REQUEST['BTN_ADD_AND_ADD_CONSALT'])) {
				header('location:/consult/add/?client_id=' . $arResutl['ID'] . '/');
			}
		}
		//
	}

	public function executeComponent() {
		global $USER;
		$this->addItems();
		if ($_REQUEST['id'] > 0) {
			$this->arResult["CLIENT"] = Client::getClientById($_REQUEST['id'],false);
			$this->setData($this->arResult["CLIENT"]);
			//l($this->arResult["CLIENT"] );
		}
		$allManager = Helper::getManagers();
		$manager_id = 0;
		if ($_REQUEST['PROPERTY']['MANAGER'] > 0) {
			$manager_id = $_REQUEST['PROPERTY']['MANAGER'];
		} else {
			$manager_id = 0;
		}
		$this->arResult["MANAGER"] = $allManager[$manager_id];
		if ($this->startResultCache()) {

			$this->includeComponentTemplate();
		}
	}

	public function setData($arInput) {
		//l($arInput);
		
		foreach ($arInput['PROPERTIES'] as $code => $arr) {

			if ($arr['PROPERTY_TYPE'] == "L") {
				$arr['VALUE'] = $arr['VALUE_ENUM_ID'];
			}
			if ($code == "CONTACTS" && count($arr['VALUE']) > 0) {
				//l($arr['VALUE']);
				foreach ($arr['~VALUE'] as $val) {
					//l($val);
					$value = json_decode($val, true);
					//l($value);
					$_REQUEST["CONTACTS"]["NAME"] = $value['name'];
					$_REQUEST["CONTACTS"]["PHONE"] = $value['phone'];
					$_REQUEST["CONTACTS"]["EMAIL"] = $value['email'];
					
					//$_REQUEST['PROPERTY']["PHONE"] = $value['phone'];
				}
				continue;
			}
			$_REQUEST['PROPERTY'][$code] = $arr['VALUE'];
		}
		$_REQUEST['NAME'] = $arInput['NAME'];
		$_REQUEST['PREVIEW_TEXT'] = $arInput['PREVIEW_TEXT'];
	}

}

?>
