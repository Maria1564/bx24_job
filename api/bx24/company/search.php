<?php

//require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/api/json-header.php");

$oBitrix = new \Zloykolobok\Bitrix24\Classes\Company();
$oBitrix->setUrl(BX_WEBHOOK_URL);
$oBitrix->setTimeout(1000);
$res = $oBitrix->companyList(['TITLE'=>'ASC'],['%TITLE'=>$_POST['title']],['ID','TITLE','PHONE','EMAIL','COMPANY_TYPE']);
echo json_encode(['code' => REQUEST_CODE_SUCCESS,'result'=>$res->result]);
