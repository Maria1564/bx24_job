<?php

/*
 * Класс для  реализации функционала изрбранное
 */

class Client {

	const CLIENT_IBLOCK_ID = 1;
	const ORG_TYPE_INDIVIDUAL_ID = 4;
	const ORG_TYPE_OOO_ID = 3;
	const ORG_TYPE_KFX_ID = 8;
	const ORG_TYPE_OTHER_ID = 9;
	const ORG_TYPE_FIZ_ID = 10;
	const ORG_TYPE_SZ_ID = 16;

	/**
	 * Возращает код рабечего статуса клиента
	 * @param type $id
	 * @return type int
	 */
	public static function getActiveServicesCount($idCLient) {
		$res = CIBlockElement::GetList(false, ['IBLOCK_ID' => IBLOCK_ID_SERVICE, 'PROPERTY_CLIENT' => $idCLient, 'PROPERTY_STATUS' => Service::STATUS_ACTIVE], array('IBLOCK_ID'));
		if ($el = $res->Fetch()) {
			return $el['CNT'];
		}
		return 0;
	}

	/**
	 * Возвращает количество услуг и консультаций клиента
	 * @param type $idCLient - iD клиента
	 * @return int - количество записей
	 */
	public static function getAllervicesCount($idCLient) {
		$res = CIBlockElement::GetList(false, ['IBLOCK_ID' => IBLOCK_ID_SERVICE, 'PROPERTY_CLIENT' => $idCLient,''], array('IBLOCK_ID'));
		if ($el = $res->Fetch()) {
			return $el['CNT'];
		}
		return 0;
	}

	/**
	 * Возвращает количество услуг клиента
	 * @param type $idCLient - iD клиента
	 * @return int - количество записей
	 */
	public static function getServiceCount($idCLient) {
		$res = CIBlockElement::GetList(false, ['ACTIVE'=>'Y','IBLOCK_ID' => IBLOCK_ID_SERVICE, 'PROPERTY_CLIENT' => $idCLient, 'PROPERTY_TYPE' => Service::TYPE_SERVICE_ID], array('IBLOCK_ID'));
		if ($el = $res->Fetch()) {
			return $el['CNT'];
		}
		return 0;
	}

	/**
	 * Возвращает количество услуг клиента
	 * @param type $idCLient - iD клиента
	 * @return int - количество записей
	 */
	public static function getServiceCountDone($idCLient) {
		$res = CIBlockElement::GetList(false, ['IBLOCK_ID' => IBLOCK_ID_SERVICE, 'PROPERTY_CLIENT' => $idCLient, 'PROPERTY_TYPE' => Service::TYPE_SERVICE_ID,'PROPERTY_BX24_STATUS_EXT'=>1], array('IBLOCK_ID'));
		if ($el = $res->Fetch()) {
			return $el['CNT'];
		}
		return 0;
	}
	/**
	 * Возвращает количество консультаций клиента
	 * @param type $idCLient - iD клиента
	 * @return int - количество записей
	 */
	public static function getConsultCount($idCLient) {
		$res = CIBlockElement::GetList(false, ['ACTIVE'=>'Y','IBLOCK_ID' => IBLOCK_ID_SERVICE, 'PROPERTY_CLIENT' => $idCLient, 'PROPERTY_TYPE' => Service::TYPE_CONSALT_ID], array('IBLOCK_ID'));
		if ($el = $res->Fetch()) {
			return $el['CNT'];
		}
		return 0;
	}

