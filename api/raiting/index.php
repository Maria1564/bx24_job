<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/api/json-header.php");
$raiting = new Raiting();
$arData = $raiting->setServiceRaiting($_REQUEST['UF_SERVICE_ID'], $_REQUEST['UF_RAITING'], $_REQUEST['UF_TEXT']);
//
$ChangeHistory = new ChangeHistory();
$ChangeHistory->add("raiting", ChangeHistory::ACTION_EDIT, "raiting", json_encode($_REQUEST), $_REQUEST['UF_SERVICE_ID']);
echo json_encode([
	'message'=>'<div style="color:green">Данные успешно сохранены</div>',
	'data'=>$arData,
	'_REQUEST'=>$_REQUEST,
	'code' => REQUEST_CODE_SUCCESS,
	'result' => $raiting->getRaitingById($arData['ID'])
]);
//запускаем синхронизацию с битиркс24
BX24SyncTask::bx24SynchronizationElement($_REQUEST['UF_SERVICE_ID']);

BXClearCache(true);
