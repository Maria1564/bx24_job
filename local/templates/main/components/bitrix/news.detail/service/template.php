<?
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
	//Детальная страница организации
	/*
		* https://api-fns.ru/api_help
		* https://dadata.ru/api/suggest/party/
		* 
		* 
	*/
	$this->setFrameMode(true);
	$client_id = $arResult['PROPERTIES']['CLIENT']['VALUE'];
	//l($client_id );
	if($client_id>1){
		$client = Client::getClientById($client_id);
	}
	if ($arResult['PROPERTIES']['TYPE']['VALUE_ENUM_ID'] == Service::TYPE_CONSALT_ID) {
		echo '
		<script>
		window.location="/consult/' . $arResult['ID'] . '/";
		</script>';
		
		//header('location:/consult/'.$arResult['ID'].'/');
	}

	$isClosedService = $arResult['PROPERTIES']['STATUS']['VALUE'] == Service::STATUS_CLOSED;
	$deadlineDate = $isClosedService ? Service::calculateDeadline($arResult['DATE_ACTIVE_FROM'], $arResult['DATE_ACTIVE_TO']) : '';
	$contractProvidedInfo = Service::getContractProvidedInfo(
		$arResult['PROPERTIES']['CONTRACT_PROVIDED']['VALUE'],
		$arResult['PROPERTIES']['CONTRACT_PROVIDED_DATE']['VALUE'],
		$deadlineDate
	);
?>

