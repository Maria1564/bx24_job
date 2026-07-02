<?
	if ($_REQUEST['STATUS'])
	{
		$status = $_REQUEST['STATUS'];
		if ($status == 'success')
		{
			$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_BX24_STATUS_EXT'] = 1;
			
		}
		if ($status == 'failed')
		{
			$GLOBALS[$arParams["FILTER_NAME"]]['!PROPERTY_BX24_STATUS_EXT'] = 1;
			$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_STATUS'] = Service::STATUS_CLOSED;
		}
		if ($status == 'work')
		{
			$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_BX24_STATUS_EXT'] = false;
			$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_STATUS'] = Service::STATUS_ACTIVE;
		}
		if ($status == 'done-no-done')
		{
			//Удалось реализовать?
			$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_BX24_STATUS_EXT'] = true;
			//Статус (в работе - 1 , завершен - 2)
			$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_STATUS'] = 2;
		}
	}