<?php

/*
 * Получаем услуги клиента
 * 
 */
require_once($_SERVER['DOCUMENT_ROOT'] . "/api/json-header.php");
//require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
$client_id = $_REQUEST['client_id'];

if ($client_id > 0) {
	$client = Client::getServices($client_id,Service::TYPE_SERVICE_ID);
}
echo json_encode(['code' => REQUEST_CODE_SUCCESS, 'result' => $client]);
?>