<div class="service-detail">
	<? /*  <a href="/service/"  class="btn"><i class="fa fa-arrow-left"></i> В список услуг</a>*/?>
	
    <?if($client_id>0):?>
	<a href="/clients/<?= $client['ID'] ?>/"  class="btn"><i class="fa fa-user"></i> клиент</a>
	<?else:?>
	<a href="/clients/<?= $client['ID'] ?>/"  class="btn"></a>
	<?endif?>
	
    <? if ($arResult["PROPERTIES"]['BX24_TASK_ID']['VALUE'] > 0): ?>
	<a style="float: right"
	href="https://arbko.bitrix24.ru/company/personal/user/6/tasks/task/view/<?= $arResult["PROPERTIES"]['BX24_TASK_ID']['VALUE'] ?>/"
	target="_blank">Смотреть задачу в Битрикс 24</a>
    <? endif ?>
	
    <a href="/service/edit/?id=<?= $arResult['ID'] ?>" style="float: right;margin-right: 10px"><i class="fa fa-edit"></i> редактировать</a>
	 
	<br/><br/>
    <h1><?= $arResult['NAME'] ?> 
		<span class="status-service-text">
			<span class="status-<?= $arResult['PROPERTIES']['STATUS']['VALUE'] ?>">
				<?= Service::getStatusTextById($arResult['PROPERTIES']['STATUS']['VALUE']) ?>
			</span>
		</span> 
	</h1>
    <br>
	
	
	
	
	
    <? // $arResult['DATE_ACTIVE_FROM'] ?>
	
    <div class="client">
		<span style="margin-right: 20px; "><i class="fa fa-calendar"></i> <?  $arT = explode(" ", $arResult['DATE_ACTIVE_FROM']); echo  $arT[0]; ?> 
			<? if( $arResult['DATE_ACTIVE_TO']){
				$arT = explode(" ", $arResult['DATE_ACTIVE_TO']); 
				echo  ' - '.$arT[0];
			}
			?></span>
			<? if ($deadlineDate): ?>
			<span style="margin-right: 20px; "><i class="fa fa-clock-o"></i> Дедлайн по контракту: <?= $deadlineDate ?></span>
			<span style="margin-right: 20px; "><i class="fa fa-file-text-o"></i> Предоставил контракт: <?= $contractProvidedInfo['STATUS'] ?>, <?= $contractProvidedInfo['TEXT'] ?></span>
			<? endif ?>
			<?if($client_id>0):?>
			<a href="/clients/<?= $client['ID'] ?>/"> <?= $client['NAME'] ?></a>
			<?else:?>
			Не привязан к клиенту
			<?endif?>
	</div>
    <div class="description">
	
		<?=Helper::normalizeBx24tags($arResult['~PREVIEW_TEXT'])?>
	</div>
	
	<div class="dop-sesc">
		<?if($arResult['PROPERTIES']['MONEY']['VALUE']):?>
		<div class="itemect">
			<b>Денег получено (субсидии/гранты), руб.:</b> <?=number_format($arResult['PROPERTIES']['MONEY']['VALUE'], 0, ',', ' ') ?>  руб.
		</div>
		<?endif?>
		<?if($arResult['PROPERTIES']['MONEY2']['VALUE']):?>
		<div class="itemect">
			<b>Денег получено (кредиты/займы), руб.:</b> <?=number_format($arResult['PROPERTIES']['MONEY2']['VALUE'], 0, ',', ' ') ?> руб.
		</div>
		<?endif?>
		
		<?if($arResult['PROPERTIES']['MONEY3']['VALUE']):?>
		<div class="itemect">
			<b>Денег получено (госбюджет/АРБ), руб.:</b> <?=number_format($arResult['PROPERTIES']['MONEY3']['VALUE'], 0, ',', ' ') ?> руб.
		</div>
		<?endif?>
		
		
		<?if($arResult['PROPERTIES']['COMMENT']['VALUE']):?>
		<div class="itemect comment-spec">
			<b>Комментарий специалиста:</b><br>
			<?=$arResult['PROPERTIES']['COMMENT']['VALUE']?> 
		</div>
		<?endif?>
		<?// l($arResult['PROPERTIES']['BX24_WHAT_DO'])?>
		<?if($arResult['PROPERTIES']['BX24_WHAT_DO']['VALUE']):?>
		<div class="itemect comment-spec">
			<b>Что было сделано:</b><br>
			<?=$arResult['PROPERTIES']['BX24_WHAT_DO']['VALUE']['TEXT']?> 
		</div>
		<?endif?>
		
	</div>
    <div class="client-udov">
		<?
			$raiting = new Raiting();
			$serviceRaiting = $raiting->getServiceRaitingArray($arResult['ID']);
			//l($serviceRaiting);
		?>
		<script>
		<?if($serviceRaiting):?>
		   raiting.data = <?= CUtil::PhpToJSObject($serviceRaiting) ?>;
		<?else:?>
		   
			raiting.data = {'ID':'','UF_CLIENT_ID':'','UF_MANAGER_ID':'','UF_RAITING':'','UF_TIME':'','UF_TEXT':'','UF_SERVICE_ID':<?=$arResult['ID']?>,'UF_FROM_USER':'0','UF_SMS_NUMBER':'','UF_SMS_LINK':'','UF_SMS_VOTE_DATE':'','UF_SMS_SEND_DATE':'1611750353','UF_SMS_TEXT':'','UF_USER_VOTE':''};
		
		<?endif?>
			
		</script>
		<div>
			Удовлетворенность клиента: <b class="VALUE_UF_RAITING"><?= $serviceRaiting['UF_RAITING'] > 0 ? $serviceRaiting['UF_RAITING'] : 'нет' ?></b> 
			<a onclick="raiting.openServiceEditPopup()"><i class="fa fa-edit"></i></a>
		</div>
		
		
		
	</div>
	
	
    <div >
		<button 
	    style="<?= $arResult['PROPERTIES']['STATUS']['VALUE'] == Service::STATUS_ACTIVE ? '' : 'display:none' ?>" 
	    type="button" id="setStatus<?= Service::STATUS_ACTIVE ?>" 
	    class="setStatusBtns btn btn-warning btn-sm" 
	    onclick="ServiceSetStatus(<?= Service::STATUS_CLOSED ?>,<?= $arResult['ID'] ?>)">
			Закрыть услугу
		</button>
		<button 
	    style="<?= $arResult['PROPERTIES']['STATUS']['VALUE'] == Service::STATUS_ACTIVE ? 'display:none' : '' ?>" 
	    type="button" id="setStatus<?= Service::STATUS_CLOSED ?>" 
	    class="setStatusBtns btn btn-success btn-sm" 
	    onclick="ServiceSetStatus(<?= Service::STATUS_ACTIVE ?>,<?= $arResult['ID'] ?>)">
			Открыть услугу
		</button>
		
	</div>
    <br>
	<div id="sms-vote-block" >
		<?
			$APPLICATION->IncludeComponent(
			"arbko:smsvote", "", Array( "ID" =>$arResult['ID'])
			);
		?>
	</div>
    <br>
	
    <? include '_consalt-timeline.php' ?>
    <? include '_change-history.php' ?>
</div>

<?
//l($arResult['PROPERTIES']); ?>
