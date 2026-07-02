<?php
/**
 * Формирование фильтра для компонента список новостей.
 */

if ($_REQUEST['DATE_FROM']) {
	$s = strtotime($_REQUEST['DATE_FROM']);
	//$GLOBALS[$arParams["FILTER_NAME"]]['>=DATE_ACTIVE_FROM'] = date('d.m.Y 00:00:01', $s);
	$GLOBALS[$arParams["FILTER_NAME"]]['>=DATE_CREATE'] = date('d.m.Y 00:00:01', $s);
}
if ($_REQUEST['DATE_TO']) {
	$s = strtotime($_REQUEST['DATE_TO']);
	//$GLOBALS[$arParams["FILTER_NAME"]]['<=DATE_ACTIVE_FROM'] = date('d.m.Y 23:59:01', $s);
	$GLOBALS[$arParams["FILTER_NAME"]]['<=DATE_CREATE'] = date('d.m.Y 23:59:01', $s);
}
if ($_REQUEST['SERVICE_TYPE']) {
	if ($_REQUEST['SERVICE_TYPE'] == "SERVICE") {
		$arSubQuery = Array('IBLOCK_ID' => IBLOCK_ID_SERVICE, 'PROPERTY_TYPE' => Service::TYPE_SERVICE_ID);
	}
	if ($_REQUEST['SERVICE_TYPE'] == "CONSULT") {
		$arSubQuery = Array('IBLOCK_ID' => IBLOCK_ID_SERVICE, 'PROPERTY_TYPE' => Service::TYPE_CONSALT_ID);
	}
	//$arSubQuery = Array('IBLOCK_ID' => IBLOCK_ID_SERVICE, '>PROPERTY_CLIENT' => 0);
	$GLOBALS[$arParams["FILTER_NAME"]][] = [array('ID' => CIBlockElement::SubQuery('PROPERTY_CLIENT', $arSubQuery)),];
}
if ($_REQUEST['WORK_STATUS']) {
	//Есть активности
	if ($_REQUEST['WORK_STATUS'] == "1") {
		$arSubQuery = Array('IBLOCK_ID' => IBLOCK_ID_SERVICE, 'PROPERTY_STATUS' => Service::STATUS_ACTIVE);
		$GLOBALS[$arParams["FILTER_NAME"]][] = [array('ID' => CIBlockElement::SubQuery('PROPERTY_CLIENT', $arSubQuery)),];
	}
	//НЕТ активности
	/*
	 * НУжно получить клиентов у которых все задачи имеют статус закрыт Service::STATUS_CLOSED
	 */
	if ($_REQUEST['WORK_STATUS'] == "2") {
		$arSubQuery = Array('IBLOCK_ID' => IBLOCK_ID_SERVICE, '!=PROPERTY_STATUS' => "");
		$arSubQuery2 = Array('IBLOCK_ID' => IBLOCK_ID_SERVICE, 'PROPERTY_STATUS' => Service::STATUS_ACTIVE);
		$GLOBALS[$arParams["FILTER_NAME"]][] = [
			'LOGIC' => 'AND',
			array('ID' => CIBlockElement::SubQuery('PROPERTY_CLIENT', $arSubQuery)),
			array('!ID' => CIBlockElement::SubQuery('PROPERTY_CLIENT', $arSubQuery2))
		];
	}

	if ($_REQUEST['WORK_STATUS'] == "3") {
		$arSubQuery = Array('IBLOCK_ID' => IBLOCK_ID_SERVICE);
		$GLOBALS[$arParams["FILTER_NAME"]][] = [
			array('!ID' => CIBlockElement::SubQuery('PROPERTY_CLIENT', $arSubQuery)),
		];
	}
}

if ($_REQUEST['DATE_TO']) {
	$s = strtotime($_REQUEST['DATE_TO']);
	$GLOBALS[$arParams["FILTER_NAME"]]['<=DATE_ACTIVE_FROM'] = date('d.m.Y 23:59:59', $s);
}
if ($_REQUEST['MSP']) {
	if ($_REQUEST['MSP'] == "Y") {
		$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MSP_VALUE'] = "Y";
	}

	if ($_REQUEST['MSP'] == "N") {
		$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MSP_VALUE'] = "N";
	}
	
	if ($_REQUEST['MSP'] == "FALSE") {
		//$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MSP_TEXT'] = "";
		$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MSP'] = false;
		$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_INN'] = false;
		$_REQUEST['INN'] = false;
	}
}
if ($_REQUEST['INN']) {
	if ($_REQUEST['INN'] == "Y") {
		$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_INN'] = "%";
	}
	if ($_REQUEST['INN'] == "N") {
		$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_INN'] = false;
	}
}
//DEPARTMENT
if ($_REQUEST['DEPARTMENT']) {
	//Выбираем всех менеджеров у которых отвед совпадает с выбранным Департаментов
	$sql = CUser::GetList(($by = "id"), ($order = "desc"), ["WORK_DEPARTMENT" =>$_REQUEST['DEPARTMENT']]);
	$arUsersId = [];
	while($arUser = $sql->Fetch()){
		
		$arUsersId[] = $arUser['ID'];
     }
	// l($arUsersId);
	// l($_REQUEST);
	  //$_REQUEST['PROP']['MANAGER'] = '';
	 if(count($arUsersId)>0){
	    
		 $GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MANAGER'] = $arUsersId;	 
	 }else {
	    
	    $GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MANAGER'] = -1;
	 }

}
if($_REQUEST['PROP']["5BMANAGER"]>0){
	$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MANAGER'] = false;
}
foreach ($_REQUEST['PROP'] as $code => $value) {
	if ($value == "")
		continue;
	$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_' . $code] = $value;
}
//$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MSP'] =false;
//l($GLOBALS[$arParams["FILTER_NAME"]]);
$arManagers = Helper::getManagersExt();
$arIndustry = Helper::getOrgIndustry();
$arRegions = Helper::getRegions();
$arDirections = Helper::getDirections();
?>

