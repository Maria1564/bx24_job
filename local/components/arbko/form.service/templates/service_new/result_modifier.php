<?
	//
	$arResult['DIRECTION_SERVICES'] = getServices();

	//l($arResult['DIRECTION_SERVICES']);
	
	
	function getServices(){
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
		$arServices =  getIBlockItems(6,['ID' => $sdServiceIds],['IBLOCK_ID','ID','NAME','PROPERTY_IS_SHOW_INPUT']);
		$arResult = [];
		foreach($arServices as $arr){
			$arResult['SD'][] =  clearFileds($arr);
		}
		return $arResult; 
		
	}	
