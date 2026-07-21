<?
	if ($_REQUEST['DATE_FROM'])
	{
		$s = strtotime($_REQUEST['DATE_FROM']);
		//DATE_CREATE
		$GLOBALS[$arParams["FILTER_NAME"]]['>=DATE_ACTIVE_FROM'] = date('d.m.Y 00:00:01', $s);
		//$GLOBALS[$arParams["FILTER_NAME"]]['>=DATE_CREATE'] = date('d.m.Y 00:00:01', $s);
		
	}
	if ($_REQUEST['DATE_TO'])
	{
		$s = strtotime($_REQUEST['DATE_TO']);
		$GLOBALS[$arParams["FILTER_NAME"]]['<=DATE_ACTIVE_FROM'] = date('d.m.Y 23:59:59', $s);
		//$GLOBALS[$arParams["FILTER_NAME"]]['<=DATE_CREATE'] = date('d.m.Y 23:59:59', $s);
		
	}
