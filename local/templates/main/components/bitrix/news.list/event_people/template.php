<?
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
	use Bitrix\Main\Type\DateTime;
	$this->setFrameMode(true);
	$allManagers = Helper::getManagers();
	
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

<div class="col-md-12" style="margin-bottom:20px;">
	<button class="btn btn-success" onclick="window.location.href = '/event/add/'">Добавить мероприятие</button>
</div>

<div class="col-md-12">
	<div class="list-btns">
		<a onclick="ExelCreate(this)" class="loadingx">Скачать Excel <span></span></a>
	</div>
</div>

<div class="service-list-items">
	
	<?
	$count = 0;
	foreach ($arResult["ITEMS"] as $arItem):
		$contacts = Contact::getClientContactsId($idContact = $arItem["PROPERTIES"]["CONTACT"]["VALUE"]);
		foreach($contacts as $k=>$contact):
			if($GLOBALS['arFilter']['PROPERTY_CONTACT'] && !in_array($contact["ID"], $GLOBALS['arFilter']['PROPERTY_CONTACT'])){
				continue;
			}
			$count++;
		endforeach;
	endforeach;	
	?>
	<p style="margin-bottom:20px;display:inline-block;">Найдено: <?=$count;?></p>
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
		<?
		$contacts = Contact::getClientContactsId($idContact = $arItem["PROPERTIES"]["CONTACT"]["VALUE"]);
		?>
		<?foreach($contacts as $k=>$contact):?>
			<?
			if($GLOBALS['arFilter']['PROPERTY_CONTACT'] && !in_array($contact["ID"], $GLOBALS['arFilter']['PROPERTY_CONTACT'])){
				continue;
			}
			?>
		<?endforeach?>
		<?foreach($contacts as $k=>$contact):?>
			<?
			if($GLOBALS['arFilter']['PROPERTY_CONTACT'] && !in_array($contact["ID"], $GLOBALS['arFilter']['PROPERTY_CONTACT'])){
				continue;
			}
			?>
			<?$client = Client::getClientById($contact["CLIENT"]);?>
			<div style="-webkit-box-shadow: 4px 8px 8px 0px rgba(34, 60, 80, 0.2);-moz-box-shadow: 4px 8px 8px 0px rgba(34, 60, 80, 0.2);box-shadow: 4px 8px 8px 0px rgba(34, 60, 80, 0.2);padding: 40px;background: #fff;border-radius: 10px;margin-bottom:20px;
			display:flex;flex-wrap:wrap;justify-content:space-between;">
				<div class="col-md-4" style="border-right: solid 1px;">
					<p><a style="font-weight: bold;text-decoration: none;" href="/event/<?=$arItem["ID"]?>/"><?=$arItem["NAME"]?></a></p>
					<p><?=$arItem['DATE_ACTIVE_FROM']?> - <?=$arItem['DATE_ACTIVE_TO']?></p>
				</div>
				<div class="col-md-4">
					<a href="/clients/<?=$client["ID"]?>/"><?=$client["NAME"]?></a>
					<p style="margin-top:10px;"><span style="font-weight:bold;"><?=$contact["NAME"]?></span></p>
					<p><?=$contact["PREVIEW_TEXT"]?></p>
				</div>
				<div class="col-md-4">
					<div>Телефон: <span style="font-weight:bold;"><?=$contact["PHONE"]?></span></div>
					<div>Почта: <span style="font-weight:bold;"><?=$contact["EMAIL"]?></span></div>
				</div>
			</div>
		<?endforeach?>
		<?/*
		<?foreach($arItem["PROPERTIES"]["CONTACT"]["VALUE"] as $contact):?>
		<div class="row" style="padding: 20px;border-radius: 8px;box-shadow: 1px 1px 5px #ccc;border: 0px solid #f1f1f1;margin-left: 1px;margin-bottom:20px;">
			<div class="left_side">
				<p><?=$arItem["NAME"]?></p>
				<p><?=$arItem['DATE_ACTIVE_FROM']?> - <?=$arItem['DATE_ACTIVE_TO']?></p>
			</div>
			<div class="right_side">
			</div>
		</div>
		<?endforeach?>
		*/?>
	<?/*
	<div class="row list-item <?=$taskStatusClass?>" >
		
		<div class="col-md-1 date-col">
		    <? echo $arItem["DISPLAY_ACTIVE_FROM"] ?>
			<?if($arParams['ALL_DATA_PAGE']):?>
			<span class="list-s-type <?=$arItem['PROPERTIES']['TYPE']['VALUE_XML_ID']?>"><?=$arItem['PROPERTIES']['TYPE']['VALUE_ENUM']?></span>
			<?endif?>
		</div>
		<div class="col-md-10">
		    <? if ($arItem['PROPERTIES']['TYPE']['VALUE_XML_ID'] != 'CONSULT'): ?>
			<div class="status">  
			<?
				if ($status_code == 1)
				echo '<span class="cleint-active">Запланировано</span>';
				else
				echo '<span class="cleint-deactive">Завершено</span>';
			?>
			</div>
		    <? endif ?>
			
		    <a class="name" href="<?= $arItem['DETAIL_PAGE_URL'] ?>"><? echo $arItem["NAME"] ?></a>
			
		    <div class="info">
				<div>
					<span class="tl-info-title">ответственный</span>
					<span class="tl-user"><?= $allManagers[$arItem['PROPERTIES']['MANAGER']['VALUE']]['FIO'] ?></span>
				</div>
				
				<div>
				    <span class="tl-info-title">Период оказания услуги</span>
				    <span class="tl-user"> <?= $arItem["DATE_ACTIVE_FROM"] ?>  <?= $arItem["DATE_ACTIVE_TO"]!=""?'- '.$arItem["DATE_ACTIVE_TO"]:'' ?></span>		
				</div>
				<div>
					<span class="tl-info-title">участников</span>
					<span class="tl-user"><?=count($arItem["PROPERTIES"]["CONTACT"]["VALUE"])?></span>
				</div>
			</div>
		   
			<div class="description"><? echo strip_tags($arItem["PREVIEW_TEXT"]) ?></div>
			
			
		</div>
	</div>
	*/?>
	
	
    <? endforeach; ?>
    <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
	<br /><?= $arResult["NAV_STRING"] ?>
    <? endif; ?>
</div>
