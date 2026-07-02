<?php
	header('Content-Type: application/json');
	global $USER;
	$filePath = $_SERVER['DOCUMENT_ROOT'] . "/upload/client_excel_processing/" . $USER->GetID() . ".json";
	$folder = $_SERVER['DOCUMENT_ROOT'] . "/upload/client_excel_processing/" . $USER->GetID().'/';
	$arT = [];
	$arManagers = Helper::getManagers();
	
	/*
	foreach ($arResult["ITEMS"] as &$arItem) {
		//Получаем все не закрытые задачи для клиента
		//$arItem['ACTIVE_WORKS_COUNT'] = Client::getActiveServicesCount($arItem['ID']);
		//Послдний контакт
		$arT[] = [
		"NAME" => $arItem["~NAME"],
		"EMAIL" => $arItem['PROPERTIES']['EMAIL']['VALUE'],
		];
	}*/
	//$arResult["ITEMS"] = $arT;
	foreach ($arResult["ITEMS"] as &$arItem){
		$client = Client::getClientById($arItem["PROPERTIES"]["CLIENT"]["VALUE"]);
		$arItem['CLIENT'] = $client["NAME"];
		$arItem['INN'] = $client['PROPERTIES']['INN']['VALUE'];
		if($client['PROPERTIES']['BLUE_CLIENT']['VALUE'] == 'Y')
			$arItem['BLUE_CLIENT'] = 'Y';
		if($client['PROPERTIES']['SVO']['VALUE'] == 'Y')
			$arItem['SVO'] = 'Y';
	}
	
	if($_REQUEST['ACTION']!='MAKE_FILE'){
		if ( ($arResult['NAV_RESULT']->PAGEN-1) * $arResult['NAV_RESULT']->SIZEN < $arResult['NAV_RESULT']->NavRecordCount){
			
			if (!file_exists($folder)) {     
				mkdir($folder, 0777, true); 
			}
			
			$filePath = $folder.''.$arResult['NAV_RESULT']->PAGEN. ".json";
			if($arResult['NAV_RESULT']->PAGEN == 1){
				clearFolder($folder);
			}
			
			file_put_contents($filePath , json_encode($arResult["ITEMS"]));
			echo json_encode([
			"MODE"=>"PROCESSING",
			"COUNT"=>count($arr),
			"COUNT2"=>count($arResult["ITEMS"]),
			"PAGEN" =>$arResult['NAV_RESULT']->PAGEN,
			"SIZEN" =>$arResult['NAV_RESULT']->SIZEN,
			"NAV_RESULT" =>(int)($arResult['NAV_RESULT']->NavRecordCount),
			]);
			exit;			
		}
	}
	
	//Если все данные закешировались!	
	if( $_REQUEST['ACTION']=='MAKE_FILE' || (($arResult['NAV_RESULT']->PAGEN-1) * $arResult['NAV_RESULT']->SIZEN >= $arResult['NAV_RESULT']->NavRecordCount )  ){
		$arResult["ITEMS"] = [];
		foreach (glob($folder.'*') as $file) {
			if($file){
				$arr = json_decode(file_get_contents($file) , true);
				if($arr){
					$arResult["ITEMS"] = array_merge(  $arr,$arResult["ITEMS"]);
				}
			}
			
		}	
		
	}
	
	
	
	function clearFolder($folder) {
		if (file_exists($folder)) {
			foreach (glob($folder.'*') as $file) {
				unlink($file);
			}
		}
	}
	
	
	
	function getLastActiveData($id) {
		$res = CIBlockElement::GetList(
		['DATE_ACTIVE_FROM' => 'DESC'], ['IBLOCK_ID' => IBLOCK_ID_SERVICE, 'PROPERTY_CLIENT' => $id], false, ['nPageSize' => 1], array('IBLOCK_ID', 'ID'));
		if ($el = $res->Fetch()) {
			return $el['ACTIVE_FROM'];
		}
		return '';
	}
	
	
