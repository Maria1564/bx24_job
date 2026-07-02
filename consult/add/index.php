<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Добавление");
?>
<?
$APPLICATION->IncludeComponent(
	"arbko:form.consult", "consult", Array('ACTION' => 'ADD')
);
?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>