<form action="" method="get" id="filter-form">
    <input type="hidden" name="sort" id="form-sort" value="">
    <div class="row">
	<div class="col-md-2">
	    <div class="form-group" style="display:none">
		<label for="exampleFormControlSelect1">Фильтр по деятельности</label>
		<select class="form-control" name='PROP[INDUSTRY]'>
		    <option value="">Все</option>
		    <? foreach ($arIndustry as $id => $client): ?>
			    <option value='<?= $id ?>' <?= $_REQUEST['PROP']['INDUSTRY'] == $id ? 'selected' : '' ?>> 
				<?= $client ?>
			    </option>
		    <? endforeach ?>
		</select>
	    </div>

	    <div class="form-group">
		<label>Дата добавления</label>
		<br>
		От <input type="date" name="DATE_FROM"  class="form-control">
		<br>
		До <input type="date" name="DATE_TO"  class="form-control">
	    </div>


	</div>
	<div class="col-md-2">
	    <div class="form-group" style="display:none">
		<label for="">Фильтр по району</label>
		<select class="form-control" name='PROP[REGION]'>
		    <option value="">Все</option>
		    <? foreach ($arRegions as $id => $regionArr): ?>
			    <option value='<?= $id ?>' <?= $_REQUEST['PROP']['REGION'] == $id ? 'selected' : '' ?>> 
				<?= $regionArr['NAME'] ?>
			    </option>
		    <? endforeach ?>
		</select>
	    </div>

	    <div class="form-check">
		<input class="form-check-input" type="radio" name="MSP" id="MSP1" value="" <?= $_REQUEST['MSP'] == '' ? 'checked' : '' ?>>
		<label class="form-check-label" for="MSP1">
		    Все
		</label>
	    </div>
	    <div class="form-check">
		<input class="form-check-input" type="radio" name="MSP" id="MSP2" value="Y" <?= $_REQUEST['MSP'] == 'Y' ? 'checked' : '' ?>>
		<label class="form-check-label" for="MSP2">
		    МСП
		</label>
	    </div>
	    <div class="form-check">
		<input class="form-check-input" type="radio" name="MSP" id="MSP3" value="N" <?= $_REQUEST['MSP'] == 'N' ? 'checked' : '' ?>>
		<label class="form-check-label" for="MSP3">
		    Не МСП
		</label>
	    </div>
		
		<div class="form-check">
		<input class="form-check-input" type="radio" name="MSP" id="MSP4" value="FALSE" <?= $_REQUEST['MSP'] == 'N' ? 'checked' : '' ?>>
		<label class="form-check-label" for="MSP4">
		    Не известно
		</label>
	    </div>
		



	</div>
	<div class="col-md-2">
	
	<? /*
	    <div class="form-group">
		<label>Отдел</label>
		<select name="DEPARTMENT" class="form-control"  id="client-departament-select" >
		    <option value="" >Все</option>
		    <? foreach ($arDirections as $id => $arr): ?> 
			    <option value="<?= $arr['UF_XML_ID'] ?>" <?= $_REQUEST['DEPARTMENT'] == $arr['UF_XML_ID'] ? 'selected' : '' ?>><?= $arr['UF_NAME'] ?></option>
		    <? endforeach ?>
		</select>
	    </div>
*/?>
 <div class="form-group">
		<label >Отдел</label>
	<select name="PROP[DIRECTION]" class="form-control"  id="client-departament-select-new" >
					<option value="" >Все</option>
					<? foreach ($arDirections as $id => $arr): ?> 
					<option value="<?= $arr['UF_XML_ID'] ?>" <?= $_REQUEST['PROP']['DIRECTION'] == $arr['UF_XML_ID'] ? 'selected' : '' ?>><?= $arr['UF_NAME'] ?></option>
					<? endforeach ?>
				</select>
	    </div>
	    <div class="form-check">
		<input class="form-check-input" type="radio" name="INN" id="INN1" value="" <?= $_REQUEST['INN'] == '' ? 'checked' : '' ?>>
		<label class="form-check-label" for="INN1">
		    Все
		</label>
	    </div>
	    <div class="form-check">
		<input class="form-check-input" type="radio" name="INN" id="INN2" value="Y" <?= $_REQUEST['INN'] == 'Y' ? 'checked' : '' ?>>
		<label class="form-check-label" for="INN2">
		    Только с ИНН
		</label>
	    </div>
	    <div class="form-check">
		<input class="form-check-input" type="radio" name="INN" id="INN3" value="N" <?= $_REQUEST['INN'] == 'N' ? 'checked' : '' ?>>
		<label class="form-check-label" for="INN3">
		    Без ИНН
		</label>
	    </div>




	</div>
	<div class="col-md-2">
	    <div class="form-group">
		<label>Менеджер</label>
		<select class="form-control" name='PROP[MANAGER]'  id="clinet-manger-select" >
					<option value="">Все</option>
					<? foreach ($arManagers as $id => $user): ?>
					<option  
					group="<?=$user['UF_DIRECTIONS']?>" 
					value='<?= $id ?>' <?= $_REQUEST['PROP']['MANAGER'] == $id ? 'selected' : '' ?>> 
						<?= $user['LAST_NAME'] ?> <?= $user['NAME'] ?>
					</option>
					<? endforeach ?>
				</select>
	    </div>

	    <div class="form-check">
		<input 
		    class="form-check-input" 
		    type="checkbox"  
		    id="org_type_1" 
		    name='PROP[ORG_TYPE][]' 
		    value="<?= Client::ORG_TYPE_KFX_ID ?>"
		    <?= in_array(Client::ORG_TYPE_KFX_ID, $_REQUEST['PROP']['ORG_TYPE']) ? 'checked' : '' ?>
		    >
		<label class="form-check-label" for="org_type_1">
		    КФХ
		</label>
	    </div>

	    <div class="form-check">
		<input 
		    class="form-check-input" 
		    type="checkbox"  
		    id="org_type_2" 
		    name='PROP[ORG_TYPE][]' 
		    value="<?= Client::ORG_TYPE_OTHER_ID ?>"
		    <?= in_array(Client::ORG_TYPE_OTHER_ID, $_REQUEST['PROP']['ORG_TYPE']) ? 'checked' : '' ?>
		    >
		<label class="form-check-label" for="org_type_2">
		    Иное
		</label>
	    </div>
	    <div class="form-check">
		<input 
		    class="form-check-input" 
		    type="checkbox"  
		    id="org_type_3" 
		    name='PROP[ORG_TYPE][]' 
		    value="<?= Client::ORG_TYPE_INDIVIDUAL_ID ?>"
		    <?= in_array(Client::ORG_TYPE_INDIVIDUAL_ID, $_REQUEST['PROP']['ORG_TYPE']) ? 'checked' : '' ?>
		    >
		<label class="form-check-label" for="org_type_3">
		    ИП
		</label>
	    </div>
	    <div class="form-check">
		<input 
		    class="form-check-input" 
		    type="checkbox" 
		    id="org_type_4" 
		    name='PROP[ORG_TYPE][]' 
		    value="<?= Client::ORG_TYPE_OOO_ID ?>"
		    <?= in_array(Client::ORG_TYPE_OOO_ID, $_REQUEST['PROP']['ORG_TYPE']) ? 'checked' : '' ?>
		    >
		<label class="form-check-label" for="org_type_4">
		    ООО
		</label>
	    </div>
	</div>
	<div class="col-md-2">
	    <div class="form-group">
		<label>Статус клиента</label>
		<select class="form-control" name="WORK_STATUS">
		    <option value="">Все</option>
		    <option value="1" <?= $_REQUEST['WORK_STATUS'] == '1' ? 'selected' : '' ?>>Есть активности</option>
		    <option value="2" <?= $_REQUEST['WORK_STATUS'] == '2' ? 'selected' : '' ?>>Нет активностей</option>
		    <option value="3" <?= $_REQUEST['WORK_STATUS'] == '3' ? 'selected' : '' ?>>Нет услуг</option>
		</select>
	    </div>
	</div>
	<div class="col-md-2">
	    <div class="form-group">
		<label>Оказаны услуги</label>
		<select class="form-control" name="SERVICE_TYPE">
		    <option value="">Все</option>
		    <option value="SERVICE" <?= $_REQUEST['SERVICE_TYPE'] == 'SERVICE' ? 'selected' : '' ?>>Услуги</option>
		    <option value="CONSULT" <?= $_REQUEST['SERVICE_TYPE'] == 'CONSULT' ? 'selected' : '' ?>>Консультация</option>
		</select>
	    </div>

	    <div style="margin-top: 50px;">

		<button type="button" onclick="filterGetData()" class="btn btn-success btn-sm" >Фильтровать</button>
		<br/><br/>
		<button type="button" onclick="window.location.href = '/clients/'"class="btn btn-default btn-sm">Сбросить фильтр</button>
	    </div>
	</div>
    </div>
</form>