<?php
	
	/*
		* Класс Helper
	*/
	use Bitrix\Main\Loader;
	use Bitrix\Highloadblock as HL;
	
	class Helper {
		
		public static function getFinanceSource(){
			$arINCOME = [
			"МЭР РФ",
			"МСХ РФ",
			"ФРП РФ",
			"ФРП КО",
			"РЛК",
			"ФРМ",
			"ГФПП КО",
			"Корпорация МСП ",
			"Минпромторг",
			"ФСИ",
			"МЭР КО",
			"Фонд Сколково",
			"Федеральное агентство по туризму",
			"РЭЦ",
			"Субсидии МО",
			"ЦЗН",
			"Минцифры РФ",
			"Минконкурент",
			"Соцзащита",
			"МСХ КО",
			"АО ''Росагролизинг''",
			"ФП Акселерация",
			"Прочее",			
			];
			return $arINCOME;
			
		}
		/*
		ВНИМАНИЕ.
		Данных хранятся в виде значений. То есть хранится не ключ.
		*/
		public static function getIncomings(){
			$arINCOME = [
			"ВКонтакте",
			"Telegram",
			"Портал ARBKO.RU",
			"ТВ",
			"Радио",
			"Печатные СМИ",
			"Digital-СМИ (интернет)",
			"Наружная реклама",
			"Внешние рекомендаци",
			"Перенаправление из муниципальных и госорганизаций",
			"Холодные звонки или рассылка",
			"Горячая линия",
			"Facebook",
			"Instagram"
			//"Прочее"
			];
			return $arINCOME;
			
		}
		public static function getManagersExt(){
			
			$arDirections = Helper::getDirections();
			//l(	$arDirections );
			$arDirectionsF = '';
			foreach(	$arDirections  as $arr){
				$arDirectionsF.= $arr['UF_XML_ID'].' ';
			}
	   		$result = \Bitrix\Main\UserGroupTable::getList(array(
			'filter' => array('GROUP_ID' => [1, MANAGERS_GROUP_ID], 'USER.ACTIVE' => 'Y','!=USER.UF_DIRECTIONS'=>''),
			'select' => array(
			'USER_ID', 
			'SECOND_NAME' => 'USER.SECOND_NAME', 
			'WORK_DEPARTMENT' => 'USER.WORK_DEPARTMENT', 
			'EMAIL' => 'USER.EMAIL',
			'NAME' => 'USER.NAME', 
			'LAST_NAME' => 'USER.LAST_NAME',
			'UF_DIRECTIONS'=>'USER.UF_DIRECTIONS',
			'UF_BX24_USER_ID'=>'USER.UF_BX24_USER_ID'), // выбираем идентификатор п-ля, имя и фамилию
			'order' => array('USER.LAST_NAME' => 'ASC'), // сортируем по идентификатору пользователя
			));
			$ar = [];
			$arEx  = [];
			while ($arGroup = $result->fetch()) {
				//	l($arGroup); 
			$ar[$arGroup['USER_ID']] = $arGroup;
			
			}
			return $ar;
			
			}
			
			
			public static function getDirections(){
			$cache = new CPHPCache();
			$cache_time = 360000 * 60;
			$cache_id = 'getDirections';
			$cache_path = 'getDirections';
			if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path))
			{
			$res = $cache->GetVars();
			if (is_array($res["data"]) && (count($res["data"]) > 0)) return $res["data"];
			}
			Loader::includeModule("highloadblock");
			Loader::includeModule("main");
			$hlblock = HL\HighloadBlockTable::getById(3)->fetch();
			$entity = HL\HighloadBlockTable::compileEntity($hlblock);
			$entity_data_class = $entity->getDataClass();
			$rsData = $entity_data_class::getList(["select" => array(
            "*"
			) , "order" => array(
            "UF_SORT" => "ASC"
			) , "filter" => [], "limit" => 15, ]);
			while ($arData = $rsData->Fetch())
			{
			$arResult[$arData["ID"]] = $arData;
			}
			$cache->StartDataCache($cache_time, $cache_id, $cache_path);
			$cache->EndDataCache(["data" => $arResult]);
			return $arResult;
			
			}
			/*
			* Возвращает модифицированные данные о пользователе.
			* При получении данных из црм обновляет свойство UF_BX24_USER_ID
			*/
			
			public static function getUserDataByBx24Id($userId) {
			$cache = new CPHPCache();
			$cache_time = 36000;
			$cache_id = "USER";
			$cache_path = "getUserDataByBx24Id".$userId;
			if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)) {
			$res = $cache->GetVars();
			if (is_array($res["data"]) && (count($res["data"]) > 0))
			return $res["data"];
			}
			$oBitrix = new \Zloykolobok\Bitrix24\Classes\User();
			$oBitrix->setUrl(BX_WEBHOOK_URL);
			$oBitrix->setTimeout(1000);
			$res = $oBitrix->userGet(['ID' => $userId]);
			$user = $res->result[0];
			//l($user);
			$rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), ['EMAIL' => $user->EMAIL]);
			$arUser = [];
			if ($arUser = $rsUsers->Fetch()) {
			//l($arUser);
			$user2 = new CUser;
			$fields = Array(
			"UF_BX24_USER_ID" => $user->ID,
			);
			$user2->Update($arUser["ID"], $fields);
			}
			$arReturn = [
			"ID" => $arUser['ID'],
			"BX24_USER_ID" => $user->ID,
			"EMAIL" => $user->EMAIL,
			"NAME" => $user->NAME,
			"LAST_NAME" => $user->LAST_NAME,
			];
			//l($arReturn);
			$cache->StartDataCache($cache_time, $cache_id, $cache_path);
			$cache->EndDataCache(["data" => $arReturn]);
			return $arReturn;
			}
			
			public static function getUserBx24Id($userId = 0) {
			global $USER;
			if ($userId == 0) {
			$userId = $USER->GetID();
			}
			$dbUser = CUser::GetByID($userId);
			$arUser = $dbUser->Fetch();
			return $arUser['UF_BX24_USER_ID'];
			}
			
			public static function getRegionByBx24Id($bx24Id){
			$allRegions = self::getRegions();
			$arResult = false;
			foreach( $allRegions as $id => $arr){
			if($arr['CODE'] == $bx24Id){
			$arResult = $arr;
			break;
			}
			
			}
			return $arResult;
			}
			public static function getRegions() {
			$cache = new CPHPCache();
			$cache_time = 36000;
			$cache_id = "IBLOCK_ID_4x";
			$cache_path = "getOrgIndustry";
			if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)) {
			$res = $cache->GetVars();
			if (is_array($res["data"]) && (count($res["data"]) > 0))
			return $res["data"];
			}
			CModule::IncludeModule('iblock');
			$filter = ['IBLOCK_ID' => 4];
			$rsItems = CIBlockElement::GetList(['SORT' => 'ASC','NAME'=>'ASC'], $filter, false, false, ["IBLOCK_ID", 'ID', "NAME", "CODE"]);
			while ($arItem = $rsItems->GetNext()) {
			$arReturn[$arItem['ID']] = $arItem;
			}
			$cache->StartDataCache($cache_time, $cache_id, $cache_path);
			$cache->EndDataCache(["data" => $arReturn]);
			return $arReturn;
			}
			
			public static function getOrgIndustry($asArray = false) {
			$cache = new CPHPCache();
			$cache_time = 36000;
			$cache_id = "IBLOCK_ID_3" . ($asArray ? 'array' : '');
			$cache_path = "getOrgIndustry_" . ($asArray ? 'array' : '');
			if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)) {
			$res = $cache->GetVars();
			if (is_array($res["data"]) && (count($res["data"]) > 0))
			return $res["data"];
			}
			CModule::IncludeModule('iblock');
			$filter = ['IBLOCK_ID' => 3];
			$rsItems = CIBlockElement::GetList(['NAME' => 'ASC'], $filter, false, false, ["IBLOCK_ID", 'ID', "NAME", "CODE"]);
			while ($arItem = $rsItems->GetNext()) {
			if ($asArray) {
			$arReturn[$arItem['ID']] = $arItem;
			} else {
			$arReturn[$arItem['ID']] = $arItem['NAME'];
			}
			}
			$cache->StartDataCache($cache_time, $cache_id, $cache_path);
			$cache->EndDataCache(["data" => $arReturn]);
			return $arReturn;
			}
			
			public static function getIndustrialSectors($asArray = false) {
			$cache = new CPHPCache();
			$cache_time = 36000;
			$cache_id = "IBLOCK_CODE_industrial_sectors" . ($asArray ? 'array' : '');
			$cache_path = "getIndustrialSectors_" . ($asArray ? 'array' : '');
			if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)) {
			$res = $cache->GetVars();
			if (is_array($res["data"]) && (count($res["data"]) > 0))
			return $res["data"];
			}
			CModule::IncludeModule('iblock');
			$iblock = CIBlock::GetList([], ['CODE' => 'industrial_sectors', 'ACTIVE' => 'Y'])->Fetch();
			if (!$iblock) {
			return [];
			}
			$filter = ['IBLOCK_ID' => $iblock['ID'], 'ACTIVE' => 'Y'];
			$rsItems = CIBlockElement::GetList(['SORT' => 'ASC', 'NAME' => 'ASC'], $filter, false, false, ["IBLOCK_ID", 'ID', "NAME", "CODE"]);
			while ($arItem = $rsItems->GetNext()) {
			if ($asArray) {
			$arReturn[$arItem['ID']] = $arItem;
			} else {
			$arReturn[$arItem['ID']] = $arItem['NAME'];
			}
			}
			$cache->StartDataCache($cache_time, $cache_id, $cache_path);
			$cache->EndDataCache(["data" => $arReturn]);
			return $arReturn;
			}
			
			public static function getManagers() {
			$result = \Bitrix\Main\UserGroupTable::getList(array(
			'filter' => array('GROUP_ID' => [1, MANAGERS_GROUP_ID], 'USER.ACTIVE' => 'Y'),
			'select' => array('USER_ID', 'SECOND_NAME' => 'USER.SECOND_NAME', 'WORK_DEPARTMENT' => 'USER.WORK_DEPARTMENT', 'EMAIL' => 'USER.EMAIL','NAME' => 'USER.NAME', 'LAST_NAME' => 'USER.LAST_NAME', 'USER.UF_BX24_USER_ID'), // выбираем идентификатор п-ля, имя и фамилию
			'order' => array('USER.LAST_NAME' => 'ASC'), // сортируем по идентификатору пользователя
			));
			$ar = [];
			$arEx  = [];
			while ($arGroup = $result->fetch()) {
			//	l($arGroup); 
			$perfix = '';
			if(in_array( $arGroup['MAIN_USER_GROUP_USER_UF_BX24_USER_ID'], $arEx)){
			// $perfix = '__';
			}
			if(  $arGroup['MAIN_USER_GROUP_USER_UF_BX24_USER_ID'] ==''){ // fixed 12/02/24  - убрали привязку  BX24_USER_ID
			//$perfix = '__';
			//continue;
			}
			if(strpos($arGroup['EMAIL'], "DEL_")!==false)continue;
			if($arGroup['WORK_DEPARTMENT']=="")continue;
			$arEx[] =  $arGroup['MAIN_USER_GROUP_USER_UF_BX24_USER_ID'];
			$arGroup['FIO'] = $perfix.$arGroup['LAST_NAME'] . ' ' . $arGroup['NAME'];
			if($arGroup['LAST_NAME'] == "" &&  $arGroup['NAME']==''){
			$arGroup['FIO'] = $arGroup['EMAIL'];
			}
			//$ar[$arGroup['USER_ID']] = $arGroup;
			$ar[$arGroup['USER_ID']] = [
			"USER_ID"=>$arGroup['USER_ID'],
			"FIO"=>$arGroup['FIO'],
			"UF_BX24_USER_ID"=>$arGroup['UF_BX24_USER_ID'],
			"NAME"=>$arGroup['NAME'],
			"LAST_NAME"=>$arGroup['LAST_NAME'],
			"EMAIL"=>$arGroup['EMAIL'],
			"WORK_DEPARTMENT"=>$arGroup['WORK_DEPARTMENT'],
			];
			
			}
			return $ar;
			}
			
			public static function getUserPhoto($user_id) {
			$cache = new CPHPCache();
			$cache_time = 36000;
			$cache_id = "getUserPhoto" . $user_id;
			$cache_path = "getUserPhoto";
			if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)) {
			$res = $cache->GetVars();
			if (is_array($res["data"]) && (count($res["data"]) > 0))
			return $res["data"];
			}
			$dbUser = CUser::GetByID($user_id);
			$arUser = $dbUser->Fetch();
			$filePath = false;
			if ($arUser['PERSONAL_PHOTO'] > 0) {
			$arFIle = CFile::GetFileArray($arUser['PERSONAL_PHOTO']);
			$filePath = $arFIle['SRC'];
			}
			$cache->StartDataCache($cache_time, $cache_id, $cache_path);
			$cache->EndDataCache(["data" => $filePath]);
			return $filePath;
			}
			
			public static function getListValue($IBLOCK_ID, $COLORS) {
			$cache = new CPHPCache();
			$cache_time = 36000;
			$cache_id = "getListValue" . $IBLOCK_ID . $COLORS;
			$cache_path = "getListValue";
			if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)) {
			$res = $cache->GetVars();
			if (is_array($res["data"]) && (count($res["data"]) > 0))
			return $res["data"];
			}
			CModule::IncludeModule('iblock');
			$property_enums = CIBlockPropertyEnum::GetList(Array("DEF" => "DESC", "SORT" => "ASC"), Array("IBLOCK_ID" => $IBLOCK_ID, "CODE" => $COLORS));
			while ($enum_fields = $property_enums->GetNext()) {
			$arReturn[$enum_fields['ID']] = $enum_fields;
			}
			$cache->StartDataCache($cache_time, $cache_id, $cache_path);
			$cache->EndDataCache(["data" => $arReturn]);
			return $arReturn;
			}
			
			function normalizeBx24tags($text){
			//[P]
			$text = str_replace("[P]",'<p>',$text);
			$text = str_replace("[/P]",'</p>',$text);
			//preg_match_all('/<[URL=.+](.+)[\/URL]>/', $text, $html_links);
			
			return $text;
			
			}
			
			}
						
