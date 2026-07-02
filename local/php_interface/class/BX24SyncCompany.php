<?php

/*
	Синхронизация клиента с б24.
*/
class BX24SyncCompany {

	public static function bx24SynchronizationElement($elementID) {
		$result = false;
		$client = Client::getClientById($elementID);
		$bx24_company_id = $client['PROPERTIES']['BX24_COMPANY_ID']['VALUE'];
		//$_SESSION['COMPANY_IGNORE_UPDATE'][$bx24_company_id] = true;
		//log2file('$bx24_company_id',$bx24_company_id,TRUE);
		if ($bx24_company_id > 1) {
			self::Update($client);
		} else {
			//Если нет, то создаем и обновляем данные
			self::Add($client);
			$error = "Элемент не привязан к компаниям в B24";
		}

		return [
			'result' => $result,
			'error' => $error,
		];
	}

	/*
	 * Обновялет данные компании в crm bitrx24 данными текущего 
	 * элемента
	 */

	public static function Update($client) {

		$bx24_company_id = $client['PROPERTIES']['BX24_COMPANY_ID']['VALUE'];
		$oBitrix = new \Zloykolobok\Bitrix24\Classes\Company();
		$oBitrix->setUrl(BX_WEBHOOK_URL);
		$oBitrix->setTimeout(30);
		$company = $oBitrix->companyGet($bx24_company_id)->result;
		$arFields = [];
		$arFields["TITLE"] = $client['~NAME'];
		//Телефон
		if ($client['PROPERTIES']['PHONE']['VALUE'] != "") {
			$VALUE_ID = false;
			if ($company->PHONE[0]->ID > 0) {
				$VALUE_ID = $company->PHONE[0]->ID;
			}
			$arFields["PHONE"] = [['ID' => $VALUE_ID, "VALUE" => $client['PROPERTIES']['PHONE']['VALUE'], 'VALUE_TYPE' => 'WORK']];
			//
		}
		//Email
		if ($client['PROPERTIES']['EMAIL']['VALUE'] != "") {
			$VALUE_ID = false;
			if ($company->EMAIL[0]->ID > 0) {
				$VALUE_ID = $company->EMAIL[0]->ID;
			}
			$arFields["EMAIL"] = [['ID' => $VALUE_ID, "VALUE" => $client['PROPERTIES']['EMAIL']['VALUE'], 'VALUE_TYPE' => 'WORK']];
		}
		//ОКВЕД UF_CRM_1591674429050
		$arFields["UF_CRM_1591674429050"] =  $client['PROPERTIES']['OKVED']['VALUE'];
		//$arFields["ASSIGNED_BY_ID"] =  Helper::getUserBx24Id();
		//INDUSTRY - Сфера деятельности
		$arFields["INDUSTRY"] = $client['PROPERTIES']['INDUSTRY']['VALUE']['CODE'];
		$arFields["ASSIGNED_BY_ID"] = Helper::getUserBx24Id($client['PROPERTIES']['MANAGER']['VALUE']); //$client['PROPERTIES']['MANAGER']['VALUE'];
	//	$log['$client'] = $client;
		$log['$arFields'] = $arFields;
		$result = $oBitrix->companyUpdate($bx24_company_id, $arFields, []);
		//Обновляем сущность контакт в битрикс24
		$BX24_CONTACT_ID  = $client['PROPERTIES']['BX24_CONTACT_ID']['VALUE'];
		if($BX24_CONTACT_ID > 0){
		    $oBitrixContact = new \Zloykolobok\Bitrix24\Classes\Contact();
		    $oBitrixContact->setUrl(BX_WEBHOOK_URL);
		    $oBitrixContact->setTimeout(100);
			
			$contact = $oBitrixContact->contactGet( $BX24_CONTACT_ID);
			$contactPhone = $contact->result->PHONE[0];
			$arFieldsContact['PHONE'] = [
			              [ "ID"=>$contactPhone->ID,
						   "VALUE" => $client['PROPERTIES']['PHONE']['VALUE'], 
						   'VALUE_TYPE' => $contactPhone->VALUE_TYPE
						   ]
						];
			$contactEMAIL = $contact->result->EMAIL[0];
			$arFieldsContact['EMAIL'] = [
			              [ "ID"=>$contactEMAIL->ID,
						   "VALUE" => $client['PROPERTIES']['EMAIL']['VALUE'], 
						   'VALUE_TYPE' => $contactEMAIL->VALUE_TYPE
						   ]
						];
						
			$arN = explode(" ",$client['PROPERTIES']['CONTACT_NAME']['VALUE']);
			$arFieldsContact['NAME'] = 		trim($arN[1]);
			$arFieldsContact['LAST_NAME'] = 		trim($arN[0]);
			
		    $contactResult = $oBitrixContact->contactUpdate($BX24_CONTACT_ID ,$arFieldsContact,[]);	
			$log['$contact'] = $contact;
			$log['$client'] = $client;
			$log['$contact_result'] = $contactResult;
			$log['$arFieldsContact'] = $arFieldsContact;
		}
		
		
		
		$log['$result'] = $result;
		log2file('BX24SyncCompany-update', $log);
		self::setRequizite($client);
	}

