	<div id="sms-vote-block" >
    <?
	//l($arResult);
$APPLICATION->IncludeComponent(
	"arbko:smsvote", "", Array( "ID" =>$arResult['ID'])
);
?>
	</div>