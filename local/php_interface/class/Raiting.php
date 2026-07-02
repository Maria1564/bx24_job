<?php
	
	use Bitrix\Main\Loader;
	use Bitrix\Highloadblock as HL;
	
	class Raiting {
		
		var $HL_ID = 1;
		var $entity = null;
		var $client_id = null;
		
		function __construct($client_id = false) {
			$this->client_id = $client_id;
			Loader::includeModule("highloadblock");
			Loader::includeModule("main");
			$hlblock = HL\HighloadBlockTable::getById($this->HL_ID)->fetch();
			$this->entity = HL\HighloadBlockTable::compileEntity($hlblock);
		}
		
		public function getAllData(){
		    $entity_data_class = $this->entity->getDataClass();
			$arFilter = ['UF_CLIENT_ID' => $this->client_id];
			$rsData = $entity_data_class::getList(
			[
			"select" => array("*"),
			"order" => array("ID" => "DESC"),
			"filter" => $arFilter
			]);
			$arResult = [];
			while ($arData = $rsData->Fetch()) {
				$arResult[] = $arData;
			}
			return $arResult;
		}
		public function getServiceRaiting($service_id) {
			$ar = $this->getServiceRaitingArray($service_id);
			return $ar['UF_RAITING'];
		}
		
		public function getServiceRaitingArray($service_id) {
			
			
			$cache = new CPHPCache();
			$cache_time = 360;
			$cache_id = "getServiceRaitingArray".$service_id;
			$cache_path = "getServiceRaitingArray";
			if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)) {
				$res = $cache->GetVars();
				if (is_array($res["data"]) && (count($res["data"]) > 0))
				return $res["data"];
			}
			
			$entity_data_class = $this->entity->getDataClass();
			$arFilter = ['UF_SERVICE_ID' => $service_id];
			$rsData = $entity_data_class::getList(
			[
			"select" => array("*"),
			"order" => array("ID" => "DESC"),
			"filter" => $arFilter
			]);
			if(is_array($service_id)){
				while($arData2 = $rsData->Fetch()){
					$arData[] = $arData2;
				}
				
			}
			else {
				$arData = $rsData->Fetch();
				
			}
			
			
			if (!$arData) {
				
			    /*
					$arData = [
					"UF_SERVICE_ID" => $service_id,
					"UF_RAITING" => "",
					'UF_TEXT' => ""
					];
				*/
				$arData = false;
			}
			
			$cache->StartDataCache($cache_time, $cache_id, $cache_path);
			$cache->EndDataCache(["data" => $arData]);
			return $arData;
			
		}
		
		public function setServiceRaiting($service_id, $raiting="", $text = "",$arInput=[]) {
			global $USER;
			$entity_data_class = $this->entity->getDataClass();
			$rsData = $entity_data_class::getList(
			array("select" => array("*"),
			"order" => array("ID" => "ASC"),
			"filter" => array(
			"UF_SERVICE_ID" => $service_id,
			)
			)
			);
			//	if($raiting == "")$raiting=0;
			if ($raiting > 10)
			$raiting = 10;
			if ($raiting < 0)
			$raiting = 0;
			
			
			//Если есть то обновляем
			if ($arData = $rsData->Fetch()) {
				$ID = $arData['ID'];
				$arF = ["UF_RAITING" => $raiting];
				if($text!==false){
					$arF["UF_TEXT"] =$text;
				}
				//l($arF);
				$arF = array_merge($arF,$arInput);
				//l($arF);
				$result = $entity_data_class::update($arData['ID'],$arF );
			}
			//Добавляем
			else {
				$service = Service::getServiceById($service_id);
				$client_id = $service['PROPERTIES']['CLIENT']['VALUE'];
				
				$arF = [
				"UF_TIME" => time(),
				"UF_CLIENT_ID" => $client_id,
				"UF_SERVICE_ID" => $service_id,
				"UF_RAITING" => (int) $raiting,
				'UF_TEXT' => $text,
				'UF_MANAGER_ID' => $USER->GetID(),
				];
				$arF = array_merge($arF,$arInput);
				
				$result = $entity_data_class::add($arF);
				if ($result->isSuccess()) {
					
					$ID = $result->getId(); // получаем ID созданного элемента хайлоадблока
				}
			}
			//Обновляем оценку у услуги
			Service::setSmsVote($service_id,(int)$raiting);
			return ["ID" => $ID, "RESULT" => $result];
		}
		
		public function getRaitingById($id) {
			$entity_data_class = $this->entity->getDataClass();
			$rsData = $entity_data_class::getList(
			array("select" => array("*"),
			"order" => array("ID" => "ASC"),
			"filter" => array(
			"ID" => $id,
			)
			)
			);
			$arData = $rsData->Fetch();
			return $arData;
		}
		
		public function getClientMiddleRaiting() {
			$entity_data_class = $this->entity->getDataClass();
			$arFilter = ['UF_CLIENT_ID' => $this->client_id];
			$rsData = $entity_data_class::getList(
			[
			"select" => array("*"),
			"order" => array("ID" => "DESC"),
			"filter" => $arFilter
			]);
			//Если есть то обновляем
			$raitng = 0;
			$count = 0;
			while ($arData = $rsData->Fetch()) {
				if($arData['UF_RAITING']>0){
					$count++;
					$raitng += $arData['UF_RAITING'];
				}
			}
			
			if ($count == 0)
			return 0;
			
			return number_format(round($raitng / $count, 2, PHP_ROUND_HALF_UP), 1);
		}
		
	}
