<?
	if($orgType_VALUE_ENUM_ID == Client::ORG_TYPE_FIZ_ID){
	   $arResult['PROPERTIES']['CONTACT_NAME']['~VALUE'] = $arResult['~NAME'];
	}
	
?>
<h1 class="unit-catalog-card__desc-name"><?= $arResult['~NAME'] ?></h1>

<?if($arResult["PROPERTIES"]['SX']['VALUE']=="Y"):?>
	<p style="color:#8BC34A;margin-top:10px;">Сельское хозяйство</p>
<?endif?>

<? //include 'raiting.php'  ?>
<div class="unit-catalog-card__desc-intro">
    <?= $arResult['~PREVIEW_TEXT'] ?>
</div>


<div>
    <table  style="width: auto">
	<tr>
	    <td>Имя </td><td><?= $arResult['PROPERTIES']['CONTACT_NAME']['~VALUE'] ?></td>
	</tr>
	<tr>
	    <td>Телефон</td><td><?= $arResult['PROPERTIES']['PHONE']['VALUE'] ?></td>
	</tr>
	<tr>
	    <td>Email</td><td><?= $arResult['PROPERTIES']['EMAIL']['VALUE'] ?></td>
	</tr>
	<?if($arResult['PROPERTIES']['CONTACT_POST']['VALUE']):?>
	<tr>
	    <td>Должность</td><td><?= $arResult['PROPERTIES']['CONTACT_POST']['VALUE'] ?></td>
	</tr>
	<?endif?>
	<tr>
	    <td>Адрес</td><td><?= $arResult['PROPERTIES']['ADDRESS']['VALUE'] ?></td>
	</tr>
	<?if($arResult['PROPERTIES']['RAION_NEW']['VALUE']):?>
	<tr>
	    <td>Район</td><td><?= $arResult['PROPERTIES']['RAION_NEW']['VALUE'] ?></td>
	</tr>
	<?endif?>
    </table>
	
<?if($arResult["PROPERTIES"]['BLUE_CLIENT']['VALUE']=="Y"):?>
	<p style="color:#42aaff;margin-top:10px;">Приоритетный клиент</p>
<?endif?>
<?if($arResult["PROPERTIES"]['BIG_BUSINESS']['VALUE']=="Y"):?>
	<p style="color:#42aaff;margin-top:10px;">Крупный бизнес</p>
<?endif?>
<?if($arResult["PROPERTIES"]['SVO']['VALUE']=="Y"):?>
	<p style="color:#42aaff;margin-top:10px;">Ветеран СВО/член семьи ветерана СВО</p>
<?endif?>
<?if($arResult["PROPERTIES"]['IMPANTIANT']['VALUE']=="Y"):?>
	<p style="color:#42aaff;margin-top:10px;">
		Импатриант 
		<?if(isset($arResult["PROPERTIES"]["PROFESSIONS"]["VALUE"]) && !empty($arResult["PROPERTIES"]["PROFESSIONS"]["VALUE"])):?>
		(<?=$arResult["PROPERTIES"]["PROFESSIONS"]["VALUE"]?>)
		<?endif?>
		
		<?if(isset($arResult["PROPERTIES"]["COUNTRIES"]["VALUE"]) && !empty($arResult["PROPERTIES"]["COUNTRIES"]["VALUE"])):?>
		(<?=$arResult["PROPERTIES"]["COUNTRIES"]["VALUE"]?>)
		<?endif?>
	</p>
<?endif?>



<?if($arResult["PROPERTIES"]['KREATIV']['VALUE']=="Y"):?>
	<p style="color:#42aaff;margin-top:10px;">Креативный предприниматель</p>
<?endif?>

<?if($arResult["PROPERTIES"]['OBSHEPIT']['VALUE']=="Y"):?>
	<p style="color:#42aaff;margin-top:10px;">Общепит</p>
<?endif?>

	<?
	$contactsArr = Contact::getClientContacts($arResult['ID']);
	$arIndustry = Helper::getOrgIndustry();
	$arIndustrialSectors = Helper::getIndustrialSectors();
	$arExportCountries = Helper::getExportCountries();
//	l($arIndustry);
//	l($arResult['PROPERTIES']['INDUSTRY']);
	?>

    <br/>
    <ul>
	<? if (strlen($arResult['PROPERTIES']['INN']['VALUE']) > 5): ?>
		<li>ИНН <?= $arResult['PROPERTIES']['INN']['VALUE'] ?></li>
	<? endif ?>
	<? if (strlen($arResult['PROPERTIES']['OGRN']['VALUE']) > 5): ?>
		<li>ОГРН <?= $arResult['PROPERTIES']['OGRN']['VALUE'] ?></li>
	<? endif ?>
	<? if (strlen($arResult['PROPERTIES']['OKVED']['VALUE']) !=""): ?>
		<li>ОКВЭД: <?= $arResult['PROPERTIES']['OKVED']['VALUE'] ?></li>
	<? endif ?>
	<? if (strlen($arResult['PROPERTIES']['TNVED']['VALUE']) !=""): ?>
		<li>Код ТН ВЭД: <?= $arResult['PROPERTIES']['TNVED']['VALUE'] ?></li>
	<? endif ?>
	
	<? if (strlen($arResult['PROPERTIES']['INDUSTRY']['VALUE']) !=""): ?>
		<li>Реальная деятельность: <?= $arIndustry[$arResult['PROPERTIES']['INDUSTRY']['VALUE']] ?></li>
	<? endif ?>
	<?
		$arSelectedIndustrialSectors = [];
		foreach ((array)$arResult['PROPERTIES']['INDUSTRIAL_SECTORS']['VALUE'] as $sectorId) {
			if ($arIndustrialSectors[$sectorId]) {
				$arSelectedIndustrialSectors[] = $arIndustrialSectors[$sectorId];
			}
		}
	?>
	<? if (count($arSelectedIndustrialSectors) > 0): ?>
		<li>Отрасли промышленности: <?= implode(', ', $arSelectedIndustrialSectors) ?></li>
	<? endif ?>
	<?
		$arSelectedExportCountries = [];
		foreach ((array)$arResult['PROPERTIES']['EXPORT_COUNTRIES']['VALUE'] as $countryId) {
			if ($arExportCountries[$countryId]) {
				$arSelectedExportCountries[] = $arExportCountries[$countryId];
			}
		}
	?>
	<? if (count($arSelectedExportCountries) > 0): ?>
		<li>Страны экспорта: <?= implode(', ', $arSelectedExportCountries) ?></li>
	<? endif ?>
	<? if (strlen($arResult['PROPERTIES']['MSP_TYPE']['VALUE']) !=""): ?>
		<li>Категория МСП: <?=$arResult['PROPERTIES']['MSP_TYPE']['VALUE_ENUM']?></li>
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

	<?if($contactsArr):?>
	<div class="client-contacts-table-wrap">
		<div class="client-contacts-table-title">Контактные лица</div>
		<table class="client-contacts-table">
			<thead>
				<tr>
					<th>Имя</th>
					<th>Телефон</th>
					<th>Почта</th>
					<th>Должность</th>
				</tr>
			</thead>
			<tbody>
				<?foreach($contactsArr as $contact):?>
				<tr>
					<td><?= $contact['NAME'] ?></td>
					<td><?= $contact['PHONE'] ?></td>
					<td><?= $contact['EMAIL'] ?></td>
					<td><?= $contact['POST'] ?></td>
				</tr>
				<?endforeach?>
			</tbody>
		</table>
	</div>
	<?endif?>

</div>
<? //l($arResult['PROPERTIES']['REVENUE']) ?>
