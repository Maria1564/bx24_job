<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

$this->setFrameMode(true);
$arManagers = Helper::getManagers();
//l($arResult["ITEMS"]);
?>
<script>
	app.newlist = {
            pagen: "<?= $arResult['NAV_RESULT']->PAGEN ?>",
            sizen: "<?= $arResult['NAV_RESULT']->SIZEN ?>",
            count: "<?= $arResult['NAV_RESULT']->NavRecordCount ?>"
        };
        setListCount();
</script>
<div class="clients-list-items">
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
		<? $hasExpiredContractDeadline = Client::hasExpiredContractDeadline($arItem['ID']); ?>
	
	    <div class="row list-item <?= $hasExpiredContractDeadline ? 'client-deadline-expired' : '' ?>" >
		<div class="col-md-2">
		    <?
		    if ($arItem["PREVIEW_PICTURE"]["SRC"] == null)
			    $arItem["PREVIEW_PICTURE"]["SRC"] = NO_IMAGE;
		    ?>
		    <img data-t="2" src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" />
		</div>
		<div class="col-md-6">
		    <div> <?
		    if($arItem['SERVICE_COUNT']>0){
			if ($arItem['ACTIVE_WORKS_COUNT'] > 0)
				echo '<span class="cleint-active">В работе</span>';
			else
				echo '<span class="cleint-deactive">Завершен</span>';
		    }else {
			    echo '<span class="cleint-deactive">услуг не оказано</span>';
		    }
			?></div>
		    <h2><a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><? echo $arItem["~NAME"] ?></a></h2>
		    <div class="description"><? echo $arItem["PREVIEW_TEXT"] ?></div>
		    <? if ($hasExpiredContractDeadline): ?>
				<div class="client-contract-deadline-label">просрочен дедлайн по контракту</div>
		    <? endif ?>
		    <table class="table-info">
			<tr>
			    <td>
				<span>Обьем услуг</span>
				<span>Оказано услуг: <b><?= $arItem['SERVICE_COUNT'] ?></b></span><br/>
				<span>Оказано консультаций: <b><?= $arItem['CONSULT_COUNT'] ?></b></span>
			    </td>
			    <td>
				<span>Последний контакт</span>
				<span><?= $arItem['LAST_CONTACT_DATE'] ?></span>
			    </td>
			    <td>
				<span>Менеджер</span>
				<span><?= $arManagers[$arItem["PROPERTIES"]['MANAGER']['VALUE']]['FIO'] ?></span>
			    </td>
			</tr>
			<?if($arItem["PROPERTIES"]['BLUE_CLIENT']['VALUE']=="Y"):?>
			<tr>
				<td><b style="color:#42aaff">Приоритетный клиент</b></td>
			</tr>
			<?endif?>
			<?if($arItem["PROPERTIES"]['BIG_BUSINESS']['VALUE']=="Y"):?>
			<tr>
				<td><b style="color:#42aaff">Крупный бизнес</b></td>
			</tr>
			<?endif?>
			<?if($arItem["PROPERTIES"]['SVO']['VALUE']=="Y"):?>
			<tr>
				<td><b style="color:#42aaff">Ветеран СВО/член семьи ветерана СВО</b></td>
			</tr>
			<?endif?>
			<?if($arItem["PROPERTIES"]['SX']['VALUE']=="Y"):?>
			<tr>
				<td><b style="color:#8BC34A;">Сельское хозяйство</b></td>
			</tr>
			<?endif?>
			
			<?if($arItem["PROPERTIES"]['IMPANTIANT']['VALUE']=="Y"):?>
			<tr>
				<td>
					<b style="color:#42aaff">Импатриант 
					<?if(isset($arItem["PROPERTIES"]["PROFESSIONS"]["VALUE"]) && !empty($arItem["PROPERTIES"]["PROFESSIONS"]["VALUE"])):?>
						(<?=$arItem["PROPERTIES"]["PROFESSIONS"]["VALUE"]?>)
					<?endif?>
					<?if(isset($arItem["PROPERTIES"]["COUNTRIES"]["VALUE"]) && !empty($arItem["PROPERTIES"]["COUNTRIES"]["VALUE"])):?>
						(<?=$arItem["PROPERTIES"]["COUNTRIES"]["VALUE"]?>)
					<?endif?></b>
					
					</b>
					
					
				</td>
			</tr>
			<?endif?>
			
			<?if($arItem["PROPERTIES"]['KREATIV']['VALUE']=="Y"):?>
			<tr>
				<td><b style="color:#42aaff">Креативный предприниматель</b></td>
			</tr>
			<?endif?>
			
			<?if($arItem["PROPERTIES"]['OBSHEPIT']['VALUE']=="Y"):?>
			<tr>
				<td><b style="color:#42aaff">Общепит</b></td>
			</tr>
			<?endif?>

		    </table>
		</div>
		<div class="col-md-3">
		    <table class="table-info-2">
			<tr><td>Телефон</td><td><?= $arItem['PROPERTIES']['PHONE']['VALUE'] ?></td></tr>
			<tr><td>E-mail</td><td><?= $arItem['PROPERTIES']['EMAIL']['VALUE'] ?></td></tr>
			<tr><td>ИНН</td><td><?= $arItem['PROPERTIES']['INN']['VALUE'] ?></td></tr>
			<tr><td>ОГРН</td><td><?= $arItem['PROPERTIES']['OGRN']['VALUE'] ?></td></tr>
		    </table>
		</div>
		<div class="col-md-1">
		    <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"> <img src="/test-files/arrow.svg"> </a>
		</div>

	    </div>
    <? endforeach; ?>

    <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
	    <br /><?= $arResult["NAV_STRING"] ?>
    <? endif; ?>
</div>

<?

    
