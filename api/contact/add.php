<?php

//require_once($_SERVER['DOCUMENT_ROOT'] . "/api/json-header.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");


$result = Contact::save($_REQUEST);
echo json_encode([
  'code'=>'ok',
  'result'=>$result,
  'd'=>$_REQUEST,
]);
	
	