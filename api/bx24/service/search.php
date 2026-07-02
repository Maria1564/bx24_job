<?php

//require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/api/json-header.php");

$client_id = $_REQUEST['CLINET_ID'];
	$oBitrix = new \Zloykolobok\Bitrix24\Classes\Task();
$oBitrix->setUrl(BX_WEBHOOK_URL);
$oBitrix->setTimeout(1000);
//$res = $oBitrix->companyList(['TITLE'=>'ASC'],['%TITLE'=>$_POST['title']],['ID','TITLE','PHONE','EMAIL','COMPANY_TYPE']);
$res = $oBitrix->getList(
		['TITLE'=>"ASC"],
		['%TITLE'=>$_REQUEST['q'] ],
		[]
	);
	$result = $res->result;
	foreach($result as $serv){
	   $Result[] = [
	     "ID"=>$serv->ID,
	     "TITLE"=>$serv->TITLE,
	   ];
	
	}
	//l($res->result);
echo json_encode(['code' => REQUEST_CODE_SUCCESS,'result'=>$Result,'request'=>$_REQUEST]);
