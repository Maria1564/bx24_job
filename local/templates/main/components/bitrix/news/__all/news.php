<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
//ALL page
$this->setFrameMode(true);
$arParams["NEWS_COUNT"] = 5;
require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/class/PHPExcel.php');
$xls = new PHPExcel();
$xls->setActiveSheetIndex(0);
$sheet = $xls->getActiveSheet();
$GLOBALS['$sheet'] = $sheet;

?>
<? include 'filter.php' ?>
<? include 'sort.php' ?>
<style>
.date-row {display: flex;}
.date-row div {    display: flex;}
.date-row div  span{    margin: 6px;color:#ccc;}
.items-count-cont {margin-top: 0;}
.section {margin-top: 25px;
    border-top: 1px solid #ccc;}
.section h2 {margin:10px;}
.row-flex {    display: flex;}
.col-flex {margin-right:30px;}
</style>
<div id="filter-content">
    <?
    if (isset($_REQUEST['ajax'])) {

	    $APPLICATION->RestartBuffer();
    }
    if ($_REQUEST['exel'] == "y") {
	    $arParams["CACHE_TIME"] = 0;
    }
	
	?>

	<div class="section">
	<h2>Клиенты</h2>
	<?
    $APPLICATION->IncludeComponent(
	    "bitrix:news.list", $_REQUEST['exel'] == "y" ? "clients_exel" : "clients_all", Array(
	    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
	    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
	    "NEWS_COUNT" => $_REQUEST['exel'] == "y" ? 1000 : $arParams["NEWS_COUNT"],
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
	    ), $component
    );
	
	
	?>
	
	 </div>
	<div class="section">
	<h2>Услуги</h2>
	<?
	$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_TYPE'] = Service::TYPE_SERVICE_ID;
	
	$APPLICATION->IncludeComponent(
	    "bitrix:news.list",$_REQUEST['exel'] == "y" ? "service_exel" : "service_all", Array(
	   "IBLOCK_TYPE" => "service",
	    "IBLOCK_ID" => 2,
	    "NEWS_COUNT" => $_REQUEST['exel'] == "y" ? 1000 : $arParams["NEWS_COUNT"],
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
	    ), $component
    );
	
	?>
	
	 </div>
	<div class="section">
	<h2>Консультации</h2>
	<?
	$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_TYPE'] = Service::TYPE_CONSALT_ID;
	$APPLICATION->IncludeComponent(
	    "bitrix:news.list",$_REQUEST['exel'] == "y" ? "consult_exel" : "consult_all", Array(
	   "IBLOCK_TYPE" => "service",
	    "IBLOCK_ID" => 2,
	    "NEWS_COUNT" => $_REQUEST['exel'] == "y" ? 1000 : $arParams["NEWS_COUNT"],
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
	    ), $component
    );
	?>
	
	 </div>
	
	
	<?
	if($_REQUEST['exel']=='y'){
	   include 'excel.php';
	}
	?>
	<?
    // l($GLOBALS[$arParams["FILTER_NAME"]]);
    if (isset($_REQUEST['ajax'])) {
	    exit;
    }
    ?>
</div>
<?
	function getLastActiveDataS($id) {
	//
	//l($id);
	$res = CIBlockElement::GetList(
			['DATE_ACTIVE_FROM' => 'DESC'], ['IBLOCK_ID' => IBLOCK_ID_SERVICE, 'PROPERTY_CLIENT' => $id], false, ['nPageSize' => 1], array('IBLOCK_ID', 'ID'));
	if ($el = $res->Fetch()) {
		return $el['ACTIVE_FROM'];
	}
	return '';
}
