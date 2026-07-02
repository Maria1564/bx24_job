<?php
//Работа со сделкой
// В системе как консультации
log2file('bx24Log-deal-request', $_REQUEST);

$deal_id  = $_REQUEST['data']['FIELDS']['ID']; //ID сделки в crm 
$log = [];



$oBitrix = new \Zloykolobok\Bitrix24\Classes\Deal();
$oBitrix->setUrl(BX_WEBHOOK_URL);
$oBitrix->setTimeout(1000);

$deal = $oBitrix->dealGet($deal_id);
$dealObj = $deal->result;
l($deal);
log2file('bx24Log-deal-deal', $deal);
$log[] = $deal;
$MANAGER = "";

$STATUS = 1; //в работе

if ($dealObj->CLOSED == "Y") {
	$STATUS = 2;
}

//UF_CRM_1591775169012 - Учитывать консультацию в системе? 48 - учитывать. 50 - не учитывать
if ($dealObj->UF_CRM_1591775169012 != 48){
		exit;
}
//CATEGORY_ID  если не "Обращения предпринимателей" то не записываем в систему
if ($dealObj->CATEGORY_ID != 2){
		exit;
}

/****************************  СТАТУСЫ СДЕЛОК ******************************************/
/*
	 [STAGE_ID] => C12:NEW - новая сделка
	 [STAGE_ID] => C12:LOSE - сделка провалена
	 [STAGE_ID] => C12:APOLOGY - анализ причины провала
	 [STAGE_ID] => C12:WON - Успешно завершена
	 
*/

$BX24_STATUS = $dealObj->STAGE_ID;
if ($dealObj->STAGE_ID == "C12:NEW"){
		//exit;
}


/****************************  ОТВЕТСВТЕННЫЙ  ******************************************/
if ($dealObj->ASSIGNED_BY_ID > 0) {
	$userData = Helper::getUserDataByBx24Id($dealObj->ASSIGNED_BY_ID);
	$MANAGER = $userData['ID'];
}

if ($dealObj->COMPANY_ID > 1) {
	$company = Client::getCLientByCrmBx24($dealObj->COMPANY_ID);
	$log['company'] = $company['ID'].'|'.$company['NAME'];
}else {
	exit;	
}

$rsItems = CIBlockElement::GetList(array(), array('IBLOCK_ID' => IBLOCK_ID_SERVICE, "PROPERTY_BX24_TASK_ID" => $deal_id, "PROPERTY_TYPE" =>Service::TYPE_CONSALT_ID), false, false, array('ID','NAME','IBLOCK_ID','PROPERTY_SERVICE'));
$arItem = $rsItems->GetNext();
$log['arItem'] = $arItem;
$el = new CIBlockElement;
$arLoadProductArray = [];


//UF_CRM_1590125984188 - комментарий консультанат. Кстомное поле
$arLoadProductArray['PROPERTY_VALUES'] = [
    "BX24_STATUS"=>$BX24_STATUS,
	"BX24_TASK_ID" => $deal_id,
	'STATUS' => $STATUS,
	'MANAGER' => $MANAGER,
	'COMMENT' => $dealObj->UF_CRM_1590125984188,
	'SERVICE'=>$arItem['PROPERTY_SERVICE_VALUE'],//сохраняем связь с услугой
	'CLIENT' => $dealObj->COMPANY_ID > 1 ? $company['ID'] : false,
];
$arLoadProductArray['IBLOCK_ID'] = IBLOCK_ID_SERVICE;
$arLoadProductArray['ACTIVE'] = "Y";
$arLoadProductArray['NAME'] = $dealObj->TITLE;
$arLoadProductArray['PREVIEW_TEXT'] = $dealObj->COMMENTS;
$arLoadProductArray['PREVIEW_TEXT_TYPE'] = 'html';
$arLoadProductArray['DATE_ACTIVE_FROM'] = date('d.m.Y H:i:s', strtotime($dealObj->DATE_CREATE));
$arLoadProductArray['PROPERTY_VALUES']['TYPE']['VALUE'] = Service::TYPE_CONSALT_ID;

l($arLoadProductArray);
$log[] = $arLoadProductArray;
if (!$arItem) {
	$ELEMENT_ID = $el->Add($arLoadProductArray);
	if (!$ELEMENT_ID) {
		$error = $el->LAST_ERROR;
	}
} else {
	
	CIBlockElement::SetPropertyValuesEx($arItem['ID'], false, $arLoadProductArray['PROPERTY_VALUES']);
	$arLoadProductArray['PROPERTY_VALUES'] = false;
	$res = $el->Update($arItem['ID'], $arLoadProductArray);
}
log2file('bx24Log-deal-log', $log);