	/*
	 Устанавливает реквизиты компании в b24
	 
	*/
	function setRequizite($client) {
	if($client>0){
		$bx24_company_id = $client['PROPERTIES']['BX24_COMPANY_ID']['VALUE'];
		$ORG_TYPE = $client['PROPERTIES']['ORG_TYPE']['VALUE_ENUM_ID'];
		$NAME = $client['~NAME'];
		$PRESET_ID = 5;
		if ($ORG_TYPE == Client::ORG_TYPE_OOO_ID) {
			$PRESET_ID = 1;
		}
		if ($ORG_TYPE == Client::ORG_TYPE_INDIVIDUAL_ID) {
			$PRESET_ID = 3;
		}
		$arFields = [
			"NAME" => $NAME,
			"PRESET_ID" => $PRESET_ID,
			"RQ_NAME" => $NAME,
			
			"RQ_EMAIL" => $client['PROPERTIES']['EMAIL']['VALUE'],
			"RQ_PHONE" => $client['PROPERTIES']['PHONE']['VALUE'],
			"RQ_INN" => $client['PROPERTIES']['INN']['VALUE'],
		//	"RQ_OGRN" => $client['PROPERTIES']['OGRN']['VALUE'],
			"RQ_OGRNIP" => $client['PROPERTIES']['OGRN']['VALUE'],
		];
		self::setCompanyRequsite($bx24_company_id, $arFields);
	}
	}

	function setCompanyRequsite($compID, $arrInput = []) {
	if($compID>0){
		$oBitrix = new \Zloykolobok\Bitrix24\Classes\Company();
		$oBitrix->setUrl(BX_WEBHOOK_URL);
		$oBitrix->setTimeout(10);
		$companyRequisiteArr = $oBitrix->companyGetRequsite($compID);
		$log['$compID'] =$compID;
		$log['$companyRequisiteArr'] = $companyRequisiteArr;
		$arFields = [
			"ENTITY_TYPE_ID" => 4,
			"ENTITY_ID" => $compID,
		];
		$arFields = array_merge($arFields, $arrInput);
		log2file('$arFields', $arFields);
		if ($companyRequisiteArr->result == NULL) {
			$log[] = 'Добавлен';
			ob_start();
			$res = $oBitrix->companyAddRequsite($arFields);
			$log['return'] = ob_get_contents();
			$log['$res'] =$res;
		} else {
			
			$log[] = 'Обновлен';
			$companyRequisite = $companyRequisiteArr->result[0];
			$res = $oBitrix->companyUpdateRequsite($companyRequisite->ID, $arFields);			
			$log['$res'] =$res;
		}
		log2file('BX24SyncCompany-setCompanyRequsite-log', $log);
	}
	}

	/*
	 * Добавляет компанию в crm bitrix24 и его ID
	 * привязывает текущему клиенту
	 */

	function Add($client) {
		$log[] = 'bx24SynchronizationCompanyAdd';
		//$log['$client'] =$client;
		//
		//if($client['PROPERTIES']['PHONE']['VALUE']=="")return false;
		//if($client['PROPERTIES']['EMAIL']['VALUE']=="")return false;
		//if($client['NAME']=="")return false;
		$oBitrix = new \Zloykolobok\Bitrix24\Classes\Company();
		$oBitrix->setUrl(BX_WEBHOOK_URL);
		$oBitrix->setTimeout(10);

		//Сначала ищщем компанию с  точным совпадением имени
		$res = $oBitrix->companyList(['TITLE' => 'ASC'], ['TITLE' => $client['NAME']], ['ID', 'TITLE', 'PHONE', 'EMAIL', 'COMPANY_TYPE']);

		$log['$res'] = $res;
		if ($idBxCompany = $res->result[0]->ID) {
			$log['$idBxCompany'] = $idBxCompany;

			if ($idBxCompany > 0) {
				CModule::IncludeModule("iblock");
				CIBlockElement::SetPropertyValuesEx($client['ID'], false, array('BX24_COMPANY_ID' => $idBxCompany));
			}
			return true;
		}
		$arFields = [
			'TITLE' => $client['NAME'],
			'COMMENTS' => $client['PREVIEW_TEXT'],
		];
		$arFields["PHONE"] = [["VALUE" => $client['PROPERTIES']['PHONE']['VALUE'], 'VALUE_TYPE' => 'WORK']];
		$arFields["EMAIL"] = [["VALUE" => $client['PROPERTIES']['EMAIL']['VALUE'], 'VALUE_TYPE' => 'WORK']];
		$arFields["INDUSTRY"] = $client['PROPERTIES']['INDUSTRY']['VALUE']['CODE'];
	
		$arFields["ASSIGNED_BY_ID"] =  Helper::getUserBx24Id();
		$res = $oBitrix->CompanyAdd($arFields, []);
		$company_id = $res->result;
		$log['$res2'] = $res;
		if ($company_id > 0) {
			CModule::IncludeModule("iblock");
			CIBlockElement::SetPropertyValuesEx($client['ID'], false, array('BX24_COMPANY_ID' => $company_id));
		}

		self::setRequizite(Client::getClientById($client['ID']));
		log2file('bx24SynchronizationCompanyAdd', $log);
	}

}
