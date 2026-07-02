<?php
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("MainEventClass", "event"));
AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("MainEventClass", "event"));
define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log_test.txt");
class MainEventClass {

	function event(&$arFields) {
		if ($arFields['IBLOCK_ID'] == Service::IBLOCK_ID) {
			if ($arFields['ID'] > 0) {
				$service = Service::getServiceById($arFields['ID']);
				//$res_service = CIBlockElement::GetList(['DATE_ACTIVE_FROM' => 'ASC'], ['IBLOCK_ID' => Service::IBLOCK_ID, 'PROPERTY_CLIENT' => $service['PROPERTIES']['CLIENT']['VALUE']], false, ['nPageSize' => 1], array('IBLOCK_ID', 'ID', 'ACTIVE_FROM'));
				$res_clients = CIBlockElement::GetList(['DATE_ACTIVE_FROM' => 'DESC'], ['IBLOCK_ID' => Client::CLIENT_IBLOCK_ID, 'ID' => $service['PROPERTIES']['CLIENT']['VALUE']], false, ['nPageSize' => 1], array('IBLOCK_ID', 'ID', 'ACTIVE_FROM'));
				/*if ($el_service = $res_service->Fetch()) {
					$created_service = $el_service['ACTIVE_FROM'];
				}*/
				$created_service = $service['ACTIVE_FROM'];
				AddMessage2Log($service);
				AddMessage2Log($created_service);
				if ($el_client = $res_clients->Fetch()) {
					$created_client = $el_client['ACTIVE_FROM'];
				}
				AddMessage2Log($created_client);
				if(MakeTimeStamp($created_service) < MakeTimeStamp($created_client)){
					CIBlockElement::SetPropertyValueCode($el_client["ID"], "SORT_DATE", $created_service);
				}	
				else{
					CIBlockElement::SetPropertyValueCode($el_client["ID"], "SORT_DATE", $created_client);
				}
				/*
				if ($el_service = $res_service->Fetch()) {
					$created_service = $el_service['ACTIVE_FROM'];
					if($created_service < $created_client){
						CIBlockElement::SetPropertyValueCode($el_client["ID"], "SORT_DATE", $created_service);
					}	
					else{
						CIBlockElement::SetPropertyValueCode($el_client["ID"], "SORT_DATE", $created_client);
					}
				}
				else{
					CIBlockElement::SetPropertyValueCode($el_client["ID"], "SORT_DATE", $created_client);
				}
				*/
			}
		}
	}
}	

AddEventHandler("iblock", "OnBeforeIBlockElementDelete", Array("MyClass", "OnBeforeIBlockElementDeleteHandler"));
class MyClass
{
	// создаем обработчик события "OnBeforeIBlockElementDelete"
	public static function OnBeforeIBlockElementDeleteHandler($ID)
	{
		define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log_delete/log.txt");
		AddMessage2Log("Удален элемент с ID = ". $ID);
	}
}


/*
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("MainEventClass", "event"));
AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("MainEventClass", "event"));

//AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("MainEventClass", "setMsp"));
//AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("MainEventClass", "setMsp"));

class MainEventClass {

	function event(&$arFields) {

		if ($GLOBALS['IGNORE_EVENT'] == 'Y') {
			log2file('event-ignored', ['Y']);
			return;
		}
		if ($arFields['IBLOCK_ID'] == Client::CLIENT_IBLOCK_ID) {
			if ($arFields['ID'] > 0) {
				BX24SyncCompany::bx24SynchronizationElement($arFields['ID']);
			}
		}
		if ($arFields['IBLOCK_ID'] == Service::IBLOCK_ID) {
			if ($arFields['ID'] > 0) {
				$service = Service::getServiceById($arFields['ID']);
				//log2file('TYPE_CONSALT_ID', $service);
				if ($service['PROPERTIES']['TYPE']['VALUE_ENUM_ID'] == Service::TYPE_CONSALT_ID) {
					
					//BX24SyncDeal::run($arFields['ID']);
				} else {
					BX24SyncTask::bx24SynchronizationElement($arFields['ID']);
				}
			}
		}
	}

	function setMsp(&$arFields) {
		if ($arFields['IBLOCK_ID'] == Client::CLIENT_IBLOCK_ID) {
		$arClient = Client::getClientById($arFields['ID']);
		
		$inn = $arClient['PROPERTIES']['INN']['VALUE'];
		if( strlen($inn)>5){
		           
					$msp = new MSP($inn);
					$ar1 = $msp->isMSP();
					if($ar1['IS_MSP']){
					     $prop['MSP'] = array('VALUE' => 13);
						 $prop['MSP_TEXT'] = array('VALUE' => $ar1['TEXT']);
				    	CIBlockElement::SetPropertyValuesEx($arFields['ID'], Client::CLIENT_IBLOCK_ID, $prop);
					}
	             //CIBlockElement::SetPropertyValuesEx($arFields['ID'], Client::CLIENT_IBLOCK_ID, $prop);
		}else {
		         $prop['MSP'] = array('VALUE' => false);
	             //CIBlockElement::SetPropertyValuesEx($arFields['ID'], Client::CLIENT_IBLOCK_ID, $prop);
		}
			log2file('MainEventClass-setMsp',[$inn,$arFields]);
		}
	}
}
*/

