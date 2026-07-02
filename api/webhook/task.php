<?php
	//Работа со сделкой  https://bx24.arbko.ru/api/webhook/bitrix24.php?event=ONTASKUPDATE&data[FIELDS_AFTER][ID]=226
	//В Битрикс24 как задачи а в системе как услуга
	
	log2file('bx24Log-task-request', $_REQUEST);
	
	$deal_id  = (int)$_REQUEST['data']['FIELDS_AFTER']['ID']; //ID  в crm 
	$GLOBALS['IGNORE_EVENT'] = 'Y';
	$loclFileName = __DIR__.'/deal_lock';
	$block = json_decode(file_get_contents($loclFileName),true);
	if($block['block'] == 1){
		$block['block'] = 0;
		file_put_contents($loclFileName ,json_encode($block));
		//	exit;
	}
	$block['block'] = 1;
	file_put_contents($loclFileName ,json_encode($block));
	
	
	
	
	$log = [];
	//Получаем все данные задачи из Битрикс24
	$oBitrix = new \Zloykolobok\Bitrix24\Classes\Task();
	$oBitrix->setUrl(BX_WEBHOOK_URL);$oBitrix->setTimeout(1000);
	$deal = $oBitrix->taskItemGetdata($deal_id);$dealObj = $deal->result;
	
	//l($dealObj);
	//exit;
	$log['deal'] = $deal;
	$MANAGER = "";
	//Получаем менеджера (пользователя )
	if ($dealObj->RESPONSIBLE_ID > 0) {
		$userData = Helper::getUserDataByBx24Id($dealObj->RESPONSIBLE_ID);
		$MANAGER = $userData['ID'];
		//l($MANAGER);
	}
	
	
	
	/************************ ПОЛУЧАЕМ СВЯЗИ ЗАДАЧИ С ДРУГИМИМ ОБЬЕКТАМИ В БИТРИКС24 **********************************/
	$companyBx24ID = 0;
	$contactBx24ID = 0;
	$dealBx24ID = 0;
	if($dealObj->UF_CRM_TASK!=null && is_array( $dealObj->UF_CRM_TASK )){
		foreach($dealObj->UF_CRM_TASK as $itemT){
			// связь с компанией
			if(strpos($itemT,"CO_")!==false){
				$companyBx24ID = str_replace("CO_","",$itemT);		 
			}
			//связь с контактом
			if(strpos($itemT,"C_")!==false){
				$contactBx24ID = str_replace("C_","",$itemT);		 
			}
			//связь со сделкой
			if(strpos($itemT,"D_")!==false){
				$dealBx24ID = str_replace("D_","",$itemT);		 
			}
		}
		
	}
	//получаем компанию!
	//Для запрета ...
	if($companyBx24ID== 50){
		//exit;		
	}
	//Если не связан с компанией то прекращаем работу!
	if ( $companyBx24ID > 0 ) {
		//В Б24 компания , а в системе как клиенты.
		$company = Client::getCLientByCrmBx24($companyBx24ID);
		$log['company'] = $company['ID'].' | '.$company['NAME'];
	}
	else {
		
		$block['block'] = 0;
		file_put_contents($loclFileName ,json_encode($block));
		exit;	
	}
	/*
		Для текущего клиента смотрим когда был создан 
		если менее минуты то блокируем.
		$company['ID']
	
	$rsItems_1 = CIBlockElement::GetList(array('ID'=>'DESC'), array('IBLOCK_ID' => IBLOCK_ID_SERVICE, "NAME" => $dealObj->TITLE,  "PROPERTY_CLIENT" => $company['ID']), false, false, array('NAME','ID','DATE_CREATE','PROPERTY_TIME_CREATE' ,'PROPERTY_BX24_TASK_ID' , 'PROPERTY_CLIENT'));
	$arItem1 = $rsItems_1->GetNext();
	if($arItem1 && $arItem1['PROPERTY_TIME_CREATE_VALUE'] > 0 ){    
		$logTime[] = $arItem1;
		$timeCreate = strtotime($arItem1['PROPERTY_TIME_CREATE_VALUE']);
		$logTime['time'] =time();
		$logTime['timeCreate'] =$timeCreate;
		$logTime[] ='time() - $timeCreate ='.(time() - $timeCreate);
		/*
			Если с момента создания последней сделки 
			не прошло 20 секунд то прекращаем работу
			Это сделано для предотвращения создания дублей
		
		if(  $arItem1['NAME'] == $dealObj->TITLE  &&  ( $timeCreate>0 && (time() - $timeCreate   < 20)  )  ){
			$block['block'] = 0;
			file_put_contents($loclFileName ,json_encode($block));
			exit;
		}
		
		log2file('bx24Log-task-log-TIME', $logTime);
	}
	*/
	
	// Получаем услугу в системе по Bitrix24 ID 
	$filter = array('IBLOCK_ID' => IBLOCK_ID_SERVICE,
	"PROPERTY_TYPE" =>Service::TYPE_SERVICE_ID,
	"=PROPERTY_BX24_TASK_ID" => $deal_id, 
	//"PROPERTY_CLIENT" => $company['ID']
	);
	$log['filter_'] = $filter;
	$rsItems = CIBlockElement::GetList(array('ID'=>'ASC'), $filter, false, false, array('NAME','ID','DATE_CREATE','DATE_ACTIVE_TO','IBLOCK_ID','PROPERTY_CREATED_SCRIPT','PROPERTY_BX24_TASK_ID','PROPERTY_CLIENT'));
	if($arItem = $rsItems->GetNext()){
		$log['arItem'] = $arItem;		
	}
	//Если не находим, то пробуем найти BX24_SITE_FILED_NAME = UF_AUTO_704497779638
	//В это свойство добавляется ID улсуги при создании.
	else 
	{		
		$BX24_SITE_FILED_NAME  =     $dealObj->UF_AUTO_704497779638;
		if($BX24_SITE_FILED_NAME  > 0){
			$filter = array('IBLOCK_ID' => IBLOCK_ID_SERVICE, "ID" => $BX24_SITE_FILED_NAME);
			$rsItems = CIBlockElement::GetList(array('ID'=>'ASC'), $filter, false, false, array('NAME','ID','DATE_CREATE','DATE_ACTIVE_TO','IBLOCK_ID','PROPERTY_CREATED_SCRIPT','PROPERTY_BX24_TASK_ID','PROPERTY_CLIENT'));
			if($arItem = $rsItems->GetNext()){
				$log['arItem_found_by_UF_AUTO_704497779638'] = $arItem;		
			}
		}		
	}
	
	
	$el = new CIBlockElement;
	$arLoadProductArray = [];
	$STATUS = 1;
	
	//если в битрикс24 статус = 5 ,то есть ЗАКРЫТ. В системе статус закрыт = 2
	if ($dealObj->STATUS == 5) {
		$STATUS = 2;//СТАТУС ЗАКРЫТ
	}
	
	//PARENT_ID
	if($dealObj->PARENT_ID > 0){
		
		$block['block'] = 0;
		file_put_contents($loclFileName ,json_encode($block));
		//exit;
	}
	
	
	
	
	
	$arLoadProductArray['PROPERTY_VALUES'] = [
	"BX24_TASK_ID" => $deal_id,
	'STATUS' => $STATUS,
	'BX24_STATUS_EXT'=>$dealObj->UF_AUTO_496520653117,//Удалось реализовать?
	'MANAGER' => $MANAGER,
	//'CLIENT' => $company['ID'],
	'COMMENT' => $dealObj->UF_AUTO_546171195401,
	"BX24_WHAT_DO"=>["VALUE"=>$dealObj->UF_AUTO_241334777195],
	'MONEY' => preg_replace("/[^0-9]/","",$dealObj->UF_AUTO_917547704171),//Денег получено (прямая поддержка)
	'MONEY2' => preg_replace("/[^0-9]/","",$dealObj->UF_AUTO_838424754255),//Денег получено (непрямая поддержка)
	
	
	
	
	];
	
	
	//--------------
	if($company['ID']>0){
		$arLoadProductArray['PROPERTY_VALUES']['CLIENT'] = $company['ID'];
	}
	//------------------
	$arLoadProductArray['IBLOCK_ID'] = IBLOCK_ID_SERVICE;
	$arLoadProductArray['ACTIVE'] = "Y";
	$arLoadProductArray['NAME'] = $dealObj->TITLE;
	$arLoadProductArray['PREVIEW_TEXT'] = Helper::normalizeBx24tags($dealObj->DESCRIPTION);
	$arLoadProductArray['PREVIEW_TEXT_TYPE'] = 'html';
	//$arLoadProductArray['DATE_ACTIVE_FROM'] = date('d.m.Y H:i:s', strtotime($dealObj->CREATED_DATE));
	$arLoadProductArray['PROPERTY_VALUES']['TYPE']['VALUE'] = Service::TYPE_SERVICE_ID;
	
	//Дата начала услуги
	if($dealObj->UF_AUTO_512193261528){
	   $arLoadProductArray['DATE_ACTIVE_FROM'] = $dealObj->UF_AUTO_512193261528;
	}
	
	//Дата начала услуги
	if($dealObj->UF_AUTO_241329687317){
	   $arLoadProductArray['DATE_ACTIVE_TO'] = $dealObj->UF_AUTO_241329687317;
	}
	
	//UF_AUTO_972964280193  Направление (код )
	if($dealObj->UF_AUTO_972964280193){
	   $arLoadProductArray['PROPERTY_VALUES']['DIRECTION'] = $dealObj->UF_AUTO_972964280193;
	}
	/*
		Если сделка закрыта то ставим время закрытия!
	*/
	if ($dealObj->STATUS == 5 && $arItem['DATE_ACTIVE_TO']!="") {
		//$arLoadProductArray['DATE_ACTIVE_TO'] = date('d.m.Y H:i:s');
	}
	
	//Добавялем в лог
	$log["arLoadProductArray"] = $arLoadProductArray;
	
	// Если такой записи не сущществует то создаем!!!
	$arLoadProductArray['PROPERTY_VALUES']['RAND'] = rand();
	
	
	
	
	
	
	
	//MICROTIME
	$arLoadProductArray['PROPERTY_VALUES']['MICROTIME'] = date('d.m.Y H:i:s');
	if (!$arItem) {
		$log['element_create'] = 1;
		//
		$arLoadProductArray['PROPERTY_VALUES']['CREATED_SCRIPT'] = __DIR__;
		$arLoadProductArray['PROPERTY_VALUES']['CREATED'] = "B24";
		//$arLoadProductArray['PROPERTY_VALUES']['TIME'] =time();
		$arLoadProductArray['PROPERTY_VALUES']['TIME_CREATE'] =time();
		
		$ELEMENT_ID = $el->Add($arLoadProductArray);
		
		if (!$ELEMENT_ID) {
			$error = $el->LAST_ERROR;
			$log["Add error"] = $error;
		}
	} 
	//Если есть, то обновляем!!!
	else {
		$log['element_update'] = 1;
		//
		if($arItem['PROPERTY_CREATED_SCRIPT_VALUE']){
		    //$arLoadProductArray['PROPERTY_VALUES']['CREATED_SCRIPT'] =$arItem['PROPERTY_CREATED_SCRIPT_VALUE'].' | '.__DIR__;
			}
		else {
			$arLoadProductArray['PROPERTY_VALUES']['CREATED_SCRIPT'] ='upadate by | '.__DIR__;
		}
		
		CIBlockElement::SetPropertyValuesEx($arItem['ID'], false, $arLoadProductArray['PROPERTY_VALUES']);
		$arLoadProductArray['PROPERTY_VALUES'] = false;
		$res = $el->Update($arItem['ID'], $arLoadProductArray);
	}
	
	$block['block'] = 0;
	file_put_contents($loclFileName ,json_encode($block));
	log2file('bx24Log-task-log', $log);
