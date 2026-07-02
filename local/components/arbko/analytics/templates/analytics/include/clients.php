<?
	$DATE_TO =  false;
	if($_REQUEST['DATE_TO']){
	    $s = strtotime($_REQUEST['DATE_TO']);
		$DATE_TO = date('d.m.Y 23:59:59', $s);
	}
	
	$DATE_FROM =  false;
	if($_REQUEST['DATE_FROM']){
	    $s = strtotime($_REQUEST['DATE_FROM']);
		$DATE_FROM = date('d.m.Y 00:00:01', $s);
	}
	
	$arFilterClient = [
		'ACTIVE'=>'Y',
		"IBLOCK_ID" => Client::CLIENT_IBLOCK_ID,
		  ">DATE_ACTIVE_FROM"=> $DATE_FROM,
		  "<DATE_ACTIVE_FROM"=> $DATE_TO,
		];
	l($arFilterClient);
	$res = CIBlockElement::GetList(false, $arFilterClient, array('IBLOCK_ID'));
	if ($el = $res->Fetch()) {
		l($el);
	}	
	
	$arResult['CLIENT_COUNT'] = $el['CNT'];