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
$client = Client::getClientById($client_id);
$allManagers = Helper::getManagers();
//l($allManagers);
//l($arResult['PROPERTIES']['SERVICE']['VALUE']);
?>

<div class="service-detail">
    <a href="/service/"  class="btn"><i class="fa fa-arrow-left"></i> В список</a>
    <a href="/clients/<?= $client['ID'] ?>/"  class="btn"><i class="fa fa-user"></i> клиент</a>   
	<a onclick="_consultSMSopen()"  class="btn"><i class="fa fa-clipboard"></i> отправить SMS</a>
	
	<a onclick="service.delete(<?= $arResult['ID'] ?>,function(data){ alert('Консультация удалена!');window.location.href='/clients/'+data.client_id+'/'})" style="float: right;margin-right: 10px"><i class="fa fa-trash"></i> удалить</a>
    <a href="/consult/edit/?id=<?= $arResult['ID'] ?>"  style="float: right;margin-right: 10px"><i class="fa fa-edit"></i> редактировать</a>
	
    <h1><?= $arResult['NAME'] ?></h1>

    <br>
    <?
    if ($arResult['PROPERTIES']['SERVICE']['VALUE'] > 0):
	    $service = Service::getServiceById($arResult['PROPERTIES']['SERVICE']['VALUE']);
	   // l($service);
	    ?> 
	   <i class="fa fa-list"></i>  услуга:  <a href="/service/<?=$service['ID']?>/"  class="btn"> <?=$service['NAME']?></a>
<? endif ?>




<? // $arResult['DATE_ACTIVE_FROM']  ?>

    <div class="client">
	<i class="fa fa-calendar"></i> <span style="margin-right: 20px; "><?= $arResult['DATE_ACTIVE_FROM'] ?></span><br>
	<i class="fa fa-user"></i> <a href="/clients/<?= $client['ID'] ?>/"><?= $client['NAME'] ?></a><br>
	<i class="fa fa-user"></i> ответственный <b title="<?= $allManagers[$arResult['PROPERTIES']['MANAGER']['VALUE'] ]['USER_ID'] ?> <?= $allManagers[$arResult['PROPERTIES']['MANAGER']['VALUE']]['FIO'] ?>"><?= $allManagers[$arResult['PROPERTIES']['MANAGER']['VALUE']]['FIO'] ?></b><br>
    <i class="fa fa-map-signs"></i> направление <?=$arResult['PROPERTIES']['DIRECTION']['VALUE']?$arResult['PROPERTIES']['DIRECTION']['VALUE']:"не указано"?></a><br>
	</div>
    </div>
    <div class="description">
<?= strip_tags($arResult['~PREVIEW_TEXT']) ?>

    <? if($arResult['PROPERTIES']['COMMENT']['VALUE']):?>
	  <div class="consult-comment">
	  <h3>КОММЕНТАРИЙ КОНСУЛЬТАНТА</h3>
	  <p>
	  <?= $arResult['PROPERTIES']['COMMENT']['~VALUE'] ?>
	  </p>
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
                raiting.data = <?= CUtil::PhpToJSObject($serviceRaiting) ?>;
	</script>
	<div style="display:none">
	    Удовлетворенность клиента: <b class="VALUE_UF_RAITING"><?= $serviceRaiting['UF_RAITING'] > 0 ? $serviceRaiting['UF_RAITING'] : 'нет' ?></b> 
	    <a onclick="raiting.openServiceEditPopup()"><i class="fa fa-edit"></i></a>
	</div>

    </div>


	
    <div style="display:none">
	<button style="<?= $arResult['PROPERTIES']['STATUS']['VALUE'] == Service::STATUS_ACTIVE ? '' : 'display:none' ?>" type="button" id="setStatus<?= Service::STATUS_ACTIVE ?>" class="setStatusBtns btn btn-warning btn-sm" onclick="ServiceSetStatus(<?= Service::STATUS_CLOSED ?>,<?= $arResult['ID'] ?>)">Закрыть</button>
	<button style="<?= $arResult['PROPERTIES']['STATUS']['VALUE'] == Service::STATUS_ACTIVE ? 'display:none' : '' ?>" type="button" id="setStatus<?= Service::STATUS_CLOSED ?>" class="setStatusBtns btn btn-success btn-sm" onclick="ServiceSetStatus(<?= Service::STATUS_ACTIVE ?>,<?= $arResult['ID'] ?>)">Открыть</button>

    </div>
    <br>
    <br>


    <? //include '_consalt-timeline.php' ?>
<? //include '_change-history.php'  ?>
</div>

<? //l($arResult['PROPERTIES']); ?>