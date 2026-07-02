<?
	/*
		Категория МСП
	*/
	if ($_REQUEST['PROP']["MSP_TYPE"] ) {
		$arSubQuery = Array('IBLOCK_ID' => IBLOCK_ID_CLIENT, 'PROPERTY_MSP_TYPE' =>$_REQUEST['PROP']["MSP_TYPE"]);
		//unset($_REQUEST['PROP']["MSP_TYPE"]);	
		$rsData = CIBlockElement::GetList(Array(),$arSubQuery, false,false,  array('ID', 'IBLOCK_ID', 'NAME','PROPERTY_CLIENT')   );
		while($arFields = $rsData->Fetch()) {
			$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_CLIENT'][] = $arFields['ID'];
		}
		
	}				