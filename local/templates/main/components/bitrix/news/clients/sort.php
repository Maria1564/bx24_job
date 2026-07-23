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
} else {
	if ($_SESSION['sort'] == "") {
		//$_SESSION['sort']['name'] = 'DATE_ACTIVE_FROM';
		$_SESSION['sort']['name'] = 'PROPERTY_SORT_DATE';
		$_SESSION['sort']['order'] = 'DESC';
	} else {
		
	}
}
//l($_SESSION['sort']);
?>
<div class="row sort-row">
    <div class="col-md-2">
	<button class="btn btn-success" onclick="window.location.href = '/clients/add/'">Добавить клиента</button>
    </div>
    <div class="col-md-2">

	<div class="items-count-cont">Найдено: <span class="items-count"></span></div>
    </div>
    <div class="col-md-4">
	<div class="list-btns">
	    <a onclick="ExelCreate(this)" class="loadingx">Скачать Excel <span></span></a>
	</div>

    </div>
    <div class="col-md-4">
	<div class="unit-sorting">
	    <div class="unit-sorting__contain">
		<select name="sort" id="sorting__chosen" class="f-unit f-unit--select js-inp-styled" data-smart-positioning="false" onchange="SetSorting()">		   
		    <option <?= ($_SESSION['sort']['name'] == 'PROPERTY_SORT_DATE' && $_SESSION['sort']['order'] == "DESC" ? 'selected' : '') ?> value="PROPERTY_SORT_DATE:DESC">По дате добавления</option> <?//DATE_ACTIVE_FROM?>
		    <option <?= ($_SESSION['sort']['name'] == 'NAME' && $_SESSION['sort']['order'] == "ASC" ? 'selected' : '') ?> value="NAME:ASC">По названию от А до Я</option>
		    <option <?= ($_SESSION['sort']['name'] == 'NAME' && $_SESSION['sort']['order'] == "DESC" ? 'selected' : '') ?> value="NAME:DESC">По названию от Я до А</option>
		</select>
	    </div>
	</div>
    </div>
</div>
