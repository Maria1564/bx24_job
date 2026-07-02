<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/api/json-header.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
$client_id = $_REQUEST['client_id'];
$raiting = new Raiting($client_id);




