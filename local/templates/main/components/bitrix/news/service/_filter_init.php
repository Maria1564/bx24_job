<?
	
	$isConsultPage = false;
	if ($arParams['SEF_FOLDER'] == '/consult/')
	{
		$isConsultPage = true;
	}
	
	
	
	include 'filter/filters-1.php';
	
	include 'filter/msp_type.php';
	
	foreach ($_REQUEST['PROP'] as $code => $value)
	{
		if (in_array($code, ["DIRECTION", "MANAGER", "FINANCE_SOURCE"])) continue;
		if ($value == "") continue;
		$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_' . $code] = $value;
	}
	if($isConsultPage){
	   //проблема в том что у консультаций поле DIRECTION не заполняется,
	   // и фильтровамть по нему не получится! 
	   //поэтому сбрасываем фильтр и фильтруем через привязанных менеджеров
		unset($GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_DIRECTION']);
		include 'filter/direction-consult.php';
	}
	
	//STATUS
	include 'filter/status.php';
	
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
		$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_CLIENT'] = $arClientsByOrgType ?: false;
	}
	if ($_GET['log'] == 1)
	{
		l($GLOBALS[$arParams["FILTER_NAME"]]);
	}
	
	$arManagers = Helper::getManagersExt();
	$arDirections = Helper::getDirections();
	
