<?
	

	
	$arFilter = $GLOBALS[$arParams["FILTER_NAME"]];
	$arFilter = Array(
	'ACTIVE'=>'Y',
	"IBLOCK_ID" => IBLOCK_ID_SERVICE,
	//'PROPERTY_TYPE'=> $isConsultPage?Service::TYPE_CONSALT_ID:Service::TYPE_SERVICE_ID,
	//">DATE_ACTIVE_FROM"=> '01.01.'.date('Y').' 00:00:01',
	//"<DATE_ACTIVE_FROM"=> $DATE_TO,
	//">PROPERTY_CLIENT"=>1,
	//'<DATE_ACTIVE_FROM'=>$DATE_TO?$DATE_TO:$arItem['DATE_ACTIVE_FROM'],'>DATE_ACTIVE_FROM'=>$DATE_FROM?$DATE_FROM:'01.01.'.date('Y').' 01:01:00',
	);
	 $arResult['SERVICE_COUNT'] = 0;
	 $arResult['CONSULT_COUNT'] = 0;
	$arFilter = array_merge($arFilter,$GLOBALS[$arParams["FILTER_NAME"]]);
	//l($arFilter );
	$rsData = CIBlockElement::GetList(Array(), $arFilter, false,false,  array('ID', 'IBLOCK_ID', 'NAME','PROPERTY_CLIENT')   );
	while($ob = $rsData->GetNextElement()) {
		$arFields = $ob->GetFields();  
		$arProps = $ob->GetProperties();
	//	l($arProps);
		$arResultx['ITEMS'][] = [
		"ID"=>$arFields['ID'],
		"NAME"=>$arFields['NAME'],
		"PROPERTY_TYPE"=>$arProps['TYPE']['VALUE'],
		"PROPERTY_TYPE_VALUE"=>$arProps['TYPE']['VALUE_ENUM_ID'],
		];
		if($arProps['TYPE']['VALUE_ENUM_ID'] == 1){
		   $arResult['SERVICE_COUNT']+=1;
		}
		if($arProps['TYPE']['VALUE_ENUM_ID'] == 2){
		   $arResult['CONSULT_COUNT']+=1;
		}
		
		//-----------------
		//субсидии/гранты)
		$arResult['MONEY']+=$arProps['MONEY']['VALUE'];
		
		// (кредиты/займы)
		$arResult['MONEY2']+=$arProps['MONEY2']['VALUE'];
		
		//руб. (госбюджет/АРБ)
		$arResult['MONEY3']+=$arProps['MONEY3']['VALUE'];
				
		//Денег получено
		
	}