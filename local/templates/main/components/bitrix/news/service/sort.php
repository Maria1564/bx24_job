<?
if (!empty($_REQUEST['sort'])) {
	//SHOW_COUNTER
	$ar = explode(':', $_REQUEST['sort']);
	$_SESSION['sort']['order'] = $ar[1];
	$_SESSION['sort']['name'] = $ar[0];
	if ($_REQUEST['sort'] == 'RAITING') {

		$_SESSION['sort']['name'] = 'PROPERTY_rating';
		$_SESSION['sort']['order'] = 'DESC';
	}

	if ($_REQUEST['sort'] == 'OCCUPANCY') {
		$_SESSION['sort']['name'] = 'PROPERTY_OCCUPANCY';
		$_SESSION['sort']['order'] = 'DESC';
	}


	if ($_REQUEST['sort'] == 'RESET') {
		$_SESSION['sort']['name'] = '';
		$_SESSION['sort']['order'] = '';
	}
	
	
	
}
else {
	if ($_SESSION['sort'] == "") {
		$_SESSION['sort']['name'] = 'NAME';
		$_SESSION['sort']['order'] = 'ASC';
	} else {
		
	}
}
?>


<div class="row">
    <div class="col-md-12">
	<button class="btn btn-success" onclick="window.location.href = '<?= $arParams['SEF_FOLDER'] ?>add/'">Добавить</button>
    </div>
    <div class="col-md-3">

		<div class="items-count-cont">Найдено: <span class="items-count"></span></div>
		
		
		<?
		$test = $GLOBALS[$arParams["FILTER_NAME"]];
		$test["=IBLOCK_ID"] = $arParams["IBLOCK_ID"];
		//print_r($test);

		$arSelect_dop = Array("ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_MONEY", "PROPERTY_MONEY2", "PROPERTY_MONEY3");
		$res_dop = CIBlockElement::GetList(Array(), $test, false, false, $arSelect_dop);
		$sum_fin = 0;
		while($ob_dop = $res_dop->GetNextElement())
		{
			$arFields_dop = $ob_dop->GetFields();
			$sum_fin = (int)$sum_fin + (int)$arFields_dop["PROPERTY_MONEY_VALUE"] + (int)$arFields_dop["PROPERTY_MONEY2_VALUE"] + (int)$arFields_dop["PROPERTY_MONEY3_VALUE"];
		}
		//print_R($sum_fin)
		?>
		<div class="items-count-sum">Общая сумма поддержки: <span><?echo number_format($sum_fin, 0, ',', ' ');?></span></div>
		
		
    </div>
    <div class="col-md-5">
	<div class="list-btns">
	    <a onclick="ExelCreate(this)" class="loadingx">Скачать Excel <span></span></a>
	</div>

    </div>
    <div class="col-md-4">
	<div class="unit-sorting">
	    <div class="unit-sorting__contain">
		<label for="sorting__chosen" class="unit-sorting__name">Сортировать:</label>
		<select name="sort" id="sorting__chosen" class="f-unit f-unit--select js-inp-styled" data-smart-positioning="false" onchange="SetSorting()">		   
		    <option <?= ($_SESSION['sort']['name'] == 'DATE_ACTIVE_FROM' && $_SESSION['sort']['order'] == "ASC" ? 'selected' : '') ?> value="DATE_ACTIVE_FROM:ASC">По дате добавления (по возрастанию)</option>
			<option <?= ($_SESSION['sort']['name'] == 'DATE_ACTIVE_FROM' && $_SESSION['sort']['order'] == "DESC" ? 'selected' : '') ?> value="DATE_ACTIVE_FROM:DESC">По дате добавления (по убыванию)</option>
			
			<option <?= ($_SESSION['sort']['name'] == 'DATE_ACTIVE_TO' && $_SESSION['sort']['order'] == "ASC" ? 'selected' : '') ?> value="DATE_ACTIVE_TO:ASC">По дате закрытия (по возрастанию)</option>
			<option <?= ($_SESSION['sort']['name'] == 'DATE_ACTIVE_TO' && $_SESSION['sort']['order'] == "DESC" ? 'selected' : '') ?> value="DATE_ACTIVE_TO:DESC">По дате закрытия (по убыванию)</option>
			
		    <option <?= ($_SESSION['sort']['name'] == 'NAME' && $_SESSION['sort']['order'] == "ASC" ? 'selected' : '') ?> value="NAME:ASC">По названию от А до Я</option>
		    <option <?= ($_SESSION['sort']['name'] == 'NAME' && $_SESSION['sort']['order'] == "DESC" ? 'selected' : '') ?> value="NAME:DESC">По названию от Я до А</option>
		</select>
	    </div>
	</div>
    </div>
</div>