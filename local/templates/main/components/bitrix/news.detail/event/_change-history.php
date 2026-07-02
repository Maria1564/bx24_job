<?
$ch = new ChangeHistory();
$chData = $ch->getLastModificationsForService($arResult['ID']);
//l($chData);
?>
<? if (count($chData) > 0): ?> 
<div class="service-change-histroy-wrap">
	<h3>История изменений</h3>
	<ul>
	    <? foreach ($chData as $val): ?>
		    <li><?=$val?></li>
	    <? endforeach ?>
	</ul>
</div>
<? endif ?>

