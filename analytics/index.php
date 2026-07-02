<?

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Аналитика");
$APPLICATION->SetPageProperty("TITLE", "Аналитика");
?>

<?
$APPLICATION->IncludeComponent(
	"arbko:analytics", "analytics", Array()
);
?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>