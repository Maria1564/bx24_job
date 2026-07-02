<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
$this->setFrameMode(true);
?>
<div class="title-section">
<h1><?=$APPLICATION->GetTitle()?></h1>
</div>
<? include 'filter.php' ?>
<? include 'sort.php' ?>
<? include 'js/js.php' ?>
<div id="filter-content">
    <?
    if (isset($_REQUEST['ajax'])) {

	    $APPLICATION->RestartBuffer();
    }
    if ($_REQUEST['exel'] == "y") {
	    $arParams["CACHE_TIME"] = 0;
		}
//l($GLOBALS[$arParams["FILTER_NAME"]]);
    $APPLICATION->IncludeComponent(
	    "bitrix:news.list",$_REQUEST['exel'] == "y" ? "service_exel" : "service", Array(
	    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
	    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
	    "NEWS_COUNT" => $_REQUEST['exel'] == "y" ? 100 : $arParams["NEWS_COUNT"],
	    "SORT_BY1" => $_SESSION['sort']['name'],
	    "SORT_ORDER1" => $_SESSION['sort']['order'],
	    "SORT_BY2" => $_SESSION['sort']['name'],
	    "SORT_ORDER2" => $_SESSION['sort']['order'],
	    "FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
	    "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
	    "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"],
	    "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
	    "IBLOCK_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"],
	    "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
	    "SET_TITLE" => $arParams["SET_TITLE"],
	    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
	    "MESSAGE_404" => $arParams["MESSAGE_404"],
	    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
	    "SHOW_404" => $arParams["SHOW_404"],
	    "FILE_404" => $arParams["FILE_404"],
	    "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
	    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
	    "CACHE_TIME" => $arParams["CACHE_TIME"],
	    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
	    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
	    "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
	    "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
	    "PAGER_TITLE" => $arParams["PAGER_TITLE"],
	    "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
	    "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
	    "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
	    "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
	    "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
	    "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
	    "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
	    "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
	    "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
	    "DISPLAY_NAME" => "Y",
	    "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
	    "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
	    "PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
	    "ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
	    "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
	    "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
	    "FILTER_NAME" => $arParams["FILTER_NAME"],
	    "HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
	    "CHECK_DATES" => $arParams["CHECK_DATES"],
		"EXCEL" => $_REQUEST['exel'] == "y" ? "Y" : "N",
		'ALL_DATA_PAGE'=>$arParams['ALL_DATA_PAGE'],
	    ), false
    );
    if (isset($_REQUEST['ajax'])) {
	    exit;
    }
    ?>
</div>
