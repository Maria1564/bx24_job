<?
	
	$isConsultPage = false;
	if ($arParams['SEF_FOLDER'] == '/consult/')
	{
		$isConsultPage = true;
	}
	
	if ($_REQUEST['DATE_FROM'])
	{
		$s = strtotime($_REQUEST['DATE_FROM']);
		//DATE_CREATE
	//	$GLOBALS[$arParams["FILTER_NAME"]]['>=DATE_ACTIVE_TO'] = date('d.m.Y 00:00:01', $s);
		//$GLOBALS[$arParams["FILTER_NAME"]]['>=DATE_CREATE'] = date('d.m.Y 00:00:01', $s);
		
	}
	if ($_REQUEST['DATE_TO'])
	{
		$s = strtotime($_REQUEST['DATE_TO']);
		//$GLOBALS[$arParams["FILTER_NAME"]]['<=DATE_ACTIVE_TO'] = date('d.m.Y 23:59:59', $s);
		//$GLOBALS[$arParams["FILTER_NAME"]]['<=DATE_CREATE'] = date('d.m.Y 23:59:59', $s);
		
	}
	
	if($_REQUEST['DATE_TO']){	
	  $from = strtotime($_REQUEST['DATE_FROM']);
	  $to = strtotime($_REQUEST['DATE_TO']);
	  
	 $GLOBALS[$arParams["FILTER_NAME"]][] = [
	     "LOGIC" => "OR",
         array("PROPERTY_TYPE"=>Service::TYPE_CONSALT_ID, '>=DATE_ACTIVE_FROM'=> date('d.m.Y 00:00:01', $from), "<=DATE_ACTIVE_FROM" => date('d.m.Y 23:59:59', $to)),
         array("PROPERTY_TYPE"=>Service::TYPE_SERVICE_ID,'>=DATE_ACTIVE_TO'=> date('d.m.Y 00:00:01', $from), "<=DATE_ACTIVE_TO" => date('d.m.Y 23:59:59', $to)),
	 ];
	}
	
		//Обработка фильтра по количеству денег
	if ($_REQUEST['MONEY_FROM'])
	{
		$GLOBALS[$arParams["FILTER_NAME"]]['>=PROPERTY_MONEY'] = $_REQUEST['MONEY_FROM'];
	}
	if ($_REQUEST['MONEY_TO'])
	{
		$GLOBALS[$arParams["FILTER_NAME"]]['<=PROPERTY_MONEY'] = $_REQUEST['MONEY_TO'];
	}
		
	

	

	
	/*
		******************************************************************************************
	    ******************************************************************************************
		******************************************************************************************
		******************************************************************************************
		******************************************************************************************
	    Создаем фильтр из параметров типа ['PROP']['PARAM_NAME'] = VALUE
	*/
	foreach ($_REQUEST['PROP'] as $code => $value)
	{
		if ($value == "") continue;
		$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_' . $code] = $value;
	}
	
	if ($_GET['log'] == 1)
	{
		l($GLOBALS[$arParams["FILTER_NAME"]]);
	}
	//l($_REQUEST);
//	$arClients = Client::getClients();
	$arManagers = Helper::getManagersExt();
	$arDirections = Helper::getDirections();
	//$arDEPARTMENT = Helper::getListValue(Client::CLIENT_IBLOCK_ID, 'DEPARTMENT');
	
	
	
