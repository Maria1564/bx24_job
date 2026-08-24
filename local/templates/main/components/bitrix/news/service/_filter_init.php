<?
	
	$isConsultPage = false;
	if ($arParams['SEF_FOLDER'] == '/consult/')
	{
		$isConsultPage = true;
	}
	
	
	
	include 'filter/filters-1.php';
	
	include 'filter/msp_type.php';

	if (!function_exists('applyServiceClientIdsFilter')) {
		function applyServiceClientIdsFilter($filterName, $clientIds) {
			$clientIds = array_values(array_unique(array_filter(array_map('intval', (array)$clientIds))));
			if (empty($clientIds)) {
				$GLOBALS[$filterName]['ID'] = 0;
				return;
			}
			if (!empty($GLOBALS[$filterName]['PROPERTY_CLIENT']) && is_array($GLOBALS[$filterName]['PROPERTY_CLIENT'])) {
				$clientIds = array_values(array_intersect($GLOBALS[$filterName]['PROPERTY_CLIENT'], $clientIds));
				if (empty($clientIds)) {
					$GLOBALS[$filterName]['ID'] = 0;
					return;
				}
				$GLOBALS[$filterName]['PROPERTY_CLIENT'] = $clientIds;
				return;
			}
			if (!empty($GLOBALS[$filterName]['PROPERTY_CLIENT']) && is_numeric($GLOBALS[$filterName]['PROPERTY_CLIENT'])) {
				if (!in_array((int)$GLOBALS[$filterName]['PROPERTY_CLIENT'], $clientIds)) {
					$GLOBALS[$filterName]['ID'] = 0;
					return;
				}
				$GLOBALS[$filterName]['PROPERTY_CLIENT'] = (int)$GLOBALS[$filterName]['PROPERTY_CLIENT'];
				return;
			}
			$GLOBALS[$filterName]['PROPERTY_CLIENT'] = $clientIds;
		}
	}

	if (!empty($_REQUEST['PROP']['INDUSTRIAL_SECTORS'])) {
		$arClientsByIndustrialSector = [];
		$arFilter = [
			'IBLOCK_ID' => IBLOCK_ID_CLIENT,
			'ACTIVE' => 'Y',
			'PROPERTY_INDUSTRIAL_SECTORS' => $_REQUEST['PROP']['INDUSTRIAL_SECTORS'],
		];
		$res = CIBlockElement::GetList([], $arFilter, false, false, ['ID']);
		while ($ob = $res->GetNextElement()) {
			$fields = $ob->GetFields();
			$arClientsByIndustrialSector[] = $fields['ID'];
		}
		applyServiceClientIdsFilter($arParams["FILTER_NAME"], $arClientsByIndustrialSector);
	}

	foreach ($_REQUEST['PROP'] as $code => $value)
	{
		if ($isConsultPage && $code == "DIRECTION_SERVICE") continue;
		if (in_array($code, ["DIRECTION", "MANAGER", "FINANCE_SOURCE", "INDUSTRIAL_SECTORS", "CLIENT"])) continue;
		if ($value == "") continue;
		$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_' . $code] = $value;
	}
	if (!$isConsultPage && $_REQUEST['BUDGET_SOURCE'] == 'regional') {
		$GLOBALS[$arParams["FILTER_NAME"]]['>PROPERTY_REGIONAL_BUDGET'] = 0;
	}
	if (!$isConsultPage && $_REQUEST['BUDGET_SOURCE'] == 'federal') {
		$GLOBALS[$arParams["FILTER_NAME"]]['>PROPERTY_FEDERAL_BUDGET'] = 0;
	}
	if($isConsultPage){
	   //проблема в том что у консультаций поле DIRECTION не заполняется,
	   // и фильтровамть по нему не получится! 
	   //поэтому сбрасываем фильтр и фильтруем через привязанных менеджеров
		unset($GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_DIRECTION']);
		include 'filter/direction-consult.php';
	}
	
	//CLIENT_UNIQ
	include 'filter/uniq-user-v2.php';
	
	//CLIENT_UNIQ_2
	include 'filter/uniq_2-user.php';
	
	//CLIENT_UNIQ_3
	include 'filter/uniq_3-user.php';
	
	//DATE_CLOSE | DATE_ACTIVE_TO | DATE_OPEN
	include 'filter/date-close.php';
	
	if (!empty($_REQUEST['PROP']['ORG_TYPE']))
	{
		$arClientsByOrgType = [];
		$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
		$arFilter = Array("IBLOCK_ID"=>1, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_ORG_TYPE" => $_REQUEST["PROP"]["ORG_TYPE"]);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		while($ob = $res->GetNextElement())
		{
			$fields = $ob->GetFields();
			$arClientsByOrgType[] = $fields["ID"];
		}
		applyServiceClientIdsFilter($arParams["FILTER_NAME"], $arClientsByOrgType);
	}
	if ($_GET['log'] == 1)
	{
		l($GLOBALS[$arParams["FILTER_NAME"]]);
	}
	
	$arManagers = Helper::getManagersExt();
	$arIndustrialSectors = Helper::getIndustrialSectors();
	$arDirections = Helper::getDirections();
	$arDirectionServices = [];
	if (!$isConsultPage) {
		$sdServiceIds = [
			9022,
			10120,
			8227,
			32557,
			8229,
			8222,
			8224,
			8225,
			8226,
			8223,
			8230,
			8221,
			8220,
		];
		$arDirectionServiceItems = getIBlockItems(6, ['ID' => $sdServiceIds], ['IBLOCK_ID', 'ID', 'NAME']);
		foreach ($arDirectionServiceItems as $arDirectionServiceItem) {
			$arDirectionServices[] = clearFileds($arDirectionServiceItem);
		}
	}
	
