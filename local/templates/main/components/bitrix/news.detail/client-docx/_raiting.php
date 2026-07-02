<?
$obj = new Raiting($arResult['ID']);
$middleRaiting = $obj->getClientMiddleRaiting();
$serviceCount = Client::getServiceCount($arResult['ID']);
$consultCount = Client::getConsultCount($arResult['ID']);
$clientMOneyCount = Client::getMoneyCount($arResult['ID']);
?>
<div class="client-raiting-wrap">
    <div class="text">Рейтинг доверия</div>
    <div class="big-number"><?= $middleRaiting ?></div>


    Консультаций оказано: <?= $consultCount ?><br>
    Услуг оказано: <?= $serviceCount ?><br>
    <? if ($clientMOneyCount > 0): ?>
	    <span style="color:#222">Денег получено: <?=number_format($clientMOneyCount, 0,'', ' ' ) ?> руб.<br></span>
	<? endif ?>
</div>

