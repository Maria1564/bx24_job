<?
	/*
		******************************************************************************************
	    ******************************************************************************************
		******************************************************************************************
		******************************************************************************************
		******************************************************************************************		
		При выбранных датах показывать только услуги, которые были закрыты в выбранный промежуток времени
	*/
	//DATE_CLOSE | DATE_ACTIVE_TO 
	if ($_REQUEST['DATE_CLOSE'] == "Y" )
	{
		unset($GLOBALS[$arParams["FILTER_NAME"]]['>=DATE_ACTIVE_FROM']);
		unset($GLOBALS[$arParams["FILTER_NAME"]]['<=DATE_ACTIVE_FROM']);
        
		$dateForm ="01.01.".date('Y')." 00:00:00";
		$dateTo = date('d.m.Y H:i:s');
		if ($_REQUEST['DATE_FROM'])
		{
			$s = strtotime($_REQUEST['DATE_FROM']);
			$dateForm = date('d.m.Y 00:00:01', $s);			
		}
		if ($_REQUEST['DATE_TO']){
			$s = strtotime($_REQUEST['DATE_TO']);
			$dateTo = date('d.m.Y 23:59:59', $s);
		}
		$GLOBALS[$arParams["FILTER_NAME"]]['>=DATE_ACTIVE_TO'] = $dateForm;
		$GLOBALS[$arParams["FILTER_NAME"]]['<=DATE_ACTIVE_TO'] = $dateTo;
		
		//И Выбираем только закрытые задачи
	 	$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_STATUS'] = Service::STATUS_CLOSED;	
	}
	
	
	if ($_REQUEST['DATE_OPEN'] == "Y")
	{
	    //Обнуляем фильтр по дате создания
		unset($GLOBALS[$arParams["FILTER_NAME"]]['>=DATE_ACTIVE_FROM']);
		unset($GLOBALS[$arParams["FILTER_NAME"]]['<=DATE_ACTIVE_FROM']);
        
		$dateForm ="01.01.".date('Y')." 00:00:00";
		$dateTo = date('d.m.Y H:i:s');
		if ($_REQUEST['DATE_FROM'])
		{
			$s = strtotime($_REQUEST['DATE_FROM']);
			$dateForm = date('d.m.Y 00:00:01', $s);
			
		}
		if ($_REQUEST['DATE_TO']){
			$s = strtotime($_REQUEST['DATE_TO']);
			$dateTo = date('d.m.Y 23:59:59', $s);
		}
		$GLOBALS[$arParams["FILTER_NAME"]]['>=DATE_ACTIVE_FRROM'] = $dateForm;
		$GLOBALS[$arParams["FILTER_NAME"]]['<=DATE_ACTIVE_FRROM'] = $dateTo;		
		//И Выбираем только закрытые задачи
	 	$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_STATUS'] = Service::STATUS_ACTIVE;			
	}//$_REQUEST['DATE_CLOSE']