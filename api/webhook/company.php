<?php
	/*
		* 1. получаем новые данные из црм
		* 2. обновляем данные на сайте
		* 3. добавляем событие изменения.
	*/
	
	$oBitrix = new \Zloykolobok\Bitrix24\Classes\Company();
	$oBitrix->setUrl(BX_WEBHOOK_URL);
	$oBitrix->setTimeout(100);
	
	$company = $oBitrix->companyGet($ID);
	$log['company'] = $company;
	
	if ($company->result->ID > 0) {
	
	  /*
		Для текущего клиента смотрим когда был создан 
		если менее минуты то блокируем.
		$company['ID']
	*/
	$rsItems = CIBlockElement::GetList(array('ID'=>'DESC'), array('IBLOCK_ID' => CLIENT_IBLOCK_ID, "NAME" => $company->result->TITLE), false, false, array('NAME','ID','DATE_CREATE','PROPERTY_TIME_CREATE'));
	$arItem = $rsItems->GetNext();
	if($arItem && $arItem['PROPERTY_TIME_CREATE_VALUE'] > 0 ){
		$logTime[] = $arItem;
		$timeCreate = strtotime($arItem['PROPERTY_TIME_CREATE_VALUE']);
		$logTime['time'] =time();
		$logTime['timeCreate'] =$timeCreate;
		$logTime[] ='time() - $timeCreate ='.(time() - $timeCreate);
		
		if(   time() - $timeCreate   < 10){
			
			exit;
		}
		
		log2file('bx24Log-company-log-TIME', $logTime);
	}
	
		//Получаем реквизиты
		$companyRequisiteArr = $oBitrix->companyGetRequsite($ID);
		$ORG_TYPE = Client::ORG_TYPE_FIZ_ID;
		if ($companyRequisiteArr->result == null) {
			//пробуем получить из названия тип организации
			$name = $company->result->TITLE;
			if (strpos($name, "ИП") !== false) {
				l('ИП ');
				$ORG_TYPE = Client::ORG_TYPE_INDIVIDUAL_ID;
			}
			if (strpos($name, "ООО") !== false) {
				l('ООО ');
				$ORG_TYPE = Client::ORG_TYPE_OOO_ID;
			}
			if (strpos($name, "КФХ") !== false) {
				$ORG_TYPE = Client::ORG_TYPE_OOO_ID;
			}
		} 
		else {
			$companyRequisite = $companyRequisiteArr->result[0];
			if ($companyRequisite->PRESET_ID == 1) {
				$ORG_TYPE = Client::ORG_TYPE_OOO_ID;
			}
			if ($companyRequisite->PRESET_ID == 3) {
				$ORG_TYPE = Client::ORG_TYPE_INDIVIDUAL_ID;
			}
		}
		
		$log['companyRequisite'] = $companyRequisite;
		/*
			* PRESET_ID - 1 Организация
			* PRESET_ID - 3 ИП
			* PRESET_ID - 5 Физ лицо
		*/
		//l($company);
		//Получаем клиента на сайте по свойству BX24_COMPANY_ID
		$client = Client::getCLientByCrmBx24($ID);
		
		
		$clientID = false;
		if ($client) {
		    $log[] = "Клиент найден!";
			ChangeHistory::setCustomAction("Обновлен из CRM Bitrix24");
			$clientID = $client['ID'];
			// $log['_client'][] = $client;
			} else {
			$log[] = "Клиент не найден!";
			/*
				* Если текущий клиент не связан  с црм, и у него прописан ИНН 
				* пытаемся найти по инн
			*/
			if (strlen($companyRequisite->RQ_INN) > 5) {
				$client = Client::getCLientByINN($companyRequisite->RQ_INN);
				if ($client) {
					l('Клиент  найден по ИНН !');
					$log[] = "Клиент  найден по ИНН! = ".$companyRequisite->RQ_INN;
					$clientID = $client['ID'];
				}
			}
			ChangeHistory::setCustomAction("Добавлен из CRM Bitrix24");
			//Создаем клиента
		}
		
		
		
		$industryID = false;
		$arIndustry = Helper::getOrgIndustry(true);
		//l($arIndustry);
		foreach ($arIndustry as $id => $arr) {
			if ($arr['CODE'] == $company->result->INDUSTRY) {
				$industryID = $id;
				break;
			}
		}
		
		if ($company->result->ASSIGNED_BY_ID > 0) {
			$userData = Helper::getUserDataByBx24Id($company->result->ASSIGNED_BY_ID);
			$MANAGER = $userData['ID'];
		}
		
		
		
		//Обработка ЛОГО
		$isUpdatePicture = false;
		$LOGO = '';
		if($company->result->LOGO){
			$log['LOGO'][] = "Есть лого";
			$LOGO = json_encode($company->result->LOGO);
			if($client){
				$log['LOGO'][] = "Есть клиент";
				$log['LOGO'][] =$client['PROPERTIES']['LOGO']['~VALUE'];
				if($client['PROPERTIES']['LOGO']['~VALUE']!=""){
					$logoData = json_decode($client['PROPERTIES']['LOGO']['~VALUE'],true);
				}
				$log['LOGO'][] = $logoData;
				//картинка изменилась. обновляем
				if( $company->result->LOGO->id >0 && $company->result->LOGO->id != $logoData['id']){
					//
					$log['LOGO'][] = "картинка изменилась. обновляем";
					$isUpdatePicture = true;
					$imageURL = BX_CRM_SITE_URL.$company->result->LOGO->downloadUrl;
					$log['LOGO']["imageURL"] = $imageURL;
					//
				}
				else {
					$log['LOGO'][] = "картинка НЕ изменилась. НЕ обновляем";
				}
				//$arFields['PROPERTIES']
			}
		}
		
		/*
			Получаем контакты у компании.
			
		*/
		$COMPANY_PHONE = $company->result->PHONE[0]->VALUE;
		$COMPANY_EMAIL  = $company->result->EMAIL[0]->VALUE;
		$CONTACT_NAME = '';
		$CONTACT_ID = 0;
		$arContacts = getCompayContacts($ID);
		if(count($arContacts)>0){
			$arContactsFirst = $arContacts[0];	
			$BX24_CONTACT_ID = $arContactsFirst['CONTACT_ID'];
			if($arContactsFirst['PHONE']!=""){
				$COMPANY_PHONE = $arContactsFirst['PHONE'];
			}
			if($arContactsFirst['EMAIL']!=""){
				$COMPANY_EMAIL = $arContactsFirst['EMAIL'];
			}
			if($CONTACT_NAME==""){
				$CONTACT_NAME = $arContactsFirst['NAME'];
			}
		}
		
		$REGION = '';
		if($company->result->UF_CRM_1593585993187>0){
			//
			$arT = Helper::getRegionByBx24Id($company->result->UF_CRM_1593585993187);
		    $log['REGION'][] = $arT;
			if($arT){
				$REGION = $arT['ID'];
			}
		}
		$fileds = [
		"id" => $clientID,
		"NAME" => $company->result->TITLE,
		"PROPERTY" => [
		'MANAGER' => $MANAGER,
		"ORG_TYPE" => $ORG_TYPE,
		"BX24_COMPANY_ID" => $company->result->ID,
		//"INN" => $companyRequisite->RQ_INN,
		"LOGO"=>$LOGO,
		"REGION"=>$REGION,
		//	"OGRN" => $companyRequisite->RQ_OGRNIP,
		//	"OKVED" => $companyRequisite->RQ_OKVED,
		"OKVED" => $company->result->UF_CRM_1591674429050,
		"RAION"=>$company->result->UF_CRM_1593585993187,
		"INDUSTRY" => $industryID,
		'PHONE' =>$COMPANY_PHONE,
		'EMAIL' =>$COMPANY_EMAIL ,
	//	'CONTACT_NAME' =>$CONTACT_NAME ,
		'BX24_CONTACT_ID' =>$BX24_CONTACT_ID ,
		]
		];
		if( $companyRequisite->RQ_INN!=""){
		$fileds["INN"] =  $companyRequisite->RQ_INN;
		}
		
		if($isUpdatePicture){
			include $_SERVER["DOCUMENT_ROOT"]."/local/php_interface/class/Bx24Token.php";
			$imgArr =   getLogoFromBx24($imageURL);
			
			$fileds['PREVIEW_PICTURE'] = $imgArr ;
				$log['LOGO']["imgArr"] = $imgArr;
		}
		
		/**************** ОГРН  *******************************************/
		$OGRN = '';
		if($ORG_TYPE = Client::ORG_TYPE_INDIVIDUAL_ID){
		    $OGRN = $companyRequisite->RQ_OGRNIP;
		}
		else {
			$OGRN = $companyRequisite->RQ_OGRN;
		}
		if($OGRN!=""){
		$fileds["PROPERTY"]["OGRN"] = $OGRN;
		}
		/**************** ФИО  *******************************************/
		if($ORG_TYPE = Client::ORG_TYPE_OOO_ID){
		    if($companyRequisite->RQ_DIRECTOR!=""){
				$fileds["PROPERTY"]["CONTACT_NAME"] = $companyRequisite->RQ_DIRECTOR;
				}
			}
			//FULL_NAME
			if($companyRequisite->RQ_COMPANY_FULL_NAME!=""){
				$fileds["PROPERTY"]["FULL_NAME"] = $companyRequisite->RQ_COMPANY_FULL_NAME;
			}
			
			
			//l($fileds);
			$log['fileds'] = $fileds;
			$fileds['PROPERTY']['CREATED'] = "BX24";
			$result = Client::save($fileds);
			
			//l($result);
	}
	
	log2file('bx24Log-company-log', $log);
	$log['LOGO'] = false;
	$log['fileds'] = false;
//	log2file('bx24Log-company-log-2', $log,true);
//l($company);