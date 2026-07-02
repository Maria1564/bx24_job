<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Добавление");
?>

<?$APPLICATION->IncludeComponent(
	"arbko:form.event",
	"event",
Array()
);?>



<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>