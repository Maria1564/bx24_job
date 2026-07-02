<?
	//define("NEED_AUTH", true);
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
	
	if ($USER->IsAuthorized()) {
		$dbUser = CUser::GetByID($USER->GetID());
		$arUser = $dbUser->Fetch();
		$EMAIL = $arUser['EMAIL'];
		$oBitrix = new \Zloykolobok\Bitrix24\Classes\User();
		$oBitrix->setUrl(BX_WEBHOOK_URL);
		$oBitrix->setTimeout(1000);
		$filter = ["EMAIL" => $EMAIL];
		
		/*
		 Ищем этого пользователя среди сотрудников в црм.
		*/
		$result = $oBitrix->userGet($filter);
		//если находим то присваимваем ему группу МЕНЕДЖЕРЫ с ID = 5
		if ($result) {
		    $arGroups = CUser::GetUserGroup($USER->GetID());
			
			$arGroups = array_merge($arGroups,[5]);
			$userId = $result->result[0]->ID;
			if( $USER->GetID()!=1 ) {
			       CUser::SetUserGroup($USER->GetID(), $arGroups);
			}
			log2file("auth_userGet",[$result, $arGroups]);
			//Добавляем данные из Битрикс24 в Систему
			$user = new CUser;
			$fields = [
			    "WORK_PROFILE"=>json_encode($result->result[0]),
				"UF_BX24_USER_ID" => $userId,
			//	'WORK_DEPARTMENT'=>$result->result[0]->UF_DEPARTMENT[0],// ID отдела
			];
			$user->Update($USER->GetID(), $fields);
		}
		else {
			// fixed 22/10/24
		  //$USER->Logout();
		
		}
		/*
		if (strlen($arUser['BX_USER_ID']) > 5) {
			if ($USER->GetID() != 1) {
				CUser::SetUserGroup($USER->GetID(), [5]);
			}
		}
		*/
		LocalRedirect("/?auth=y");
	}
	/*
		$APPLICATION->SetTitle("Авторизация");
		
		$dbUser = CUser::GetByID($USER->GetID());
		$arUser = $dbUser->Fetch();
		l($arUser);
		$EMAIL = $arUser['EMAIL'];
		$oBitrix = new \Zloykolobok\Bitrix24\Classes\User();
		$oBitrix->setUrl(BX_WEBHOOK_URL);
		$oBitrix->setTimeout(1000);
		
		
		$result = $oBitrix->userGet(["EMAIL" => $EMAIL]);
		//l($result);
		if ($result) {
		$userId = $result->result[0]->ID;
		CUser::SetUserGroup($USER->GetID(), [5]);
		//UF_BX24_USER_ID
		$user = new CUser;
		$fields = Array(
		"UF_BX24_USER_ID" => $userId,
		);
		$user->Update($USER->GetID(), $fields);
		}
		LocalRedirect("/");
		* 
	*/
	?><div class="auth-page" style="display:none">
    <table>
		<tbody>
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
					<div style="text-align: center;">
						<h1>Авторизоваться через CRM Калужской области</h1>
						<a onclick="$('#bx_socserv_icon_Bitrix24Net').click()" class="btn btn-success" style="text-decoration: none" >Авторизоваться</a>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
    <? //l($_SERVER)  ?>
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
	.auth-page {
    max-width: 600px;
    margin: 100px auto;
    padding: 30px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background: #f5f5f5;
    box-shadow: 2px 1px 4px #ccc;
}
.bx-authform noindex {display:none}
</style>
<div class="auth-page">
<div style="xdisplay: none">
    <?
		$APPLICATION->IncludeComponent(
	    "bitrix:main.auth.form", "", Array(
	    "AUTH_FORGOT_PASSWORD_URL" => "/auth/",
	    "AUTH_REGISTER_URL" => "/auth/",
	    "AUTH_SUCCESS_URL" => "/auth/"
	    )
		);
	?>
</div>
</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>