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


<div class="row sort-row">
    <div class="col-md-2">
	<button class="btn btn-success" onclick="window.location.href = '<?= $arParams['SEF_FOLDER'] ?>add/'">Добавить мероприятие</button>
    </div>
    <div class="col-md-2">

	<div>Найдено: <span class="items-count"></span></div>
    </div>
    <div class="col-md-4">
		<div>
			<a onclick="ExelCreateP(this)" class="loadingx">Выгрузить участников <span></span></a>
		</div>
		<div>
			<a onclick="ExelCreate(this)" class="loadingx">Выгрузить мероприятия <span></span></a>
		</div>

    </div>
    <div class="col-md-4">
	<div class="unit-sorting">
	    <div class="unit-sorting__contain">
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