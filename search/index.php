<?

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Поиск");
$APPLICATION->IncludeComponent(
	"bitrix:search.page", "ajax-search", array(
	"AJAX_MODE" => "Y",
	"AJAX_OPTION_ADDITIONAL" => "",
	"AJAX_OPTION_HISTORY" => "N",
	"AJAX_OPTION_JUMP" => "Y",
	"AJAX_OPTION_STYLE" => "Y",
	"CACHE_TIME" => "0",
	"CACHE_TYPE" => "A",
	"CHECK_DATES" => "Y",
	"DEFAULT_SORT" => "rank",
	"DISPLAY_BOTTOM_PAGER" => "Y",
	"DISPLAY_TOP_PAGER" => "Y",
	"FILTER_NAME" => "",
	"NO_WORD_LOGIC" => "Y",
	"PAGER_SHOW_ALWAYS" => "Y",
	"PAGER_TEMPLATE" => "",
	"PAGER_TITLE" => "Результаты поиска",
	"PAGE_RESULT_COUNT" => "50",
	"RESTART" => "Y",
	"SHOW_WHEN" => "N",
	"SHOW_WHERE" => "N",
	"USE_LANGUAGE_GUESS" => "Y",
	"USE_SUGGEST" => "Y",
	"USE_TITLE_RANK" => "Y",
	"arrFILTER" => array(
		0 => "iblock_info",
		1 => "iblock_clients",
		2 => "iblock_service",
	),
	"arrFILTER_iblock_clients" => array(
		0 => "1",
	),
	"arrFILTER_iblock_info" => array(
		0 => "all",
	),
	"arrFILTER_iblock_service" => array(
		0 => "2",
	),
	"arrWHERE" => "",
	"COMPONENT_TEMPLATE" => ".default"
	), false);
?>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>