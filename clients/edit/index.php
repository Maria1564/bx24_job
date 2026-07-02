<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("TITLE", "Редактирование клиента");
$APPLICATION->SetPageProperty("keywords", "Редактирование клиента");
$APPLICATION->SetPageProperty("description", "Редактирование клиента");
$APPLICATION->SetTitle("Редактирование клиента");
?>

<?
$APPLICATION->IncludeComponent(
	"arbko:form.client", "client", Array()
);
?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>