	public static function hasExpiredContractDeadline($idClient) {
		$idClient = (int)$idClient;
		if ($idClient <= 0) {
			return false;
		}

		$res = CIBlockElement::GetList(
			['active_from' => 'DESC'],
			[
				'ACTIVE' => 'Y',
				'IBLOCK_ID' => IBLOCK_ID_SERVICE,
				'PROPERTY_CLIENT' => $idClient,
				'PROPERTY_TYPE' => Service::TYPE_SERVICE_ID,
				'PROPERTY_STATUS' => Service::STATUS_CLOSED,
			],
			false,
			false,
			[]
		);

		$todayTimestamp = Service::getDateTimestamp(date('d.m.Y'));
		while ($ob = $res->GetNextElement()) {
			$arFields = $ob->GetFields();
			$arProps = $ob->GetProperties();
			$dateFrom = explode(' ', $arFields['DATE_ACTIVE_FROM'])[0];
			$dateTo = explode(' ', $arFields['DATE_ACTIVE_TO'])[0];
			$deadlineDate = Service::calculateDeadline($dateFrom, $dateTo);
			$deadlineTimestamp = Service::getDateTimestamp($deadlineDate);
			if (!$deadlineTimestamp || $deadlineTimestamp >= $todayTimestamp) {
				continue;
			}

			$contractTimestamp = Service::getDateTimestamp($arProps['CONTRACT_PROVIDED_DATE']['VALUE']);
			$isContractProvidedInTime = $arProps['CONTRACT_PROVIDED']['VALUE'] != ''
				&& $contractTimestamp
				&& $contractTimestamp <= $deadlineTimestamp;

			if (!$isContractProvidedInTime) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Возвращает сумму денег
	 * @param type $idCLient - iD клиента
	 * @return int - сумма
	 */
	public static function getMoneyCount($idCLient) {
		$res = CIBlockElement::GetList([], ['IBLOCK_ID' => IBLOCK_ID_SERVICE, 'PROPERTY_CLIENT' => $idCLient, 'PROPERTY_TYPE' => Service::TYPE_SERVICE_ID], false, false, 
		['IBLOCK_ID', 'ID', 'PROPERTY_MONEY','PROPERTY_MONEY2','PROPERTY_MONEY3','PROPERTY_BX24_STATUS_EXT']);
		$money = 0;
		while ($el = $res->Fetch()) {

		if($el['PROPERTY_BX24_STATUS_EXT_VALUE'] ==  1){
			$money += (int)$el['PROPERTY_MONEY_VALUE'];
			$money += (int)$el['PROPERTY_MONEY2_VALUE'];
			$money += (int)$el['PROPERTY_MONEY3_VALUE'];
		}
		}
		return $money;
	}

	public static function save($arInput, $onlyNew = false) {
		$arItem = false;
		$error = false;
		$ELEMENT_ID = $arInput['id'];
		$filter = array('IBLOCK_ID' => Client::CLIENT_IBLOCK_ID, "ID" => $ELEMENT_ID);
		
		//fixed 03/12/24
		if($arInput['PROPERTY']['SZ']=="Y" && $arInput['PROPERTY']['ORG_TYPE'] == 4){ // чекбокс самозанятой и ИП?
			$arInput['PROPERTY']['SZ'] = 17;
		}
		else{
			$arInput['PROPERTY']['SZ'] = 0;
		}
		
		if($arInput['PROPERTY']['BLUE_CLIENT']=="Y"){ // чекбокс голубой клиент?
			$arInput['PROPERTY']['BLUE_CLIENT'] = 22;
		}
		else{
			$arInput['PROPERTY']['BLUE_CLIENT'] = 0;
		}
		
		if($arInput['PROPERTY']['BIG_BUSINESS']=="Y"){ // чекбокс Крупный бизнес?
			$arInput['PROPERTY']['BIG_BUSINESS'] = 54;
		}
		else{
			$arInput['PROPERTY']['BIG_BUSINESS'] = 0;
		}
		
		if($arInput['PROPERTY']['SVO']=="Y"){ // чекбокс Ветеран СВО/член семьи ветерана СВО?
			$arInput['PROPERTY']['SVO'] = 55;
		}
		else{
			$arInput['PROPERTY']['SVO'] = 0;
		}
		
		if($arInput['PROPERTY']['IMPANTIANT']=="Y"){ // чекбокс Импатриант?
			$arInput['PROPERTY']['IMPANTIANT'] = 56;
		}
		else{
			$arInput['PROPERTY']['IMPANTIANT'] = 0;
		}
		
		if($arInput['PROPERTY']['KREATIV']=="Y"){ // чекбокс Креативный предприниматель?
			$arInput['PROPERTY']['KREATIV'] = 57;
		}
		else{
			$arInput['PROPERTY']['KREATIV'] = 0;
		}
		
		if($arInput['PROPERTY']['WOMEN_BUSINESS']=="Y"){ // чекбокс Женское предпринимательство
			$arInput['PROPERTY']['WOMEN_BUSINESS'] = 86;
		}
		else{
			$arInput['PROPERTY']['WOMEN_BUSINESS'] = 0;
		}

		if($arInput['PROPERTY']['OUTBOUND_TOURISM']=="Y"){ // чекбокс Выездной туризм
			$arInput['PROPERTY']['OUTBOUND_TOURISM'] = 87;
		}
		else{
			$arInput['PROPERTY']['OUTBOUND_TOURISM'] = 0;
		}

		if($arInput['PROPERTY']['APK']=="Y"){ // чекбокс АПК
			$arInput['PROPERTY']['APK'] = 88;
		}
		else{
			$arInput['PROPERTY']['APK'] = 0;
		}

		if($arInput['PROPERTY']['ACTIVE_EXPORTER']=="Y"){ // чекбокс Действующий экспортер
			$arInput['PROPERTY']['ACTIVE_EXPORTER'] = 89;
		}
		else{
			$arInput['PROPERTY']['ACTIVE_EXPORTER'] = 0;
		}
		

		if($arInput['PROPERTY']['SX']=="Y"){ // чекбокс голубой клиент?
			$arInput['PROPERTY']['SX'] = 23;
		}
		else{
			$arInput['PROPERTY']['SX'] = 0;
		}
		
		if($arInput['PROPERTY']['OBSHEPIT']=="Y"){ // чекбокс голубой клиент?
			$arInput['PROPERTY']['OBSHEPIT'] = 71;
		}
		else{
			$arInput['PROPERTY']['OBSHEPIT'] = 0;
		}
		
		if ($ELEMENT_ID > 0) {

			$rsItems = CIBlockElement::GetList(
					[],$filter , false, false, array());
			$arItem = $rsItems->GetNext();
		} else {
			/*
			 * Если нет ID 
			 *  и заполнено свойство ИНН проверяем на существование такой компании
			 */
			if ($arInput['PROPERTY']['INN'] > 0) {
				$rsItems = CIBlockElement::GetList(
						[], array('IBLOCK_ID' => Client::CLIENT_IBLOCK_ID, "PROPERTY_INN" => $arInput['PROPERTY']['INN']), false, false, array());
				$arItem = $rsItems->GetNext();
				if ($arItem && $onlyNew) {
					return [
						'newRecord' => "N",
						'ID' => $arItem['ID'],
						'error' => "Клиент с ИНН: " . $arInput['PROPERTY']['INN'] . ' уже существует в базе данных. 
						    <a   href="/clients/' . $arItem['ID'] . '/">Открыть</a>'
					];
				}
			}
			if($arInput['PROPERTY']['BX24_COMPANY_ID'] > 1000000){
		 
		       $rsItems = CIBlockElement::GetList(
						[], array('IBLOCK_ID' => Client::CLIENT_IBLOCK_ID, "BX24_COMPANY_ID" => $arInput['PROPERTY']['BX24_COMPANY_ID']), false, false, array());
				$arItem = $rsItems->GetNext();
		     }
		}
		$el = new CIBlockElement;
		$arLoadProductArray = [];
		$arInput['PROPERTY']['TIME_CREATE'] = time();
		
		$arLoadProductArray['PROPERTY_VALUES'] = $arInput['PROPERTY'];
		$arLoadProductArray['IBLOCK_ID'] = Client::CLIENT_IBLOCK_ID;
		$arLoadProductArray['ACTIVE'] = "Y";

		


		if ($arInput['DATE_ACTIVE_FROM'] != null) {
			$arLoadProductArray['DATE_ACTIVE_FROM'] = $arInput['DATE_ACTIVE_FROM'];
		}
		if ($arInput['PREVIEW_PICTURE']) {
			$arLoadProductArray['PREVIEW_PICTURE'] = $arInput['PREVIEW_PICTURE'];
		}
		$arLoadProductArray['NAME'] = $arInput['NAME'];
		$arLoadProductArray['PREVIEW_TEXT'] = $arInput['PREVIEW_TEXT'];

		//Контакты записываем как JSON
		$arLoadProductArray['PROPERTY_VALUES']['CONTACTS'] = [
			json_encode(["name" => $arInput['CONTACTS']['NAME'], 'phone' => $arInput['CONTACTS']['PHONE'], 'email' => $arInput['CONTACTS']['EMAIL']])
		];
		if (isset($arInput['CONTACTS']['PHONE'])) {
			$arLoadProductArray['PROPERTY_VALUES']['PHONE'] = $arInput['CONTACTS']['PHONE'];
		}
		if (isset($arInput['CONTACTS']['EMAIL'])) {
			$arLoadProductArray['PROPERTY_VALUES']['EMAIL'] = $arInput['CONTACTS']['EMAIL'];
		}
		
		//INDIVIDUAL
		//l($arLoadProductArray);
		$newRecord = "N";
		if (!$arItem) {
			$newRecord = "Y";
			$arLoadProductArray['DATE_ACTIVE_FROM'] = date('d.m.Y H:i:s');
			$ELEMENT_ID = $el->Add($arLoadProductArray);
			if (!$ELEMENT_ID) {
				$error = $el->LAST_ERROR;
			}
		} else {
			if ($onlyNew) {
				return [
					'newRecord' => "N",
					'ID' => $arItem['ID'],
					'error' => "Клиент с ИНН: " . $INN . ' уже существует в базе данных. 
						    <a  target="_blank" href="/clients/' . $arItem['ID'] . '/">Открыть</a>'
				];
			}
			//l($arItem);
			//l($arLoadProductArray);
			//$res = $el->Update($arItem['ID'], $arLoadProductArray);
			CIBlockElement::SetPropertyValuesEx($arItem['ID'], false, $arLoadProductArray['PROPERTY_VALUES']);
			$arLoadProductArray['PROPERTY_VALUES'] = false;
			$res = $el->Update($arItem['ID'], $arLoadProductArray);
			$ELEMENT_ID = $arItem['ID'];
		}
		//
		if(isset($arInput['PREVIEW_PICTURE_DELETE'] )  ){
		    $el = new CIBlockElement;
			$res = $el->Update($ELEMENT_ID, ['PREVIEW_PICTURE' => ['del' => 'Y'] ]);
		}
		else {
		  self::savePicture($ELEMENT_ID);
		}
		
		return [
			'newRecord' => $newRecord,
			'ID' => $ELEMENT_ID,
			'error' => $error
		];
	}

	public static function savePicture($ELEMENT_ID) {
		$server = \Bitrix\Main\Context::getCurrent()->getServer();
		$request = \Bitrix\Main\Context::getCurrent()->getRequest();
		$fileUploadDir = $server->getDocumentRoot() . '/upload/users/';
		$file = $request->getFile('file');
		if ($file) {
			$newFIleName = $fileUploadDir . $ELEMENT_ID . '-' . $file['name'];
			move_uploaded_file($file['tmp_name'], $newFIleName);
			$el = new CIBlockElement;

			$res = $el->Update($ELEMENT_ID, ['PREVIEW_PICTURE' => CFile::MakeFileArray($newFIleName)]);
		}
	}

	/**
	 * Возвращает  данные клиента
	 * @param type $client_id
	 * @return type array
	 */
	public static function getClientById($client_id,$isCache = false) {
	
	    if($isCache){
	    //Кешируем!!!
		$cache = new CPHPCache();
		$cache_time = 36000;
		$cache_id = "id-".$client_id;
		$cache_path = "getClientById";
		if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)) {
			$res = $cache->GetVars();
			if (is_array($res["data"]) && (count($res["data"]) > 0))
				return $res["data"];
		}
		}
		//если нет кеша то ищем
		$arFilter = [
			'IBLOCK_ID' => Client::CLIENT_IBLOCK_ID,
			'ID' => $client_id,
			'ACTIVE' => "Y"
		];
		$uf_arresult = CIBlockElement::GetList(["active_from" => "DESC"], $arFilter, false, false, []);
		
		$ob = $uf_arresult->GetNextElement();
		if($ob){
		$arFields = $ob->GetFields();

			$arFields['NAME'] = str_replace("&quot;",'"',$arFields['NAME']);
			
		if ($arFields['PREVIEW_PICTURE'] > 0) {
			$arFields['PREVIEW_PICTURE'] = CFile::GetFileArray($arFields['PREVIEW_PICTURE']);
		}
		$arFields['PROPERTIES'] = $ob->GetProperties();
		//$arFields['BX24_COMPANY_ID'] = $arFields['PROPERTIES']['BX24_COMPANY_ID']['VALUE'];
		$arFields['TYPE_NAME_INN'] = $arFields['NAME'];
	
		if (strlen($arFields['PROPERTIES']['INN']['VALUE']) > 4) {
			$arFields['TYPE_NAME_INN'] .= ', ИНН: ' . $arFields['PROPERTIES']['INN']['VALUE'];
		}
		$arFields['PROPERTIES']['INDUSTRY']['VALUE'] = self::getClientIdustry($arFields['PROPERTIES']['INDUSTRY']['VALUE']);

		if($isCache){
		$cache->StartDataCache($cache_time, $cache_id, $cache_path);
		$cache->EndDataCache(["data" => $arFields]);
		}
		return $arFields;
		}
		return false;
	}

