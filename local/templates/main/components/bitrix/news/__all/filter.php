<?php
	/**
		ALL
		* Формирование фильтра для компонента список новостей.
	*/
	
	if ($_REQUEST['DATE_FROM']) {
		$s = strtotime($_REQUEST['DATE_FROM']);
		$GLOBALS[$arParams["FILTER_NAME"]]['>=DATE_ACTIVE_FROM'] = date('d.m.Y 00:00:01', $s);
	}
	if ($_REQUEST['DATE_TO']) {
		$s = strtotime($_REQUEST['DATE_TO']);
		$GLOBALS[$arParams["FILTER_NAME"]]['<=DATE_ACTIVE_FROM'] = date('d.m.Y 23:59:01', $s);
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
		$_REQUEST['PROP']['MANAGER'] = '';
		if(count($arUsersId)>0){
			
			$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MANAGER'] = $arUsersId;	 
			}else {
			
			$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MANAGER'] = -1;
		}
		
	}
	
	foreach ($_REQUEST['PROP'] as $code => $value) {
		if ($value == "")
		continue;
		$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_' . $code] = $value;
	}
	//$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_MSP'] =false;
//	l($GLOBALS[$arParams["FILTER_NAME"]]);
	//exit;
	$arManagers = Helper::getManagers();
	
	$arIndustry = Helper::getOrgIndustry();
	$arRegions = Helper::getRegions();
	//$arDEPARTMENT = Helper::getListValue(Client::CLIENT_IBLOCK_ID, 'DEPARTMENT');
	$arData = getDepartments();
	foreach($arData['result'] as $arT){
		if(in_array($arT['ID'],[8]))continue;
		$arDEPARTMENT [$arT['ID']] =$arT['NAME'] ;
	}
?>

<form action="" method="get" id="filter-form">
    <input type="hidden" name="sort" id="form-sort" value="">
    <div class="row-flex">
		<div class="col-flex">		
		<label>Дата добавления</label>
			<div class="form-group date-row">
				
				<div ><span>От</span> <input type="date" name="DATE_FROM"  class="form-control" value="<?=$_REQUEST['DATE_FROM'] ?>"> </div>
				<div><span>До</span> <input type="date" name="DATE_TO"  class="form-control" value="<?=$_REQUEST['DATE_TO'] ?>"> </div>
			</div>
			
			<div class="form-group">
		<label >Сумма (руб.) </label>
		  <div class="period">
		    <input class="form-control" type="number" name="MONEY_FROM" value="<?= $_REQUEST['MONEY_FROM'] ?>"> - 
		    <input class="form-control" type="number" name="MONEY_TO"  value="<?= $_REQUEST['MONEY_TO'] ?>">
		</div>
	    </div>
		</div>
		
		<div class="col-flex">
			<div class="form-group">
				<label>Отдел</label>
				<select name="DEPARTMENT" class="form-control" >
					<option value="" >Все</option>
					<? foreach ($arDEPARTMENT as $id => $name): ?> 
					<option value="<?= $id ?>" <?= $_REQUEST['DEPARTMENT'] == $id ? 'selected' : '' ?>><?= $name ?></option>
					<? endforeach ?>
				</select>	
			</div>
		</div>
		<div class="col-flex">
			<div class="form-group">
				<label for="exampleFormControlSelect1">Менеджер</label>
				<select class="form-control" name='PROP[MANAGER]'>
					<option value="">Все</option>
					<? foreach ($arManagers as $id => $client): ?>
					<option value='<?= $id ?>' <?= $_REQUEST['PROP']['MANAGER'] == $id ? 'selected' : '' ?>> 
						<?= $client['FIO'] ?>
					</option>
					<? endforeach ?>
				</select>
			</div>
			
		</div>
		
		<div class="col-flex">
		<label for=""> </label>
			<button style="margin-top: 26px;" type="button" onclick="filterGetData()" class="btn btn-success btn-sm" >Фильтровать</button>
		</div>
	</div>
</form>
