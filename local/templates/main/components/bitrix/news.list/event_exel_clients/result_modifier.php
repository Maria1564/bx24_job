<?php
	
	header('Content-Type: application/json');
	global $USER;
	
	$filePath = $_SERVER['DOCUMENT_ROOT'] . "/upload/excel_processing/" . $USER->GetID() . ".json";
	$folder = $_SERVER['DOCUMENT_ROOT'] . "/upload/excel_processing/" . $USER->GetID().'/';
	
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
	
	
	foreach ($arResult["ITEMS"] as $i => &$arItem) {
		if($arItem['PROPERTIES']['CONTACT']['VALUE']){
			
			foreach($arItem['PROPERTIES']['CONTACT']['VALUE'] as $k => $contact){
				$contact_api = Contact::getClientContactsId($contact);
				$id_client = $contact_api[0]["CLIENT"];
				$client_api = Client::getClientById($id_client);
				$arItem["CONTACTS"][$k]["ID"] = $contact;
				$arItem["CONTACTS"][$k]["NAME"] = $contact_api[0]["NAME"];
				$arItem["CONTACTS"][$k]["CLIENT"] = $client_api["NAME"];
				$arItem["CONTACTS"][$k]["INN"] = $client_api['PROPERTIES']['INN']['VALUE'];
				$arItem["CONTACTS"][$k]["BLUE_CLIENT"] = $client_api['PROPERTIES']['BLUE_CLIENT']['VALUE'];
				$arItem["CONTACTS"][$k]["PHONE"] = $contact_api[0]["PHONE"];
				$arItem["CONTACTS"][$k]["EMAIL"] = $contact_api[0]["EMAIL"];
				
				$arItem["CONTACTS"][$k]["SVO"] = $client_api['PROPERTIES']['SVO']['VALUE'];
			}
			
		}
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
		//Получаем все данные из папки 
		$arResult["ITEMS"] = [];
		foreach (glob($folder.'*') as $file) {
			if($file){
				$f = file_get_contents($file);
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
	/*
	$isConsultPage = $GLOBALS['arFilter']['PROPERTY_TYPE'] == Service::TYPE_CONSALT_ID?true:false;
	
	$filePath = $_SERVER['DOCUMENT_ROOT'] . "/upload/excel_processing/" . $USER->GetID() . ".json";
	$folder = $_SERVER['DOCUMENT_ROOT'] . "/upload/excel_processing/" . $USER->GetID().'/';
	
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
	
	

	require '_unique_client.php';
	require '_clear_items.php';
	
	$raiting = new Raiting();
	
	foreach ($arResult["ITEMS"] as &$arItem) {
		$arItem = clearFileds( $arItem);
		$arItem['PROPERTIES'] = clearPropertyArray(  $arItem['PROPERTIES']);
		
		if($arItem['PROPERTIES']['CLIENT']['VALUE']){
			$arClient =  Client::getClientById($arItem['PROPERTIES']['CLIENT']['VALUE']);
			$arClient['TYPE_NAME_INN'] = str_replace("ИНН:","",$arClient['TYPE_NAME_INN']);
			$arClient['TYPE_NAME_INN'] = str_replace("quot;",'"',$arClient['TYPE_NAME_INN']);
			if(strpos($arClient['TYPE_NAME_INN'],'ООО')!==false){
				$arClient['PROPERTIES']['ORG_TYPE']['VALUE'] = "ООО";
			}
			if(strpos($arClient['TYPE_NAME_INN'],'ИП')!==false){
	            $arClient['PROPERTIES']['ORG_TYPE']['VALUE'] = "ИП";
			}
			$arItem['CLIENT'] = [
			'TYPE_NAME_INN' => $arClient['TYPE_NAME_INN'],
			'NAME' => $arClient['NAME'],
			'INN' => $arClient['PROPERTIES']['INN']['VALUE'],
			'EMAIL' => $arClient['PROPERTIES']['EMAIL']['VALUE'],
			'PHONE' => $arClient['PROPERTIES']['PHONE']['VALUE'],
			'ORG_TYPE' =>$arClient['PROPERTIES']['ORG_TYPE']['VALUE'],
			'ADDRESS' =>$arClient['PROPERTIES']['ADDRESS']['VALUE'],
			'BLUE_CLIENT' => $arClient['PROPERTIES']['BLUE_CLIENT']['VALUE'],
			];
		}	
		$arItem['RAITING'] =  $raiting->getServiceRaitingArray($arItem['ID']);		
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
		//Получаем все данные из папки 
		$arResult["ITEMS"] = [];
		foreach (glob($folder.'*') as $file) {
			if($file){
				$f = file_get_contents($file);
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


*/