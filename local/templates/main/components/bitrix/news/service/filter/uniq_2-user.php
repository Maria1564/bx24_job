<?
	
	/*
		Добавить такую возможность.
		Выбираем ,к примеру, период 01.03.20-01.05.20
		Возможно ставить где-то галочку, чтобы считать уникальными с начала года.
		
		Те функции, что есть сейчас - оставляем.
	*/
	//CLIENT_UNIQ_2
	
	
	if ($_REQUEST['CLIENT_UNIQ_2'] == "Y")
	{
		
		
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
		
		
		$arFilter = Array(
		'ACTIVE'=>'Y',
		"IBLOCK_ID" => IBLOCK_ID_SERVICE,
		'PROPERTY_TYPE'=> $isConsultPage?Service::TYPE_CONSALT_ID:Service::TYPE_SERVICE_ID,
		">DATE_ACTIVE_FROM"=> '01.01.'.date('Y').' 00:00:01',
		"<DATE_ACTIVE_FROM"=> $DATE_TO,
		">PROPERTY_CLIENT"=>1,
		//'<DATE_ACTIVE_FROM'=>$DATE_TO?$DATE_TO:$arItem['DATE_ACTIVE_FROM'],'>DATE_ACTIVE_FROM'=>$DATE_FROM?$DATE_FROM:'01.01.'.date('Y').' 01:01:00',
		);
		//l($arFilter);
		$arGroupCount = [];
		$needIds = [];
		$rsData = CIBlockElement::GetList(Array(), $arFilter, false,false,  array('ID', 'IBLOCK_ID', 'NAME','PROPERTY_CLIENT')   );
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
		if($_GET['log'] == 1){
			l($arGroupCount);
		}
		//$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_CLIENT'] = $arClientsId;
		$GLOBALS[$arParams["FILTER_NAME"]]['ID'] = $needIds;
	}//$_REQUEST['CLIENT_UNIQ']
