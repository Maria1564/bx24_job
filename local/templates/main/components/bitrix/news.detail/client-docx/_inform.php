<h1 class="unit-catalog-card__desc-name"><?= $arResult['NAME'] ?></h1>

<? //include 'raiting.php'  ?>
<div class="unit-catalog-card__desc-intro">
    <?= $arResult['PREVIEW_TEXT'] ?>
</div>


<div>
    <table  style="width: auto">
	<tr>
	    <td>Имя </td><td><?= $arResult['PROPERTIES']['CONTACT_NAME']['VALUE'] ?></td>
	</tr>
	<tr>
	    <td>Телефон</td><td><?= $arResult['PROPERTIES']['PHONE']['VALUE'] ?></td>
	</tr>
	<tr>
	    <td>Email</td><td><?= $arResult['PROPERTIES']['EMAIL']['VALUE'] ?></td>
	</tr>
	<tr>
	    <td>Адрес</td><td><?= $arResult['PROPERTIES']['ADDRESS']['VALUE'] ?></td>
	</tr>
    </table>
    <br/>
    <ul>
	<? if (strlen($arResult['PROPERTIES']['INN']['VALUE']) > 5): ?>
		<li>ИНН <?= $arResult['PROPERTIES']['INN']['VALUE'] ?></li>
	<? endif ?>
	<? if (strlen($arResult['PROPERTIES']['OGRN']['VALUE']) > 5): ?>
		<li>ОГРН <?= $arResult['PROPERTIES']['OGRN']['VALUE'] ?></li>
	<? endif ?>
	<? if (strlen($arResult['PROPERTIES']['OKVED']['VALUE']) > 5): ?>
		<li>ОКВЕД <?= $arResult['PROPERTIES']['OKVED']['VALUE'] ?></li>
	<? endif ?>
	<? if (strlen($arResult['PROPERTIES']['MSP_TEXT']['VALUE']) > 5): ?>
		<li xstyle="display:none"><?= $arResult['PROPERTIES']['MSP_TEXT']['VALUE'] ?></li>
	<? endif ?>
	<?// l($arResult['PROPERTIES']['MSP_TEXT'])?>
	<?
	$revenue = [];
	if (count($arResult['PROPERTIES']['REVENUE']['VALUE']) > 0) {
		foreach ($arResult['PROPERTIES']['REVENUE']['~VALUE'] as $value) {
			$arr = json_decode($value, true);
			$revenue[$arr['year']] = number_format($arr['summa'], 0, ',', ' ');
		}
	}
	?> 
	<? foreach ($revenue as $year => $summa): ?>
		<li>Обьем выручки за <?= $year ?> год  <b><?= $summa ?> руб.</b></li>
	<? endforeach ?>

    </ul>

</div>
<? //l($arResult['PROPERTIES']['REVENUE']) ?>
