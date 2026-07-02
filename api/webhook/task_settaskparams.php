<?php

$deal_id  = $_REQUEST['data']['FIELDS_AFTER']['ID']; //ID  в crm 
$log = [];
$rsItems = CIBlockElement::GetList(array(), array('IBLOCK_ID' => IBLOCK_ID_SERVICE, "PROPERTY_BX24_TASK_ID" => $deal_id), false, false, array('ID','NAME','IBLOCK_ID','PROPERTY_SERVICE'));
$arItem = $rsItems->GetNext();
$log['arItem'] = $arItem;
if ($arItem) {
	$fields = ["UF_AUTO_178495370868"=>BX24SyncTask::getTaskLink($arItem['ID'])];			
			$log['fields'] = $fields;
			
			$oBitrix = new \Zloykolobok\Bitrix24\Classes\Task();
		    $oBitrix->setUrl(BX_WEBHOOK_URL);
		    $oBitrix->setTimeout(30);
			$result = $oBitrix->taskItemUpdate($deal_id, $fields);
			$log['result'] = $result;
	
}

log2file('bx24Log-settaskparams-log', $log);