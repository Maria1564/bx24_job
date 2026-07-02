<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

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
        //setListCount();
		$('.items-count-consult').text(app.newlist.count);
</script>


<div class="service-list-items">
	<?if(count($arResult["ITEMS"])==0){
	  echo '<center>Нет данных</center>';
	}
	?>
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
	
	<?
	   $taskStatusClass = '';
	   if($arItem['PROPERTIES']['BX24_STATUS_EXT']['VALUE'] == 1){
		   $taskStatusClass = 'task-status-success';		   
	   }
	    if($arItem['PROPERTIES']['TYPE']['VALUE_XML_ID'] != 'CONSULT' && $arItem['PROPERTIES']['STATUS']['VALUE'] == Service::STATUS_CLOSED && $arItem['PROPERTIES']['BX24_STATUS_EXT']['VALUE'] != 1){
		   $taskStatusClass = 'task-status-failed';		   
	   }
	   
	
	
	?>
	    <div class="row list-item <?=$taskStatusClass?>" >
		
		<div class="col-md-1 date-col">
		    <? echo $arItem["DISPLAY_ACTIVE_FROM"] ?>
		</div>
		<div class="col-md-10">
		    <? if ($arItem['PROPERTIES']['TYPE']['VALUE_XML_ID'] != 'CONSULT'): ?>
			    <div>  <?
				if ($arItem['PROPERTIES']['STATUS']['VALUE'] == Service::STATUS_ACTIVE)
					echo '<span class="cleint-active">В работе</span>';
				else
					echo '<span class="cleint-deactive">Завершен</span>';
				?>
			    </div>
		    <? endif ?>
		    <a class="name" href="<?= $arItem['DETAIL_PAGE_URL'] ?>"><? echo $arItem["NAME"] ?></a>

		    <div class="info">
			<div>
			    <?
				$arClient = "";
				//l($arItem['PROPERTIES']['CLINET']);
				if ($arItem['PROPERTIES']['CLIENT']['VALUE'] > 1) {		
			             $arClient = Client::getClientById($arItem['PROPERTIES']['CLIENT']['VALUE']);
		       }
			   // $arClient = Client::getClientById($arItem['PROPERTIES']['CLIENT']['VALUE']);
			    //  l($arClient);
			    ?>
			    <span class="tl-info-title">клиент</span>
			    <span class="tl-user"><?= $arClient['NAME'] ?></span>
			</div>
			<div>
			    <span class="tl-info-title">ответсвтенный</span>
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
			<? if ($ar['TYPE'] == 'CONSULT' && $ar['SERVICE']['ID'] != null): ?>
				<div>
				    <span class="tl-info-title">Услуга</span>
				    <span class="tl-user"><?= $ar['SERVICE']['NAME'] ?></span>
				</div>
			<? endif ?>
		    
			<? if ($arItem['PROPERTIES']['MONEY']['VALUE'] > 0): ?>
				<div>
				    <span class="tl-info-title">Получено денег</span>
				    <span class="tl-user"><?= $arItem['PROPERTIES']['MONEY']['VALUE'] ?> руб.</span>
				</div>
			<? endif ?>
			
			
			</div>
		    
			<div class="description"><? echo $arItem["PREVIEW_TEXT"] ?></div>
			
			
		</div>
	    </div>
    <? endforeach; ?>
    <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
	    <br /><?= $arResult["NAV_STRING"] ?>
    <? endif; ?>
</div>
