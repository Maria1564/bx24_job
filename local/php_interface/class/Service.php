<?php

/*
 * 
 */
 
class Service {

	const IBLOCK_ID = 2;
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

	public static function getStatusTextById($status_id) {
		if ($status_id == "")
			$status_id = self::STATUS_CLOSED;
		return self::$statuses[$status_id];
	}

public static function save($arInput) {
		$ELEMENT_ID = $arInput['id'];
		$arItem = false;
		if ($ELEMENT_ID > 0) {
			$rsItems = CIBlockElement::GetList(array(), array('IBLOCK_ID' => IBLOCK_ID_SERVICE, "ID" => $ELEMENT_ID), false, false, array());
			$arItem = $rsItems->GetNext();
		}
		$el = new CIBlockElement;
		$arLoadProductArray = [];
	
		//TIME_CREATE
		$arInput['PROPERTY']['TIME_CREATE'] = time();
		//	
		$arLoadProductArray['PROPERTY_VALUES'] = $arInput['PROPERTY'];
	
    	if($arLoadProductArray['PROPERTY_VALUES']['TYPE']==NULL){
	        $arLoadProductArray['PROPERTY_VALUES']['TYPE']['VALUE'] = Service::TYPE_SERVICE_ID;
	    }
		
		$arLoadProductArray['PROPERTY_VALUES']['MONEY'] = preg_replace("/[^0-9]/","",$arLoadProductArray['PROPERTY_VALUES']['MONEY']);
		
		$arLoadProductArray['IBLOCK_ID'] = IBLOCK_ID_SERVICE;
		$arLoadProductArray['ACTIVE'] = "Y";
		$arLoadProductArray['DATE_ACTIVE_FROM'] = $arInput['DATE_ACTIVE_FROM'];
		$arLoadProductArray['NAME'] = $arInput['NAME'];
		$arLoadProductArray['PREVIEW_TEXT'] = $arInput['PREVIEW_TEXT'];
	//	$arLoadProductArray['PROPERTY_VALUES']['STATUS'] = Service::STATUS_ACTIVE;
		

		if( $arInput['DATE_ACTIVE_TO']){
		  $arLoadProductArray['DATE_ACTIVE_TO'] = $arInput['DATE_ACTIVE_TO'];
		}
		if($arInput['PROPERTY']['STATUS'] ==""){
		        //$arInput['PROPERTY_VALUES']['STATUS'] = Service::STATUS_ACTIVE;				 
		}
		//l($arLoadProductArray);
		$newRecord = "N";
		if (!$arItem) {
			$newRecord = "Y";
			$arLoadProductArray['PROPERTY_VALUES']['MICROTIME'] = microtime(true);
			$ELEMENT_ID = $el->Add($arLoadProductArray);
			if (!$ELEMENT_ID) {
				$error = $el->LAST_ERROR;
			}
		}
		else {
		  
		    //unset($arLoadProductArray['PROPERTY_VALUES']['CREATED']);
			CIBlockElement::SetPropertyValuesEx($arItem['ID'], false, $arLoadProductArray['PROPERTY_VALUES']);
			$arLoadProductArray['PROPERTY_VALUES'] = false;
			$res = $el->Update($arItem['ID'], $arLoadProductArray);
			//$res = $el->Update($arItem['ID'], $arLoadProductArray);
			//echo '<br>Есть запись ID: ' . $arItem['ID'] . ' : ' . $data['offerId'].' Данны обновлены '.$updText;		
		}
		
		$CLIENT_ID = $arLoadProductArray['PROPERTY_VALUES']['CLIENT'];
		return [
			'newRecord' => $newRecord,
			'ID' => $ELEMENT_ID,
			"CLIENT_ID" => $CLIENT_ID,
			'error' => $error
		];
	}
	