	public static function getClientIdustry($idustry_id) {
		if ($idustry_id > 0) {
			$arFilter = [
				'IBLOCK_ID' => 3,
				'ID' => $idustry_id,
				'ACTIVE' => "Y"
			];
			$uf_arresult = CIBlockElement::GetList([], $arFilter, false, false, ['ID', 'NAME', 'CODE']);
			return $uf_arresult->GetNext();
		}
		return false;
	}

	public static function getAllServicesConsultsHistory($client_id) {

		$arServices = self::getServices($client_id,"",$isNeedSmsData = true);
		//l($arServices);
		return $arServices;
	}

	public static function getCLientByCrmBx24($id) {
		$ar = self::getClients([], ['PROPERTY_BX24_COMPANY_ID' => $id]);
		if ($ar[0]) {
			return $ar[0];
		} else
			return false;
	}

	public static function getCLientByINN($inn) {
		$ar = self::getClients([], ['PROPERTY_INN' => $inn]);
		if ($ar[0]) {
			return $ar[0];
		} else
			return false;
	}

	public static function getClients($order = [], $filter = []) {
		$arFilter = [
			'IBLOCK_ID' => Client::CLIENT_IBLOCK_ID,
			'ACTIVE' => "Y"
		];
		if (count($filter) > 0) {
			$arFilter = array_merge($arFilter, $filter);
		}
		if (count($order) == 0) {
			$order = ["NAME" => "ASC"];
		}
		$uf_arresult = CIBlockElement::GetList($order, $arFilter, false, false, []);
		$arResult = [];
		while ($ob = $uf_arresult->GetNextElement()) {
			$arFields = $ob->GetFields();
			$arFields['PROPERTIES'] = $ob->GetProperties();
			$arResult[] = $arFields;
		}
		return $arResult;
	}

