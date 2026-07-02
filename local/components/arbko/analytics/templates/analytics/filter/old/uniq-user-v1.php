<?
	//CLIENT_UNIQ
	/*
	
		******************************************************************************************
	    ******************************************************************************************
		******************************************************************************************
		******************************************************************************************
		******************************************************************************************
		
		Логика такая же, как и в выгрузке. 
		Должны показываться только те консультации, которые за выбранный период являются первыми для этого клиента в году к которому принадлежит период.
		Если период вообще не указан, то должны быть выведены все первые консультации в этом году.
		
		Пример. Указан период с 15 по 20 января 2021 года. За это время было 4 консультации. 
		Клиенту Иванову - 15янв, 
		Петрову 16янв и 
		Сидорову 17янв 
		и еще раз Иванову 18янв.
		
		Мы проверяем, были ли в 2021 году уже консультации для этих клиентов. У Петрова была консультация 10 января. Значит его консультация от 16 января уже не уникальная.
		У иванова ранее консультаций не было, значит его первая консультация 15 января уникальная, а вторая 18 января уже не укикальная. У Сидорова консультаций не было в этом году, поэтому его консультация 17 января уникальная. 
		
		Итого, в уникальных консультациях у нас
		1. Иванов 15янв
		2. Сидоров 17янв
	*/
	
	if ($_REQUEST['CLIENT_UNIQ'] == "Y")
	{
		$dateForm ="01.01.".date('Y')." 00:00:00";
		$dateTo = date('d.m.Y H:i:s');
		if ($_REQUEST['DATE_FROM'])
		{
			$s = strtotime($_REQUEST['DATE_FROM']);
			$dateForm = date('d.m.Y 00:00:01', $s);
			
		}
		if ($_REQUEST['DATE_TO']){
			$s = strtotime($_REQUEST['DATE_TO']);
			$dateTo = date('d.m.Y 23:59:59', $s);
		}
		
		//Параметры фильтров
	$DATE_TO =  false;
	if($_REQUEST['DATE_TO']){
	    $s = strtotime($_REQUEST['DATE_TO']);
		$DATE_TO = date('d.m.Y 23:59:59', $s);
	}
	
	$DATE_FROM =  false;
	if($_REQUEST['DATE_FROM']){
	    $s = strtotime($_REQUEST['DATE_FROM']);
		$DATE_FROM = date('d.m.Y 23:59:59', $s);
	}
	
		
		$arFilter = Array(
		    "IBLOCK_ID" => IBLOCK_ID_SERVICE,
			'PROPERTY_TYPE'=> $isConsultPage?Service::TYPE_CONSALT_ID:Service::TYPE_SERVICE_ID,
		    ">DATE_ACTIVE_FROM"=> $dateForm,
			"<DATE_ACTIVE_FROM"=> $dateTo,
		    //'<DATE_ACTIVE_FROM'=>$DATE_TO?$DATE_TO:$arItem['DATE_ACTIVE_FROM'],'>DATE_ACTIVE_FROM'=>$DATE_FROM?$DATE_FROM:'01.01.'.date('Y').' 01:01:00',
		);
		//l($arFilter);
		$arGroupCount = [];
		$rsData = CIBlockElement::GetList(Array(), $arFilter, false,false,  array('ID', 'IBLOCK_ID', 'NAME','PROPERTY_CLIENT')   );
		while($arFields = $rsData->Fetch()) {
		   if($arFields['PROPERTY_CLIENT_VALUE']){
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
		$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_CLIENT'] = $arClientsId;
	}//$_REQUEST['CLIENT_UNIQ']