	public static function save_event($arInput) {
		$ELEMENT_ID = $arInput['id'];
		$arItem = false;
		if ($ELEMENT_ID > 0) {
			$rsItems = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 7, "ID" => $ELEMENT_ID), false, false, array());
			$arItem = $rsItems->GetNext();
		}
		$el = new CIBlockElement;
		$arLoadProductArray = [];
	
		//TIME_CREATE
		$arInput['PROPERTY']['TIME_CREATE'] = time();
		//	
		$arLoadProductArray['PROPERTY_VALUES'] = $arInput['PROPERTY'];
	
    	if($arLoadProductArray['PROPERTY_VALUES']['TYPE']==NULL){
	        $arLoadProductArray['PROPERTY_VALUES']['TYPE']['VALUE'] = Service::TYPE_SERVICE_ID;
	    }
		
		$arLoadProductArray['PROPERTY_VALUES']['MONEY'] = preg_replace("/[^0-9]/","",$arLoadProductArray['PROPERTY_VALUES']['MONEY']);
		
		$arLoadProductArray['IBLOCK_ID'] = 7;
		$arLoadProductArray['ACTIVE'] = "Y";
		$arLoadProductArray['DATE_ACTIVE_FROM'] = $arInput['DATE_ACTIVE_FROM'];
		$arLoadProductArray['NAME'] = $arInput['NAME'];
		$arLoadProductArray['PREVIEW_TEXT'] = $arInput['PREVIEW_TEXT'];
	//	$arLoadProductArray['PROPERTY_VALUES']['STATUS'] = Service::STATUS_ACTIVE;
		

		if( $arInput['DATE_ACTIVE_TO']){
		  $arLoadProductArray['DATE_ACTIVE_TO'] = $arInput['DATE_ACTIVE_TO'];
		}
		if($arInput['PROPERTY']['STATUS'] ==""){
		        //$arInput['PROPERTY_VALUES']['STATUS'] = Service::STATUS_ACTIVE;				 
		}
		//l($arLoadProductArray);
		$newRecord = "N";
		if (!$arItem) {
			$newRecord = "Y";
			$arLoadProductArray['PROPERTY_VALUES']['MICROTIME'] = microtime(true);
			$ELEMENT_ID = $el->Add($arLoadProductArray);
			if (!$ELEMENT_ID) {
				$error = $el->LAST_ERROR;
			}
		}
		else {
		  
		    //unset($arLoadProductArray['PROPERTY_VALUES']['CREATED']);
			CIBlockElement::SetPropertyValuesEx($arItem['ID'], false, $arLoadProductArray['PROPERTY_VALUES']);
			$arLoadProductArray['PROPERTY_VALUES'] = false;
			$res = $el->Update($arItem['ID'], $arLoadProductArray);
			//$res = $el->Update($arItem['ID'], $arLoadProductArray);
			//echo '<br>Есть запись ID: ' . $arItem['ID'] . ' : ' . $data['offerId'].' Данны обновлены '.$updText;		
		}
		
		$CLIENT_ID = $arLoadProductArray['PROPERTY_VALUES']['CLIENT'];
		return [
			'newRecord' => $newRecord,
			'ID' => $ELEMENT_ID,
			"CLIENT_ID" => $CLIENT_ID,
			'error' => $error
		];
	}
	
	

	public static function getConsults($service_id) {
		$arFilter = [
			'IBLOCK_ID' => IBLOCK_ID_SERVICE,
			'PROPERTY_SERVICE' => $service_id,
			'PROPERTY_TYPE_XML_ID' => Service::TYPE_CONSALT,
			'ACTIVE' => "Y"
		];
		//l($arFilter);
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
				$arService = self::getServiceById($arProps['SERVICE']['VALUE']);
				$arService = [
					"ID" => $arProps['SERVICE']['VALUE'],
					"NAME" => $arService['NAME']
				];
			}
			$arr[] = [
				"ID" => $arFields['ID'],
				"NAME" => $arFields['NAME'],
				"PREVIEW_TEXT" => $arFields['PREVIEW_TEXT'],
				"DATE_ACTIVE_FROM" => $arFields['DATE_ACTIVE_FROM'],
				"DATE" => $date1[0],
				"DATE_ACTIVE_TO" => $arFields['DATE_ACTIVE_TO'],
				"DATE_TO" => $date2[0],
				"STATUS" => $arProps['STATUS']['VALUE'],
				"STATUS_TEXT" => Service::getStatusTextById($arProps['STATUS']['VALUE']),
				"MANAGER_ID" => $arProps['MANAGER']['VALUE'],
				"SUMMA" => $arProps['SUMMA']['VALUE'],
				"TYPE" => $arProps['TYPE']['VALUE_XML_ID'],
				"SERVICE" => $arService,
			];
		}
		return $arr;
	}

	public static function getServiceById($ELEMENT_ID, $arFilter = []) {
		$arFilter['IBLOCK_ID'] = IBLOCK_ID_SERVICE;
		//$arFilter['ACTIVE'] = "Y";
		$arFilter['ID'] = $ELEMENT_ID;
		$uf_arresult = CIBlockElement::GetList(["active_from" => "DESC"], $arFilter, false, false, []);
		if ($ob = $uf_arresult->GetNextElement()) {
			$arFields = $ob->GetFields();
			$arFields['PROPERTIES'] = $ob->GetProperties();
			return $arFields;
		}
	}
	public static function getEventById($ELEMENT_ID, $arFilter = []) {
		$arFilter['IBLOCK_ID'] = 7;
		//$arFilter['ACTIVE'] = "Y";
		$arFilter['ID'] = $ELEMENT_ID;
		$uf_arresult = CIBlockElement::GetList(["active_from" => "DESC"], $arFilter, false, false, []);
		if ($ob = $uf_arresult->GetNextElement()) {
			$arFields = $ob->GetFields();
			$arFields['PROPERTIES'] = $ob->GetProperties();
			return $arFields;
		}
	}

	public static function getClient($service_id) {
		$service = self::getServiceById($service_id);
		$clinet_id = $service['PROPERTIES']['CLIENT']['VALUE'];
		if($clinet_id){
	return Client::getClientById($clinet_id);
		}
		else return false;
		
	}
	
	public static function getServiceByBx24Id($task_id, $arFilter = []) {
	if($task_id  < 1) return false;
		$arFilter['IBLOCK_ID'] = IBLOCK_ID_SERVICE;
		$arFilter['ACTIVE'] = "Y";
		$arFilter['PROPERTY_BX24_TASK_ID'] = $task_id;
		$uf_arresult = CIBlockElement::GetList(["active_from" => "DESC"], $arFilter, false, false, []);
		if ($ob = $uf_arresult->GetNextElement()) {
			$arFields = $ob->GetFields();
			$arFields['PROPERTIES'] = $ob->GetProperties();
			return $arFields;
		}
	}
	public static function setStatus($elemetnId, $statusId) {
		CModule::IncludeModule("iblock");
		CIBlockElement::SetPropertyValuesEx($elemetnId, false, array('STATUS' => $statusId));
		$el = new CIBlockElement;
		if ($statusId == Service::STATUS_CLOSED) {
			$res = $el->Update($elemetnId, ['DATE_ACTIVE_TO' => date('d.m.Y H:i:s')]);
		} else {
			$res = $el->Update($elemetnId, ['DATE_ACTIVE_TO' => ""]);
		}
		//CIBlock::clearIblockTagCache(IBLOCK_ID_SERVICE);
		//$ChangeHistory = new ChangeHistory();
		//$ChangeHistory->add("IBLOCK_ID=" . IBLOCK_ID_SERVICE, ChangeHistory::ACTION_EDIT, "статус", $statusId, $elemetnId);
	}

	public static function delete($elemetnId) {
		CModule::IncludeModule("iblock");
		$el = new CIBlockElement;
		return $el->Update($elemetnId, ['ACTIVE' => 'N']);
	}
	
	public static function setSmsVote($elemetnId, $vote ,$dateSend =0) {
		CModule::IncludeModule("iblock");
		if($dateSend== 0){
		  $dateSend = time();
		}
		CIBlockElement::SetPropertyValuesEx($elemetnId, false, array('SMS_VOTE' => $vote));
		CIBlockElement::SetPropertyValuesEx($elemetnId, false, array('SMS_SEND_DATE' => $dateSend));
	}
}
