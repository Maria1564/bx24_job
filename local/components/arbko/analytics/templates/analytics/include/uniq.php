<?
	/*
		Получаем уникальных клиентов за период
	*/
	
	
	//Параметры фильтров
	
	
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
	
	
	$arFilterUniq = Array(
	'ACTIVE'=>'Y',
	"IBLOCK_ID" => IBLOCK_ID_SERVICE,
	//'PROPERTY_TYPE'=> $isConsultPage?Service::TYPE_CONSALT_ID:Service::TYPE_SERVICE_ID,
	">DATE_ACTIVE_FROM"=> $DATE_FROM,
	"<DATE_ACTIVE_FROM"=> $DATE_TO,
	">PROPERTY_CLIENT"=>1,
	);

	$arGroupCount = [];
	$needIds = [];
	$rsData = CIBlockElement::GetList(Array(), $arFilterUniq, false,false,  array('ID', 'IBLOCK_ID', 'NAME','PROPERTY_CLIENT')   );
	while($arFields = $rsData->Fetch()) {
		
		if(!$arGroupCount[$arFields['PROPERTY_CLIENT_VALUE']]){
			$needIds[] = $arFields['ID'];
		}
		if($arFields['PROPERTY_CLIENT_VALUE']>0){
			$arGroupCount[$arFields['PROPERTY_CLIENT_VALUE']]++; 
		}
	}
	$arClientsId = [];
	foreach($arGroupCount as $clientID => $consultCount){
		if($consultCount <= 1){
			$arClientsId[] = $clientID;
		}	
	}
	$arResult['CLIENT_COUNT'] = count($arGroupCount);
	$arResult['CLIENT_UNIQ_PERIOD_COUNT'] = count($arClientsId);
	
	
	
	
	
	
	
	
	
	
	
	//ЗА ГОД
	$s = strtotime($_REQUEST['DATE_FROM']);
    $Year = date('Y', $s);
	$DATE_TO = '31.12.'.$Year.' 23:59:59';
	$DATE_FROM =  '01.01.'.$Year.' 00:00:01';
	$arFilterUniq = Array(
	'ACTIVE'=>'Y',
	"IBLOCK_ID" => IBLOCK_ID_SERVICE,
	//'PROPERTY_TYPE'=> $isConsultPage?Service::TYPE_CONSALT_ID:Service::TYPE_SERVICE_ID,
	">DATE_ACTIVE_FROM"=> $DATE_FROM,
	"<DATE_ACTIVE_FROM"=> $DATE_TO,
	">PROPERTY_CLIENT"=>1,
	);

	$arGroupCount = [];
	$needIds = [];
	$rsData = CIBlockElement::GetList(Array(), $arFilterUniq, false,false,  array('ID', 'IBLOCK_ID', 'NAME','PROPERTY_CLIENT')   );
	while($arFields = $rsData->Fetch()) {
		
		if(!$arGroupCount[$arFields['PROPERTY_CLIENT_VALUE']]){
			$needIds[] = $arFields['ID'];
		}
		if($arFields['PROPERTY_CLIENT_VALUE']>0){
			$arGroupCount[$arFields['PROPERTY_CLIENT_VALUE']]++; 
		}
	}
	$arClientsId = [];
	foreach($arGroupCount as $clientID => $consultCount){
		if($consultCount <= 1){
			$arClientsId[] = $clientID;
		}	
	}
	$arResult['CLIENT_UNIQ_YEAR'] = $Year;
	$arResult['CLIENT_UNIQ_YEAR_COUNT'] = count($arClientsId);
	