	/**
	 * 
	 * @param type $client_id
	 */
	public static function getServices($client_id,$type = "",$isNeedSmsData = false) {
		$arFilter = [
			'IBLOCK_ID' => IBLOCK_ID_SERVICE,
			'PROPERTY_CLIENT' => $client_id,
			'ACTIVE' => "Y"
		];
		if($type!=""){
		 $arFilter['PROPERTY_TYPE'] = $type;
		}
		$uf_arresult = CIBlockElement::GetList(["active_from" => "DESC"], $arFilter, false, false, []);
		$arr = [];
		while ($ob = $uf_arresult->GetNextElement()) {
			$arFields = $ob->GetFields();
			$arProps = $ob->GetProperties();
			$date1 = explode(" ", $arFields['DATE_ACTIVE_FROM']);
			$date2 = explode(" ", $arFields['DATE_ACTIVE_TO']);
			//если связана с услугой
			$arService = [];
			if ($arProps['SERVICE']['VALUE'] > 0) {
				$arService = Service::getServiceById($arProps['SERVICE']['VALUE']);
				$arService = [
					"ID" => $arProps['SERVICE']['VALUE'],
					"NAME" => $arService['NAME']
				];
			}
			//l($arFields['ID']);l($arProps['BX24_WHAT_DO']);
			//Если нужно получить данные СМС оценки задачи.
			$smsData  = [];
			if($isNeedSmsData){
			    $raiting = new Raiting();
			    $smsData = $raiting->getServiceRaitingArray($arFields['ID']);		
			}
			$deadlineDate = '';
			$isContractDeadlineExpired = false;
			$contractProvidedInfo = [
				'STATUS' => 'Нет',
				'TEXT' => '',
				'IS_PROVIDED' => false,
			];
			if (
				$arProps['TYPE']['VALUE_XML_ID'] == Service::TYPE_SERVICE
				&& $arProps['STATUS']['VALUE'] == Service::STATUS_CLOSED
			) {
				$deadlineDate = Service::calculateDeadline($date1[0], $date2[0]);
				$deadlineTimestamp = Service::getDateTimestamp($deadlineDate);
				$todayTimestamp = Service::getDateTimestamp(date('d.m.Y'));
				$contractTimestamp = Service::getDateTimestamp($arProps['CONTRACT_PROVIDED_DATE']['VALUE']);
				$isContractProvidedInTime = $arProps['CONTRACT_PROVIDED']['VALUE'] != ''
					&& $contractTimestamp
					&& $contractTimestamp <= $deadlineTimestamp;
				$isContractDeadlineExpired = $deadlineTimestamp
					&& $deadlineTimestamp < $todayTimestamp
					&& !$isContractProvidedInTime;
				$contractProvidedInfo = Service::getContractProvidedInfo(
					$arProps['CONTRACT_PROVIDED']['VALUE'],
					$arProps['CONTRACT_PROVIDED_DATE']['VALUE'],
					$deadlineDate
				);
			}
			if(strlen($arFields['~PREVIEW_TEXT']) <2){
			   $arFields['~PREVIEW_TEXT'] = '';
			}
			$arr[] = [
				"ID" => $arFields['ID'],
				"NAME" => $arFields['NAME'],
				"PREVIEW_TEXT" => $arFields['~PREVIEW_TEXT'],
				"~PREVIEW_TEXT" => $arFields['~PREVIEW_TEXT'],
				"DATE_ACTIVE_FROM" => $arFields['DATE_ACTIVE_FROM'],
				"DATE" => $date1[0],
				"DATE_UNIX" => MakeTimeStamp($arFields['DATE_ACTIVE_FROM'], "DD.MM.YYYY HH:MI:SS"),
				"DATE_ACTIVE_TO" => $arFields['DATE_ACTIVE_TO'],
				"DATE_ACTIVE_TO" => $arFields['DATE_ACTIVE_TO'],
				"DATE_TO" => $date2[0],
				"STATUS" => $arProps['STATUS']['VALUE'],
				"STATUS_TEXT" => Service::getStatusTextById($arProps['STATUS']['VALUE']),
				"MANAGER_ID" => $arProps['MANAGER']['VALUE'],
				"COMMENT" => $arProps['COMMENT']['VALUE'],
				"MONEY" => $arProps['MONEY']['VALUE'],
				"MONEY2" => $arProps['MONEY2']['VALUE'],
				"MONEY3" => $arProps['MONEY3']['VALUE'],
				"BX24_TASK_ID" => $arProps['BX24_TASK_ID']['VALUE'],
				"TYPE" => $arProps['TYPE']['VALUE_XML_ID'],
				"SERVICE" => $arService,
				"BX24_STATUS_EXT"=>$arProps['BX24_STATUS_EXT']['VALUE'],
				"CLIENT_REFUSED"=>$arProps['CLIENT_REFUSED']['VALUE'],
				"CONTRACT_DEADLINE" => $deadlineDate,
				"IS_CONTRACT_DEADLINE_EXPIRED" => $isContractDeadlineExpired,
				"CONTRACT_PROVIDED_INFO" => $contractProvidedInfo,
				"DETAIL_PAGE_URL" => ($arProps['TYPE']['VALUE_XML_ID'] == 'SERVICE' ? '/service/' : '/consult/') . $arFields['ID'] . '/',
				'BX24_WHAT_DO'=>$arProps['BX24_WHAT_DO']['VALUE']['TEXT'],
				'SMS_RAITING'=> $smsData,
			];
		}
		return $arr;
	}

}
