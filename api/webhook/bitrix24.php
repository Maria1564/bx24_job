<?php

/*
 * Все события с CRM Bitrix24 отправляются
 * на этот скрипт.
 * 
 */
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
session_start();
$GLOBALS['IGNORE_EVENT'] = 'Y';//игнорируем события обновления 
if($_SESSION['IGNORE_WEBHOOK']=="Y"){
	$_SESSION['IGNORE_WEBHOOK'] = "N";
	exit;
}
$eventType = $_REQUEST['event'];
$ID = $_REQUEST['data']['FIELDS']['ID']; // ID измененного обьекта
$log = [];
$type = $_REQUEST['type'];
//settaskparams
if ($type == 'settaskparams') {
	//include 'task_settaskparams.php';
	exit;
}

// КОМПАНИЯ 
if ($eventType == 'ONCRMCOMPANYUPDATE' || $eventType == 'ONCRMCOMPANYADD') {
	include 'company.php';
}
if ($eventType == 'ONCRMCOMPANYDELETE') {
	include 'company_delete.php';
}

//СДЕЛКИ 
if ($eventType == 'ONCRMDEALADD' || $eventType == 'ONCRMDEALUPDATE') {
	include 'deal.php';
}

//ЗАДАНИЯ 
if ($eventType == 'ONTASKADD' || $eventType == 'ONTASKUPDATE') {
	include 'task.php';
}