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
	
	
	/*
		******************************************************************************************
	    ******************************************************************************************
		******************************************************************************************
		******************************************************************************************
		******************************************************************************************
		SMS_VOTE_FROM
	*/
	if ($_REQUEST['SMS_VOTE_FROM'])
	{
		$s = (int)$_REQUEST['SMS_VOTE_FROM'];
		if ($s > 0 && $s <= 10)
		{
			$GLOBALS[$arParams["FILTER_NAME"]]['>=PROPERTY_SMS_VOTE'] = $s;
		}
	}
	if ($_REQUEST['SMS_VOTE_TO'])
	{
		$s = (int)$_REQUEST['SMS_VOTE_TO'];
		if ($s > 0 && $s <= 10)
		{
			$GLOBALS[$arParams["FILTER_NAME"]]['<=PROPERTY_SMS_VOTE'] = $s;
		}
	}
	
	//SMS_SEND
	/*
		Фильтр должен сожержать галочку "Отправлено СМС", таким образом будут выгружаться клиенты кому были отправлены смс 
		за определенный период времени, даже если на них не ответили. Сейчас можно посмотреть только отвеченные, указав диапазон оценок.
	*/
	if ($_REQUEST['SMS_SEND'] == "Y")
	{
		//SMS_SEND_DATE
		$GLOBALS[$arParams["FILTER_NAME"]]['>PROPERTY_SMS_SEND_DATE'] = 1;
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