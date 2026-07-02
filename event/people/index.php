<?

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("TITLE", "Участники мероприятий");
$APPLICATION->SetTitle("Участники мероприятий");


if ($_REQUEST['DATE_FROM'])
{
	$s = strtotime($_REQUEST['DATE_FROM']);
	//DATE_CREATE
	$GLOBALS['arFilter']['>=DATE_ACTIVE_FROM'] = date('d.m.Y 00:00:01', $s);
	//$GLOBALS[$arParams["FILTER_NAME"]]['>=DATE_CREATE'] = date('d.m.Y 00:00:01', $s);
	
}
if ($_REQUEST['DATE_TO'])
{
	$s = strtotime($_REQUEST['DATE_TO']);
	$GLOBALS['arFilter']['<=DATE_ACTIVE_FROM'] = date('d.m.Y 23:59:59', $s);
	//$GLOBALS[$arParams["FILTER_NAME"]]['<=DATE_CREATE'] = date('d.m.Y 23:59:59', $s);
	
}
if ($_REQUEST['PROP']["MSP_TYPE"] ) {
	$arSubQuery = Array('IBLOCK_ID' => IBLOCK_ID_CLIENT, 'PROPERTY_MSP_TYPE' =>$_REQUEST['PROP']["MSP_TYPE"]);
	$rsData = CIBlockElement::GetList(Array(),$arSubQuery, false,false,  array('ID', 'IBLOCK_ID', 'NAME','PROPERTY_CLIENT')   );
	while($arFields = $rsData->Fetch()) {
		$contacts = Contact::getClientContacts($idClient = $arFields["ID"]);
		foreach($contacts as $contact){
			$GLOBALS['arFilter']['PROPERTY_CONTACT'][] = $contact['ID'];
		}
	}
}
?>
<div class="row" style="margin-bottom:30px;">
    <form action="" method="get" id="filter-form">
		<input type="hidden" name="sort" id="form-sort" value="">
		
		<div class="col-md-4">
			<div class="form-group">
				<label>Дата мероприятия</label>
				<div class="period">
					<input class="form-control" type="date" name="DATE_FROM" value="<?= $_REQUEST['DATE_FROM'] ?>"> -
					<input class="form-control" type="date" name="DATE_TO"  value="<?= $_REQUEST['DATE_TO'] ?>">
				</div>
				
			</div>
		
		</div>
		<div class="col-md-4">
			<div class="form-group">
					<label>Категория МСП</label>
					<select class="form-control" name="PROP[MSP_TYPE]">
						<option value="">Все</option>
						<option value="18" <?= $_REQUEST['PROP']['MSP_TYPE'] == '18' ? 'selected' : '' ?>>микро</option>
						<option value="19" <?= $_REQUEST['PROP']['MSP_TYPE'] == '19' ? 'selected' : '' ?>>малое</option>
						<option value="20" <?= $_REQUEST['PROP']['MSP_TYPE'] == '20' ? 'selected' : '' ?>>среднее</option>
					</select>
			</div>
		</div>	
		
		<div class="col-md-3">
			
			<div style="margin-top: 25px;">
				
				<button type="button" onclick="filterGetData()" class="btn btn-success btn-sm" >Фильтровать</button>
				<br/><br/>
				<button type="button" onclick="window.location.href = '/event/people/'" class="btn btn-default btn-sm">Сбросить фильтр</button>
			</div>
			
			
		</div>
	</form>
</div>
<div id="filter-content">
    <?
    if (isset($_REQUEST['ajax'])) {

	    $APPLICATION->RestartBuffer();
    }
    if ($_REQUEST['exel'] == "y") {
	    $arParams["CACHE_TIME"] = 0;
    }
    $APPLICATION->IncludeComponent(
	    "bitrix:news.list",$_REQUEST['exel'] == "y" ? "event_people_exel" : "event_people", 
	Array(
	    "IBLOCK_TYPE" => "events",
	    "IBLOCK_ID" => 7,
	    "NEWS_COUNT" => "25",
	    "SORT_BY1" => "ACTIVE_FROM",
	    "SORT_ORDER1" => "DESC",
	    "FIELD_CODE" =>array(
			0 => "ID",
			1 => "CODE",
			2 => "XML_ID",
			3 => "NAME",
			4 => "TAGS",
			5 => "SORT",
			6 => "PREVIEW_TEXT",
			7 => "PREVIEW_PICTURE",
			8 => "DETAIL_TEXT",
			9 => "DETAIL_PICTURE",
			10 => "DATE_ACTIVE_FROM",
			11 => "ACTIVE_FROM",
			12 => "DATE_ACTIVE_TO",
			13 => "ACTIVE_TO",
			14 => "SHOW_COUNTER",
			15 => "SHOW_COUNTER_START",
			16 => "IBLOCK_TYPE_ID",
			17 => "IBLOCK_ID",
			18 => "IBLOCK_CODE",
			19 => "IBLOCK_NAME",
			20 => "IBLOCK_EXTERNAL_ID",
			21 => "DATE_CREATE",
			22 => "CREATED_BY",
			23 => "CREATED_USER_NAME",
			24 => "TIMESTAMP_X",
			25 => "MODIFIED_BY",
			26 => "USER_NAME",
			27 => "",
		),
	    "PROPERTY_CODE" => array(
			0 => "CONTACT",
			1 => "MANAGER",
			2 => "SERVICE",
			3 => "STATUS",
			4 => "TYPE",
			5 => "MONEY",
			6 => "BX24_STATUS_EXT",
			7 => "SMS_VOTE",
			
		),
	    "SET_TITLE" => "N",
	    "FILTER_NAME" => "arFilter",
	    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
	    "CHECK_DATES" => "N",
		"EXCEL" => $_REQUEST['exel'] == "y" ? "Y" : "N",
    ));
    if (isset($_REQUEST['ajax'])) {
	    exit;
    }
    ?>
</div>	
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>