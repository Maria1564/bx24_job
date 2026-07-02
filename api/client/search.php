<?php

//require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/api/json-header.php");
//ob_start();
global $arSearchResult;
 $APPLICATION->IncludeComponent("bitrix:search.page", "get-array", Array(
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DEFAULT_SORT" => "rank",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "Y",
		"FILTER_NAME" => "",
		"NO_WORD_LOGIC" => "N",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Результаты поиска",
		"PAGE_RESULT_COUNT" => "50",
		"RESTART" => "Y",
		"SHOW_WHEN" => "N",
		"SHOW_WHERE" => "N",
		"USE_LANGUAGE_GUESS" => "Y",
		"USE_SUGGEST" => "N",
		"USE_TITLE_RANK" => "Y",
		"arrFILTER" => array("iblock_clients"),
		"arrFILTER_iblock_catalog" => array(0=>"all",),
		"arrFILTER_iblock_clients" => array("1"),
		"arrWHERE" => ""
	), false
);
//l($_REQUEST);
 //l($arSearchResult);
 /*
  * Очищаем массив от ненужных полей
  */
 $arResult = [];
 foreach($arSearchResult as $item){
	$arResult[] = [
		"ID"=>$item['ITEM_ID'],
		"NAME"=>$item['TITLE']
	];
 }
//l($arResult);
//$resutl = ob_get_contents();
//ob_clean();
echo json_encode(['code' => REQUEST_CODE_SUCCESS,'result'=>$arResult]);
