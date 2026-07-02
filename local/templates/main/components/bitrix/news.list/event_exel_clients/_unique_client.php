<?
	if($_REQUEST['CLIENT_UNIQ'] == "Y" || $_REQUEST['CLIENT_UNIQ_2'] == "Y" || $_REQUEST['CLIENT_UNIQ_3'] == "Y"){
		$cache = new CPHPCache();
		$cache_time = 36000;
		$cache_path = "consult_excel";
		foreach ($arResult["ITEMS"] as &$arItem) {
			//Добавляем кеш
			$idCache = $arItem['PROPERTIES']['CLIENT']['VALUE'].$arItem['DATE_ACTIVE_FROM'];
			$cache_id = "consult_excel_".$idCache;
			// если есть в кеш, то берем из кеша
			if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)) {
				$res = $cache->GetVars();
				if (is_array($res["data"]) && (count($res["data"]) > 0)){
					$arItem['COUNT_N']=$res["data"];
					continue;
				}
			}
			//если нет в кеш то вычисляем уникальность клиента
			
			/*
				Если у клиента  были ранее услуги
			*/
			$log = [];
			$log[] = '=====================================';
			$log[] = $arItem['NAME'];
			$filter = [
			'IBLOCK_ID' => IBLOCK_ID_SERVICE , 
			'PROPERTY_TYPE'=> $isConsultPage?Service::TYPE_CONSALT_ID:Service::TYPE_SERVICE_ID,
			'!ID' => $arItem['ID'] , 
			//'<ID' => $arItem['ID'] , 
			'ACTIVE'=>'Y',
			'PROPERTY_CLIENT'=>$arItem['PROPERTIES']['CLIENT']['VALUE'], 
			//'<DATE_ACTIVE_FROM'=>$arItem['DATE_ACTIVE_FROM'],
			'<DATE_ACTIVE_FROM'=>$DATE_TO?$DATE_TO:$arItem['DATE_ACTIVE_FROM'],
			'>DATE_ACTIVE_FROM'=>$DATE_FROM?$DATE_FROM:'01.01.'.date('Y').' 01:01:00',
			];
			
			//CLIENT_UNIQ_3 Уникальный за период существования агентства
			if($_REQUEST['CLIENT_UNIQ_3'] == "Y"){
				unset($filter['>DATE_ACTIVE_FROM']);
				
			}
			
			
			$log[] = $filter;
			log2file('filterExcel',$filter);
			$rsItems = CIBlockElement::GetList(['DATE_ACTIVE_FROM' => 'ASC'], $filter, false, false, ["IBLOCK_ID", 'ID', "NAME", "CODE","DATE_ACTIVE_FROM","DATE_ACTIVE_TO","PROPERTY_CLIENT"]);
			//if($_GET['t']==3)l($filter);
			$n = 0;
			
			$arItem['COUNT_N'] = 0;
			
			while ($arItem2 = $rsItems->GetNext()) {
				$log[] = $arItem2['ID'].' | '.$arItem2['NAME'].' | '.$arItem2['DATE_ACTIVE_FROM'];
				$n++;
				$arItem['COUNT_N']=$n;
			}
			$log['COUNT_N'] = $n;
			$cache->StartDataCache($cache_time, $cache_id, $cache_path);
		    $cache->EndDataCache(["data" => $arItem['COUNT_N']]);
		}//foreach			
	}//if	