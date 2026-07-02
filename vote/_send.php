<?
	//l($_REQUEST);
	$serviceId = $_REQUEST['serviceId'];
	$vote = $_REQUEST['vote'];
	$text = $_REQUEST['text'];
	$raiting = new Raiting();
	
	$arService = Service::getServiceById($serviceId);
	$clientID = $arService['PROPERTIES']['CLIENT']['VALUE'];
	$arClient = Client::getClientById($clientID);
//	l($arClient);
	$clientPhone = $arClient['PROPERTIES']['PHONE']['VALUE'];
    $arData = $raiting->setServiceRaiting($serviceId, $vote,false , ["UF_USER_VOTE"=>$vote,"UF_SMS_TEXT"=>$text,"UF_SMS_NUMBER"=>$clientPhone,"UF_FROM_USER"=>$arClient['ID'],'UF_SMS_VOTE_DATE'=>time()]);
//	l($arData);
?>
<div class="send-cont">
	<h1>Спасибо!<br> Ваш голос учтен!</h1>
</div>