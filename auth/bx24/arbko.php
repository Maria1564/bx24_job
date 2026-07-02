<?
/*
 * Этот файл размещаем в crm bitrix24
 */
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle("");

if($USER->isAuthorized()){
	echo $USER->GetID();
	if(isset($_GET['back'])){
             header('location:'.$_GET['back'].'?user_id='.$USER->GetID());
exit;
	}
	header('location:http://admin-arbko/auth/bx24/?user_id='.$USER->GetID());
}
?>
<br>
<br><br>
<br>
<?$APPLICATION->IncludeComponent(
	"bitrix:system.auth.form",
	"",
Array()
);?>

<?require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
?>