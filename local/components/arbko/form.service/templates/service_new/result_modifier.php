<?
	//
	$arResult['DIRECTION_SERVICES'] = getServices();

	//l($arResult['DIRECTION_SERVICES']);
	
	
	function getServices(){
		$arServices =  getIBlockItems(6,[],['IBLOCK_ID','ID','NAME','PROPERTY_DIRECTION','PROPERTY_IS_SHOW_INPUT']);
		$arResult = [];
		foreach($arServices as $arr){
			$arResult[$arr['PROPERTY_DIRECTION_VALUE']][] =  clearFileds($arr);
		}
		return $arResult; 
		
	}	