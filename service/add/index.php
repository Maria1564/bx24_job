<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Добавление");
?>

<?$APPLICATION->IncludeComponent(
	"arbko:form.service",
	"service_new",
Array()
);?>



<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>