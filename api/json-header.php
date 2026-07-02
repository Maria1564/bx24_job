<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
header('Content-Type: application/json');
if(!$USER->IsAuthorized()){
	echo json_encode(['code' => 'error','statusText'=>'user is not auth']);
	exit;
}
