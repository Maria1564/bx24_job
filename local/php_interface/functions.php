<?
	use Bitrix\Iblock;
	
	function getIBlockItems($IBLOCK_ID, $filter = [], $select = ["ID", "CODE", "NAME", "IBLOCK_ID", "PREVIEW_PICTURE", "PREVIEW_TEXT", "IBLOCK_SECTION_ID"]) {
		$cache = new CPHPCache();
		$cache_time = 36000;
		$cache_id = 'getIBlockItems' . $IBLOCK_ID . $filter['ID'] . $filter['CODE'];
		$cache_path = 'getIBlockItems' . $IBLOCK_ID . $filter['ID'] . $filter['CODE'];
		if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)) {
			$res = $cache->GetVars();
			if (is_array($res["data"]) && (count($res["data"]) > 0))
			return $res["data"];
		}
		$arReturn = [];
		CModule::IncludeModule('iblock');
		$filter['IBLOCK_ID'] = $IBLOCK_ID;
		$rsItems = CIBlockElement::GetList(['SORT' => 'ASC'], $filter, false, false, $select);
		while ($arItem = $rsItems->GetNext()) {
			$arReturn[$arItem['ID']] = $arItem;
			//$ipropValues = new Iblock\InheritedProperty\ElementValues(2, $arItem['ID']);
			//$arReturn[$arItem['ID']]['IPROPERTY_VALUES'] = $ipropValues->getValues();
		}
		$cache->StartDataCache($cache_time, $cache_id, $cache_path);
		$cache->EndDataCache(["data" => $arReturn]);
		return $arReturn;
	}
	
	
	function clearPropertyArray($array) {
		$result = [];
		foreach ($array as $code => $arr) {
			$result[$code] = [
			"VALUE" => $arr['VALUE'],
			"NAME" => $arr['NAME'],
			"VALUE_XML_ID" => $arr['VALUE_XML_ID'],
			"DESCRIPTION" => $arr['DESCRIPTION'],
			];
		}
		return $result;
	}
	
	function clearFileds($array) {
		$result = [];
		foreach ($array as $code => $arr) {
			if (strpos($code, '~') !== false)
			continue;
			$result[$code] = $arr;
		}
		return $result;
	}
	function getLogoFromBx24($url){
		$access_token = Bx24Token::getAccessToken();
		$url = str_replace('auth=','auth='.$access_token,$url);
		l($url);
		$Headers = @get_headers($url);
		$result = preg_match_all('/filename="(.*)";/',$Headers[8], $matches);
		$fileName = $matches[1][0];
		if(preg_match("|200|", $Headers[0])) {
			$image = file_get_contents($url);	
			file_put_contents($_SERVER['DOCUMENT_ROOT'] ."/upload/temp_images/".$fileName, $image);
			$fileR = CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT'] ."/upload/temp_images/".$fileName);
			/*
				$files = glob($_SERVER['DOCUMENT_ROOT'] .'/upload/temp_images/*'); // get all file names
				
				foreach($files as $file){ // iterate files
				if(is_file($file))
				//unlink($file); // delete file
				}
			*/
			return $fileR;
		}
		return false;
		
	}
	function getDepartments(){
		$cachePath = $_SERVER['DOCUMENT_ROOT'] . '/upload/file_cache/department';
		$json = file_get_contents($cachePath);
		if($json!=""){return json_decode($json,true);}
		$oBitrix = new \Zloykolobok\Bitrix24\Classes\User();
		$oBitrix->setUrl(BX_WEBHOOK_URL);
		$oBitrix->setTimeout(1000);
		
		$result = $oBitrix->sendCommand([],"department.get");
		file_put_contents($cachePath,json_encode($result));
		
		$json = file_get_contents($cachePath);
		return json_decode($json,true);
	}
	function getCompayContacts($idCompany){
		$oBitrix = new \Zloykolobok\Bitrix24\Classes\Company();
		$oBitrix->setUrl(BX_WEBHOOK_URL);
		$oBitrix->setTimeout(100);
		
		$oBitrixContact = new \Zloykolobok\Bitrix24\Classes\Contact();
		$oBitrixContact->setUrl(BX_WEBHOOK_URL);
		$oBitrixContact->setTimeout(100);
		
		$companyCOntacts = $oBitrix->companyContactItemsGet($idCompany);
		$arResult = [];
		if($companyCOntacts->result && count($companyCOntacts->result)>0 ){
			foreach($companyCOntacts->result as $obj){
				$arCONTACT_ID[] = $obj->CONTACT_ID;	
				$contact = $oBitrixContact->contactGet( $obj->CONTACT_ID);		  
				$NAME = $contact->result->LAST_NAME.' '.$contact->result->NAME;
				//Phone
				if($contact->result->PHONE[0]){
					$PHONE  = $contact->result->PHONE[0]->VALUE;
				}
				//email
				if($contact->result->EMAIL[0]){
					$EMAIL  = $contact->result->EMAIL[0]->VALUE;
				}	
				$arResult[] = [ 
				'CONTACT_ID'=>$contact->result->ID,
				'NAME'=>$NAME,
				'PHONE'=>$PHONE,
				'EMAIL'=>$EMAIL,
				];
			}
		}	
		return $arResult;
	}
	function setCompayContacts($idCompany,$fileads = [] ){
		$oBitrix = new \Zloykolobok\Bitrix24\Classes\Company();
		$oBitrix->setUrl(BX_WEBHOOK_URL);
		$oBitrix->setTimeout(100);
		
		$oBitrixContact = new \Zloykolobok\Bitrix24\Classes\Contact();
		$oBitrixContact->setUrl(BX_WEBHOOK_URL);
		$oBitrixContact->setTimeout(100);
		
		$companyCOntacts = $oBitrix->companyContactItemsGet($idCompany);
		$arResult = [];
		if($companyCOntacts->result && count($companyCOntacts->result)>0 ){
			foreach($companyCOntacts->result as $obj){
				$arCONTACT_ID[] = $obj->CONTACT_ID;	
				$contact = $oBitrixContact->contactGet( $obj->CONTACT_ID);		  
				$NAME = $contact->result->LAST_NAME.' '.$contact->result->NAME;
				//Phone
				if($contact->result->PHONE[0]){
					$PHONE  = $contact->result->PHONE[0]->VALUE;
				}
				//email
				if($contact->result->EMAIL[0]){
					$EMAIL  = $contact->result->EMAIL[0]->VALUE;
				}	
				$arResult[] = [ 
				'CONTACT_ID'=>$contact->result->ID,
				'NAME'=>$NAME,
				'PHONE'=>$PHONE,
				'EMAIL'=>$EMAIL,
				];
			}
		}	
		return $arResult;
	}
	function download_send_headers($filename) {
		// disable caching
		$now = gmdate("D, d M Y H:i:s");
		header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
		header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
		header("Last-Modified: {$now} GMT");
		
		// force download
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		
		// disposition / encoding on response body
		header("Content-Disposition: attachment;filename={$filename}");
		header("Content-Transfer-Encoding: binary");
	}
	
	function array2csv(array &$array, $titles) {
		if (count($array) == 0) {
			return null;
		}
		ob_start();
		$df = fopen("php://output", 'w');
		fputcsv($df, $titles, ';');
		foreach ($array as $row) {
			fputcsv($df, $row, ';');
		}
		fclose($df);
		return ob_get_clean();
	}
	
	/**
		* Функция генерирует CSV файл из входного массива
		* и возвращает полный путь до файла
		* @return string
	*/
	function createCSVFile($fileName, $arTitle, $arInput) {
		$filePath = $_SERVER['DOCUMENT_ROOT'] . "/upload/csv/" . $fileName . ".csv";
		//$filePath = $_SERVER['DOCUMENT_ROOT'] . "/upload/csv/1_.csv";	
		$file = fopen($filePath, 'w');  /* записываем в файл */
		
		
		fputcsv($file, toWindow($arTitle), ";");
		
		foreach ($arInput as $fields) {
			
			$arT = [];
			foreach ($arTitle as $code => $no) {
				if ($fields[$code] == NULL) {
					$fields[$code] = "-";
				}
				$arT[$code] = $fields[$code] . " ";
				//echo $code.'=>'.$fields[$code];
				//fputcsv($file, toWindow($fields[$code]), ";");
			}
			fputcsv($file, toWindow($arT), ";");
		}
		
		fclose($file);
		return str_replace($_SERVER['DOCUMENT_ROOT'], "", $filePath);
	}
	
	/*
		* Возвращает категории 1 го уровня инфоблока
	*/
	
	function toWindow($ii) {
		//return $ii;
		return mb_convert_encoding($ii, "cp1251");
	}
	
	function getIblockCategory($IBLOCK_ID) {
		$cache = new CPHPCache();
		$cache_time = 36000;
		$cache_id = "news";
		$cache_path = "getIblockCategory" . $IBLOCK_ID;
		if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)) {
			$res = $cache->GetVars();
			if (is_array($res["data"]) && (count($res["data"]) > 0))
			return $res["data"];
		}
		
		CModule::IncludeModule('iblock');
		$uf_arresult = CIBlockSection::GetList(["SORT" => "ASC"], ["IBLOCK_ID" => $IBLOCK_ID, "ACTIVE" => "Y"], false, ['ID', "NAME", "CODE"]);
		
		while ($res = $uf_arresult->GetNext()) {
			$arReturn[$res['ID']] = $res;
		}
		$cache->StartDataCache($cache_time, $cache_id, $cache_path);
		$cache->EndDataCache(["data" => $arReturn]);
		return $arReturn;
	}
	
	/*
		* Возвращает года записей 
	*/
	
	function getNewsYears($IBLOCK_ID) {
		//ORM D7
		$query = new \Bitrix\Main\Entity\Query(Bitrix\Iblock\ElementTable::getEntity());
		$query->registerRuntimeField(
		"YEAR", array(
		"data_type" => "Datetime",
		"expression" => array("LEFT(ACTIVE_FROM,4)", "ACTIVE_FROM")
		))
		->setSelect(array('YEAR'))
		->setFilter(array("IBLOCK_ID" => $IBLOCK_ID, 'ACTIVE' => 'Y', '!ACTIVE_FROM' => ''))
		->setOrder(array("YEAR" => "DESC"))
		->setGroup(array("YEAR"))
		->setLimit(5);
		$db = $query->exec();
		$arrYears = $db->fetchAll();
		return $arrYears;
		//Выбранная дата для фильтра
	}
	
	function log2file($name, $arr, $isUpdate = false) {
		ob_start();
		print_r($arr);
		if ($isUpdate) {
			$log = ob_get_contents();
			$log2 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/local/log/" . $name . ".txt");
			$log2 = $log . '
			--------------
			' . $log2;
			file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/local/log/" . $name . ".txt", $log2);
			} else {
			file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/local/log/" . $name . ".txt", ob_get_contents());
		}
		ob_clean();
	}
	
	/*
		* Вывод массива
	*/
	
	function l($arr) {
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}
	
	function FileSizeConvert($bytes) {
		$bytes = floatval($bytes);
		$arBytes = array(
		0 => array(
		"UNIT" => "TB",
		"VALUE" => pow(1024, 4)
		),
		1 => array(
		"UNIT" => "GB",
		"VALUE" => pow(1024, 3)
		),
		2 => array(
		"UNIT" => "MB",
		"VALUE" => pow(1024, 2)
		),
		3 => array(
		"UNIT" => "KB",
		"VALUE" => 1024
		),
		4 => array(
		"UNIT" => "B",
		"VALUE" => 1
		),
		);
		
		foreach ($arBytes as $arItem) {
			if ($bytes >= $arItem["VALUE"]) {
				$result = $bytes / $arItem["VALUE"];
				$result = str_replace(".", ",", strval(round($result, 2))) . " " . $arItem["UNIT"];
				break;
			}
		}
		return $result;
	}
