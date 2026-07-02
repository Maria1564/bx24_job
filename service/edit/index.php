<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("TITLE", "Редактирование");
$APPLICATION->SetPageProperty("keywords", "Редактирование");
$APPLICATION->SetPageProperty("description", "Редактирование");
$APPLICATION->SetTitle("Редактирование");
?>

<?
$APPLICATION->IncludeComponent(
	"arbko:form.service", "service_new", Array()
);
?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>