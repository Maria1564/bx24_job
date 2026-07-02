<?
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
	use Bitrix\Main\Type\DateTime;
	$allManagers = Helper::getManagers();
	//Детальная страница события
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
?>

<div class="service-detail">
	<? /*  <a href="/service/"  class="btn"><i class="fa fa-arrow-left"></i> В список услуг</a>*/?>
	
	<a href="/event/"  class="btn">В список мероприятий</a>
	
    <?if($client_id>0):?>
	<a href="/clients/<?= $client['ID'] ?>/"  class="btn"><i class="fa fa-user"></i> клиент</a>
	<?else:?>
	<a href="/clients/<?= $client['ID'] ?>/"  class="btn"></a>
	<?endif?>
	
	
	
	<?/*
    <? if ($arResult["PROPERTIES"]['BX24_TASK_ID']['VALUE'] > 0): ?>
	<a style="float: right"
	href="https://arbko.bitrix24.ru/company/personal/user/6/tasks/task/view/<?= $arResult["PROPERTIES"]['BX24_TASK_ID']['VALUE'] ?>/"
	target="_blank">Смотреть задачу в Битрикс 24</a>
    <? endif ?>
	
	*/?>
	
    <a href="/event/edit/?id=<?= $arResult['ID'] ?>" style="float: right;margin-right: 10px"><i class="fa fa-edit"></i> редактировать</a>
	 
	<br/><br/>
	
	<?
	global $DB;
	$current_date =  new DateTime();
	$compare_date = $DB->CompareDates($current_date, $arResult['DATE_ACTIVE_TO']); 
	if($compare_date == 1){
		$status_code = 2;
		$status_date = "Завершено";
	}
	else{
		$status_code = 1;
		$status_date = "Запланировано";
	}
	?>
	
    <h1><?= $arResult['NAME'] ?> 
		<span class="status-service-text">
			<span class="status-<?= $status_code ?>">
				<?= $status_date ?>
			</span>
		</span> 
	</h1>
    <br>
	
	
	
	
	
    <? // $arResult['DATE_ACTIVE_FROM'] ?>
	
	<?/*
    <div class="client">
		<span style="margin-right: 20px; "><i class="fa fa-calendar"></i> <?  $arT = explode(" ", $arResult['DATE_ACTIVE_FROM']); echo  $arT[0]; ?> 
			<? if( $arResult['DATE_ACTIVE_TO']){
				$arT = explode(" ", $arResult['DATE_ACTIVE_TO']); 
				echo  ' - '.$arT[0];
			}
			?></span>
			<?if($client_id>0):?>
			<a href="/clients/<?= $client['ID'] ?>/"> <?= $client['NAME'] ?></a>
			<?else:?>
			Не привязан к клиенту
			<?endif?>
	</div>
	*/?>
	<div style="display:flex;flex-wrap:wrap;">
		<div style="margin-right:30px;">
			<span style="font-weight:bold;"><?=$arResult['DATE_ACTIVE_FROM']?></span>
		</div>
		<div>
			<span style="font-weight:bold;"><?=$arResult['DATE_ACTIVE_TO']?></span>
		</div>
	</div>
	
	<p style="margin-top:20px;"><?if($arResult['PROPERTIES']['MANAGER']['VALUE']):?>Менеджер: <span style="font-weight:bold;"><?=$allManagers[$arResult['PROPERTIES']['MANAGER']['VALUE']]["FIO"]?></span> <?endif?></p>
	
    <div class="description">
	
		<?=Helper::normalizeBx24tags($arResult['~PREVIEW_TEXT'])?>
	</div>
		
	<p style="margin-bottom:20px;">Участников: <span style="font-weight:bold;"><?if($arResult["PROPERTIES"]["CONTACT"]["VALUE"]):?><?=count($arResult["PROPERTIES"]["CONTACT"]["VALUE"])?><?else:?>0<?endif?></span></p>
	<?if($arResult["PROPERTIES"]["CONTACT"]["VALUE"]):?>
	<p style="margin-bottom:20px;text-align:center;"><a href="#"  onclick="ExelCreate(this)" class="loadingx">Выгрузить участинков</a></p>
	<?endif?>
	
	<form style="display:none;" action="" method="get" id="filter-form">
		<?foreach($arResult["PROPERTIES"]["CONTACT"]["VALUE"] as $c):?>
			<input type="hidden" name="ID[]" value="<?=$c?>">
		<?endforeach?>
	</div>
	
	
	<div class="contacts">
		<?
		$contacts = Contact::getClientContactsId($idContact = $arResult["PROPERTIES"]["CONTACT"]["VALUE"]);
		?>
		<?foreach($contacts as $contact):?>
			<?$client = Client::getClientById($contact["CLIENT"]);?>
			<div style="-webkit-box-shadow: 4px 8px 8px 0px rgba(34, 60, 80, 0.2);-moz-box-shadow: 4px 8px 8px 0px rgba(34, 60, 80, 0.2);box-shadow: 4px 8px 8px 0px rgba(34, 60, 80, 0.2);padding: 40px;background: #fff;border-radius: 10px;margin-bottom:20px;
			display:flex;flex-wrap:wrap;justify-content:space-between;">
				<div>
					<a href="/clients/<?=$client["ID"]?>/"><?=$client["NAME"]?></a>
					<p style="margin-top:10px;"><span style="font-weight:bold;"><?=$contact["NAME"]?></span></p>
					<p><?=$contact["PREVIEW_TEXT"]?></p>
				</div>
				<div>
					<div>Телефон: <span style="font-weight:bold;"><?=$contact["PHONE"]?></span></div>
					<div>Почта: <span style="font-weight:bold;"><?=$contact["EMAIL"]?></span></div>
				</div>
			</div>
		<?endforeach?>
		
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