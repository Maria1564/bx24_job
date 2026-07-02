<?
	//Если дата не установлена то устанавливаем за текущий год
	if($_REQUEST['DATE_FROM']==""){
		$_REQUEST['DATE_FROM'] = date('Y').'-01-01';
	}
	if($_REQUEST['DATE_TO']==""){
		$_REQUEST['DATE_TO'] = date('Y-m-d');
	}
	
	$arResult['FILTER'] = [];
	//отдел
	$arResult['FILTER']['DIRECTION'] = 'Все';
	if($_REQUEST['PROP']['DIRECTION'] !=""){
		foreach($arDirections as $ar){
		if($_REQUEST['PROP']['DIRECTION'] == $ar['UF_XML_ID']){
		  $arResult['FILTER']['DIRECTION'] = $ar['UF_NAME'];
		  break;
		}
		}
		
	}
	
	//менеджер
	$arResult['FILTER']['MANAGER'] = 'Все';
	if($_REQUEST['PROP']['MANAGER'] >0){
	$arMan =  $arManagers[$_REQUEST['PROP']['MANAGER']];
		 $arResult['FILTER']['MANAGER'] =$arMan['LAST_NAME'].' '.$arMan['NAME'];
		
	}
	
	//Период
	$arResult['FILTER']['PERIOD_TEXT'] = "";
	if($_REQUEST['DATE_TO']){
	    $s = strtotime($_REQUEST['DATE_TO']);
		$DATE_TO = date('d.m.Y', $s);
	}
	
	$DATE_FROM =  false;
	if($_REQUEST['DATE_FROM']){
	    $s = strtotime($_REQUEST['DATE_FROM']);
		$DATE_FROM = date('d.m.Y', $s);
	}
	$arResult['FILTER']['PERIOD_TEXT'] = $DATE_FROM.' - '.$DATE_TO;
	
	//Статус
	$arResult['FILTER']['STATUS'] = 'Все';
	if($_REQUEST['STATUS']=='work'){
	$arResult['FILTER']['STATUS'] = 'В работе';
	}
	if($_REQUEST['STATUS']=='success'){
	$arResult['FILTER']['STATUS'] = 'Успешно завершена';
	}
	if($_REQUEST['STATUS']=='failed'){
	$arResult['FILTER']['STATUS'] = 'Не успешно завершена';
	}
	if($_REQUEST['STATUS']=='done-no-done'){
	$arResult['FILTER']['STATUS'] = 'Не реализованные  и  реализованные';
	}
	