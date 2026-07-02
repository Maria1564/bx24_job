<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Редактирование");
?>
<?
$APPLICATION->IncludeComponent(
	"arbko:form.consult", "consult", Array('ACTION' => 'EDIT')
);
?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>