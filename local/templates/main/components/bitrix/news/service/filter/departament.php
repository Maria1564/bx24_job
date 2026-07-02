<?
		if ($_REQUEST['DEPARTMENT'] && $_REQUEST['PROP']['MANAGER'] == null)
	{
		//Выбираем всех менеджеров у которых отвед совпадает с выбранным Департаментов
		$sql = CUser::GetList(($by = "id") , ($order = "desc") , ["WORK_DEPARTMENT" => $_REQUEST['DEPARTMENT']]);
		$arUsersId = [];
		while ($arUser = $sql->Fetch())
		{
			
			$arUsersId[] = $arUser['ID'];
		}
		// l($arUsersId);
		// l($_REQUEST);
		$_REQUEST['PROP']['MANAGER'] = '';
		if (count($arUsersId) > 0)
		{
			
			$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MANAGER'] = $arUsersId;
		}
		else
		{
			
			$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MANAGER'] = - 1;
		}
		
	}