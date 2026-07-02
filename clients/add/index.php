<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("TITLE", "Добавить нового клиента");
$APPLICATION->SetPageProperty("keywords", "Добавить нового клиента");
$APPLICATION->SetPageProperty("description", "Добавить нового клиента");
$APPLICATION->SetTitle("Добавить нового клиента");
?>

<?
$APPLICATION->IncludeComponent(
	"arbko:form.client", "client", Array()
);
?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>