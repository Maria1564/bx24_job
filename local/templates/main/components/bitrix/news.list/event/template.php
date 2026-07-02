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


<div class="service-list-items">
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
	
	<?

		global $DB;
		$current_date =  new DateTime();
		$compare_date = $DB->CompareDates($current_date, $arItem['DATE_ACTIVE_TO']); 
		if($compare_date == 1){
			$status_code = 2;
			$status_date = "Завершено";
			$taskStatusClass = 'task-status-success';	
		}
		else{
			$status_code = 1;
			$status_date = "Запланировано";
			$taskStatusClass = 'task-status-refused';	
		}
		
		//убираем точное время
		/*
		$arT = explode(" ",$arItem["DATE_ACTIVE_FROM"]);
		$arItem["DATE_ACTIVE_FROM"] =  $arT [0];
		$arT = explode(" ",$arItem["DATE_ACTIVE_TO"]);
		$arItem["DATE_ACTIVE_TO"] =  $arT [0];
		*/
		
		
	?>
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
					<? if ($arItem['PROPERTIES']['TYPE']['VALUE_XML_ID'] == 'CONSULT'): ?>
				    <span class="tl-info-title">дата </span>
				    <span class="tl-user"> <?= $arItem["DATE_ACTIVE_FROM"] ?></span>
					<? else: ?>
				    <span class="tl-info-title">Период оказания услуги</span>
				    <span class="tl-user"> <?= $arItem["DATE_ACTIVE_FROM"] ?>  <?= $arItem["DATE_ACTIVE_TO"]!=""?'- '.$arItem["DATE_ACTIVE_TO"]:'' ?></span>
					<? endif ?>
					
				</div>
				<div>
					<span class="tl-info-title">участников</span>
					<span class="tl-user"><?if($arItem["PROPERTIES"]["CONTACT"]["VALUE"]):?><?=count($arItem["PROPERTIES"]["CONTACT"]["VALUE"])?><?else:?>0<?endif?></span>
				</div>
				<? if ($ar['TYPE'] == 'CONSULT' && $ar['SERVICE']['ID'] != null): ?>
				<div>
				    <span class="tl-info-title">Услуга</span>
				    <span class="tl-user"><?= $ar['SERVICE']['NAME'] ?></span>
				</div>
				<? endif ?>
				
				<? if ($arItem['PROPERTIES']['MONEY']['VALUE'] > 0 || $arItem['PROPERTIES']['MONEY2']['VALUE'] >0|| $arItem['PROPERTIES']['MONEY3']['VALUE'] >0): ?>
				<div>
				    <span class="tl-info-title">Получено денег</span>
					<?if($arItem['PROPERTIES']['MONEY']['VALUE']):?>
				    <span class="tl-user"><?=number_format($arItem['PROPERTIES']['MONEY']['VALUE'], 0, ',', ' ') ?> руб.  (субсидии/гранты)</span>
					 <?endif?>
					<?if($arItem['PROPERTIES']['MONEY2']['VALUE']):?>
					 <span class="tl-user"><?=number_format($arItem['PROPERTIES']['MONEY2']['VALUE'], 0, ',', ' ') ?> руб. (кредиты/займы)</span>
					 <?endif?>
					<?if($arItem['PROPERTIES']['MONEY3']['VALUE']):?>
					 <span class="tl-user"><?=number_format($arItem['PROPERTIES']['MONEY3']['VALUE'], 0, ',', ' ') ?> руб. (госбюджет/АРБ)</span>
					 <?endif?>
				</div>
				<? endif ?>
				<?// l($arItem['PROPERTIES']['SMS_VOTE'])?>
				
				
				<? 
					/*
						----------------------------------------------------------------------------------------
						----------------------------------------------------------------------------------------
						----------------------------------------------------------------------------------------
						----------------------------------------------------------------------------------------
						----------------------------------------------------------------------------------------
						Выводим СМС данные
					*/
					//l($arItem['SMS_DATA']);
					//СМС отправлен но клиент не поставил оценку
					$smsStatus = 0;
					if($arItem['SMS_DATA']['UF_SMS_SEND_DATE']>0 && $arItem['SMS_DATA']['UF_SMS_VOTE_DATE'] == ""){
					  $smsStatus = 1;
					
					}
					//СМС отправлен клиент поставил оценку 
					if($arItem['SMS_DATA']['UF_SMS_SEND_DATE']>0 && $arItem['SMS_DATA']['UF_SMS_VOTE_DATE']>0 && $arItem['SMS_DATA']['UF_USER_VOTE']>0){
					$smsStatus = 2;
					
					}
				?>
				<? if ($smsStatus>0): ?>
				<div>
				    <span class="tl-info-title">SMS оценка </span>
				    <span class="tl-user">
					     <?if($smsStatus == 1):?>
						   Отправлен:  <?= date('d:m:y H:i:s',$arItem['SMS_DATA']['UF_SMS_SEND_DATE']) ?><br>
						   Оценка: нет
						 <?endif?>
						 
						  <?if($smsStatus == 2):?>
						Отправлен: <?= date('d:m:y H:i:s',$arItem['SMS_DATA']['UF_SMS_SEND_DATE']) ?><br>
						Оценка: <?= $arItem['SMS_DATA']['UF_USER_VOTE'] ?> (<?= date('d:m:y H:i:s',$arItem['SMS_DATA']['UF_SMS_VOTE_DATE']) ?>)<br> 
						 <?endif?>
					   
					</span>
					
				</div>
				<? endif ?>
			</div>
		    
			<div class="description"><? echo strip_tags($arItem["PREVIEW_TEXT"]) ?></div>
			
			
		</div>
	</div>
    <? endforeach; ?>
    <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
	<br /><?= $arResult["NAV_STRING"] ?>
    <? endif; ?>
</div>
