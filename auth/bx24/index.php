<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Авторизоваться через CRM Калужской области");
?>
<?
$userId = $_REQUEST['user_id'];
if ($userId > 1) {
	$oBitrix = new \Zloykolobok\Bitrix24\Classes\User();
	$oBitrix->setUrl(BX_WEBHOOK_URL);
	$oBitrix->setTimeout(1);
	$res = $oBitrix->userGet(['ID' => $userId]);
	//l($res->result[0]);
	if ($res->result[0]) {
		$obj = $res->result[0];
		$email = $obj->EMAIL;
		global $USER;
		$arResult = $USER->Register($email, $obj->NAME, $obj->LAST_NAME, $email, $email, $email);
		if (isset($arResult["ID"])) {
			CUser::SetUserGroup($arResult["ID"], [5]);
			//UF_BX24_USER_ID
			$user = new CUser;
			$fields = Array(
				"UF_BX24_USER_ID" =>$userId,
			);
			$user->Update($arResult["ID"], $fields);
			$USER->Authorize($arResult["ID"],true);
		} else {
			$filter = Array("EMAIL" => $email);
			$sql = CUser::GetList(($by = "id"), ($order = "desc"), $filter);
			if ($sql->NavNext(true, "f_")) {
				$id_user = $f_ID;
				$USER->Authorize($id_user,true);
			}
		}
		header('location:/');
		exit;
	}
}
?>
<div class="auth-page">

    <table>
	<tr>
	    <td>
		<div class="unit-logo">
		    <a href="/">
			<svg class="icon" viewBox="0 0 402 197.7">
			<use xlink:href="#main-logo__foot"></use>
			</svg>
		    </a>
		</div>
	    </td>
	    <td>
	<center>


	    <h1>Авторизоваться через CRM Калужской области</h1> 
	    <a href="https://pm.admoblkaluga.ru/auth/arbko.php?back=http://<?= $_SERVER['HTTP_HOST'] ?>/auth/bx24/" class="btn btn-success" style="text-decoration: none">Авторизоваться</a>
	</center>
	</td>
	</tr>
    </table>

    <? //l($_SERVER) ?>
</div>

<style>
    header,footer {display:none}
    .auth-page {    max-width: 600px;
		    margin: 100px auto;
		    padding: 30px;
		    border: 1px solid;
		    border-radius: 5px;
		    background: #3a3a42;}
    .auth-page h1 {    font-size: 20px;
		       margin: 24px;color: #fff;}
    table td {background: transparent!important;border: none;}

</style>




<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>