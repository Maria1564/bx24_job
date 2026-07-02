<?php
	
	/*
		
	*/
	
	class Contact {
		
		const CONTACT_IBLOCK_ID = 5;
		
		
		
		public static function save($arInput, $onlyNew = false) {
			$arItem = false;
			$error = false;
			$ELEMENT_ID = $arInput['ID'];
			$CLIENT_ID =  $arInput['CLIENT'];
			
			if(!$CLIENT_ID){
				return ['error'=>true,'message'=>'CLIENT_ID is NULL!'];
			}
			if($ELEMENT_ID){
				$filter = array('IBLOCK_ID' => self::CONTACT_IBLOCK_ID, "ID" => $ELEMENT_ID);
			}
			
			$ELEMENT_CODE = self::formatPhoneNum($arInput['PHONE']);
			if($ELEMENT_CODE && empty($ELEMENT_ID)){ // fixed 03/04/24 - по коду (телефону) только если нет id 
				$filter = array('IBLOCK_ID' => self::CONTACT_IBLOCK_ID, "CODE" => $ELEMENT_CODE,'PROPERTY_CLIENT'=>$CLIENT_ID);
			}
			
			if ($ELEMENT_ID || $ELEMENT_CODE) {
				$rsItems = CIBlockElement::GetList([],$filter , false, false, array());
				$arItem = $rsItems->GetNext();
			}
			
			$el = new CIBlockElement;
			$arLoadProductArray = [];
			$arLoadProductArray['IBLOCK_ID'] = self::CONTACT_IBLOCK_ID;
			$arLoadProductArray['ACTIVE'] = $arInput['ACTIVE']? $arInput['ACTIVE']:"Y";
			$arLoadProductArray['NAME'] = $arInput['NAME'];
			$arLoadProductArray['PREVIEW_TEXT'] = $arInput['PREVIEW_TEXT'];
			$arLoadProductArray['CODE'] = $ELEMENT_CODE ;
			$arLoadProductArray['PROPERTY_VALUES']['EMAIL'] = $arInput['EMAIL'];
			$arLoadProductArray['PROPERTY_VALUES']['CLIENT'] = $CLIENT_ID;
			l($arLoadProductArray);
			if (!$arItem) {
				$newRecord = "Y";
				$ELEMENT_ID = $el->Add($arLoadProductArray);
				if (!$ELEMENT_ID) {
					$error = $el->LAST_ERROR;
				}
			} 
			else {
				
				//l($arItem);
				//l($arLoadProductArray);
				//$res = $el->Update($arItem['ID'], $arLoadProductArray);
				CIBlockElement::SetPropertyValuesEx($arItem['ID'], false, $arLoadProductArray['PROPERTY_VALUES']);
				$arLoadProductArray['PROPERTY_VALUES'] = false;
				$res = $el->Update($arItem['ID'], $arLoadProductArray);
				$ELEMENT_ID = $arItem['ID'];
			}
			//self::savePicture($ELEMENT_ID);
			return [
			'newRecord' => $newRecord,
			'ID' => $ELEMENT_ID,
			'error' => $error
			];
		}
		
		
		
		/**
			* Formats a phone number
			* @param string $phone
		*/
		public static function formatPhoneNum($phone){
			$phone = preg_replace("/[^0-9]*/",'',$phone);
			if($phone[0] == 8){ 
		        $phone = substr($phone, 1);
				$phone = "+7".$phone;
			}
			if($phone[0] == 7){ 
		     
				$phone = "+".$phone;
			}
			return($phone);
		}
		public static function getClientContacts($idCLient, $filter=[]) {
			$arFilter = [
			'ACTIVE'=>'Y',
			'IBLOCK_ID' => self::CONTACT_IBLOCK_ID,
			'PROPERTY_CLIENT' =>$idCLient
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
				//$arFields['PROPERTIES'] =  clearPropertyArray($ob->GetProperties());
				$arProps = $ob->GetProperties();
				$arResult[] =[
				"ID"=>$arFields['ID'],
				"NAME"=>$arFields['NAME'],
				"PREVIEW_TEXT"=>$arFields['PREVIEW_TEXT'],
				"PHONE"=>$arFields['CODE'],
				"EMAIL"=>$arProps['EMAIL']['VALUE'],
				"CLIENT"=>$arProps['CLIENT']['VALUE'],
				];
				
			}
			return $arResult;
		}
		
		public static function getClientContactsReturnId($idCLient, $filter=[]) {
			$arFilter = [
			'ACTIVE'=>'Y',
			'IBLOCK_ID' => self::CONTACT_IBLOCK_ID,
			'PROPERTY_CLIENT' =>$idCLient
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
				//$arFields['PROPERTIES'] =  clearPropertyArray($ob->GetProperties());
				$arResult[] = $arFields['ID'];
				
			}
			return $arResult;
		}
		
		public static function getClientContactsId($idContact, $filter=[]) {
			$arFilter = [
			'ACTIVE'=>'Y',
			'IBLOCK_ID' => self::CONTACT_IBLOCK_ID,
			'ID' =>$idContact
			];
			if (count($filter) > 0) {
				$arFilter = array_merge($arFilter, $filter);
			}
			if (count($order) == 0) {
				$order = ["PROPERTY_CLIENT" => "ASC"];
			}
			$uf_arresult = CIBlockElement::GetList($order, $arFilter, false, false, []);
			$arResult = [];
			while ($ob = $uf_arresult->GetNextElement()) {
				$arFields = $ob->GetFields();
				//$arFields['PROPERTIES'] =  clearPropertyArray($ob->GetProperties());
				$arProps = $ob->GetProperties();
				$arResult[] =[
				"ID"=>$arFields['ID'],
				"NAME"=>$arFields['NAME'],
				"PREVIEW_TEXT"=>$arFields['PREVIEW_TEXT'],
				"PHONE"=>$arFields['CODE'],
				"EMAIL"=>$arProps['EMAIL']['VALUE'],
				"CLIENT"=>$arProps['CLIENT']['VALUE'],
				];
				
			}
			return $arResult;
		}
		
		
		
		
		
	}
