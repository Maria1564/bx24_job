<?
	
	
	$arParams["FILTER_NAME"] = "filter";
	$arManagers = Helper::getManagersExt();
	$arDirections = Helper::getDirections();
	//
	require 'filter/init_params.php';
	//подключаем обработку фильтров
	require 'filter/date.php';
    require 'filter/props.php';
	require 'filter/status.php';
	
	
	//Вычисляем нужные данные
	require 'include/service.php';	
	//require 'include/clients.php';
	require 'include/uniq.php';
	
	//Результат:
	$arResult['TOTAL_MONEY'] = $arResult['MONEY']+$arResult['MONEY2']+$arResult['MONEY3'];
	$arResult['TOTAL_MONEY_FORAMTTED'] = number_format($arResult['TOTAL_MONEY'], 0, ',', ' ');
	$arResult['MONEY_FORMATTED'] = number_format($arResult['MONEY'], 0, ',', ' ');
	$arResult['MONEY2_FORMATTED'] = number_format($arResult['MONEY2'], 0, ',', ' ');
	$arResult['MONEY3_FORMATTED'] = number_format($arResult['MONEY3'], 0, ',', ' ');
	
	
