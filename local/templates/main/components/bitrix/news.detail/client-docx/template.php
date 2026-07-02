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
?>


<div class="clinet-detail">
	
	docx
    <a href="/clients/"  class="btn"><i class="fa fa-arrow-left"></i> В список</a>
    <?
    if ($arResult['PROPERTIES']['BX24_COMPANY_ID']['VALUE'] > 0) {
	    ?>
	    <a target="_blank" href="https://arbko.bitrix24.ru/crm/company/details/<?=$arResult['PROPERTIES']['BX24_COMPANY_ID']['VALUE']?>/"  class="btn">
		<i class="fa fa-address-card"></i> bitrix24.ru</a>
	    <?
    }
    ?>
	 <a   class="btn" onclick="WordCreate()"><i class="fa fa-file-word-o"></i> скачать </a>
    <br/><br/>
    <div class="row">
	<div class="col-md-3 client-logo">
	    <?
	    if ($arResult["PREVIEW_PICTURE"]["SRC"] == "") {
		    $arResult["PREVIEW_PICTURE"]["SRC"] = "/test-files/no-photo.png";
		    $isNoImg = true;
	    }
	    ?>
	    <img src="<?= $arResult["PREVIEW_PICTURE"]["SRC"] ?>" alt="" class="">
	</div>

	<div class="col-md-6">
	    <? include '_inform.php'; ?>
	</div>


	<div class="col-md-3">
	    <a href="/clients/edit/?id=<?= $arResult['ID'] ?>"><i class="fa fa-edit"></i> редактировать</a>
	    <br> <br>
	    <? include '_raiting.php'; ?>
	</div>

    </div>

    <div>
	<ul class="nav nav-tabs">
	    <li class="active">
		<a data-toggle="tab" href="#description">История работы</a>
	    </li>
	    <li>
		<a data-toggle="tab" href="#characteristics" onclick="client.getInformationFromEGRNById(<?= $arResult['ID'] ?>)">О контрагенте</a>
	    </li>
	</ul>
	<div class="tab-content">
	    <div class="tab-pane active" id="description">
		<? include '_service-timeline.php'; ?>
	    </div>
	    <div class="tab-pane" id="characteristics">
		<div class="timeline-content">
		    <div class="client-contragent-info">

		    </div>

		</div>
	    </div>

	</div>

    </div>


</div>

