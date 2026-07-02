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
      //  setListCount();
		$('.items-count-client').text(app.newlist.count);
</script>
<div class="clients-list-items">
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
	
	    <div class="row list-item" >
		<div class="col-md-2">
		    <?
		    if ($arItem["PREVIEW_PICTURE"]["SRC"] == null)
			    $arItem["PREVIEW_PICTURE"]["SRC"] = NO_IMAGE;
		    ?>
		    <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" />
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
		    <h2><a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><? echo $arItem["NAME"] ?></a></h2>
		    <div class="description"><? echo $arItem["PREVIEW_TEXT"] ?></div>
		    <table class="table-info">
			<tr>
			    <td>
				<span>Обьем услуг</span>
				<span>Оказано услуг: <b><?= $arItem['SERVICE_COUNT'] ?></b></span>
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

    