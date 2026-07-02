<? //
	
	
	if ($_REQUEST['PROP']["DIRECTION"] && $_REQUEST['PROP']['MANAGER'] == null) {
		//Выбираем всех менеджеров у которых отвед совпадает с выбранным Департаментов
		$filer = ["UF_DIRECTIONS" => "%".$_REQUEST['PROP']["DIRECTION"].'%'];
		//l($filer );
		$sql = CUser::GetList(($by = "id"), ($order = "desc"), $filer);
		$arUsersId = [];
		while ($arUser = $sql->Fetch()) {
			
			$arUsersId[] = $arUser['ID'];
		}
		// l($arUsersId);
		// l($_REQUEST);
		//$_REQUEST['PROP']['MANAGER'] = '';
		if (count($arUsersId) > 0) {
			
			$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MANAGER'] = $arUsersId;
			} else {
			
			$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MANAGER'] = -1;
		}
		if($isConsultPage){
		  $GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_DIRECTION'] = $_REQUEST['PROP']["DIRECTION"];
		}
	}	
	
	