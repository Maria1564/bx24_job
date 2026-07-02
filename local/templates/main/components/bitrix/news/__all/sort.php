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
		$_SESSION['sort']['name'] = 'DATE_ACTIVE_FROM';
		$_SESSION['sort']['order'] = 'DESC';
	} else {
		
	}
}
//l($_SESSION['sort']);
?>
<div class="row">
    <div class="col-md-3 ">
		<div class="items-count-cont ">Найдено клиентов: <span class="items-count-client"></span></div>
		<div class="items-count-cont  ">Найдено услуг: <span class=" items-count-service"></span></div>
		<div class="items-count-cont  ">Найдено консультаций: <span class=" items-count-consult"></span></div>
    </div>
	
    <div class="col-md-5">
	<div class="list-btns">
	    <a onclick="ExelCreate()">Скачать Exel</a>
	</div>

    </div>
    <div class="col-md-4">
	<div class="unit-sorting">
	    <div class="unit-sorting__contain">
		<label for="sorting__chosen" class="unit-sorting__name">Сортировать:</label>
		<select name="sort" id="sorting__chosen" class="f-unit f-unit--select js-inp-styled" data-smart-positioning="false" onchange="SetSorting()">		   
		    <option <?= ($_SESSION['sort']['name'] == 'DATE_ACTIVE_FROM' && $_SESSION['sort']['order'] == "DESC" ? 'selected' : '') ?> value="DATE_ACTIVE_FROM:DESC">По дате добавления</option>
		    <option <?= ($_SESSION['sort']['name'] == 'NAME' && $_SESSION['sort']['order'] == "ASC" ? 'selected' : '') ?> value="NAME:ASC">По названию от А до Я</option>
		    <option <?= ($_SESSION['sort']['name'] == 'NAME' && $_SESSION['sort']['order'] == "DESC" ? 'selected' : '') ?> value="NAME:DESC">По названию от Я до А</option>
		</select>
	    </div>
	</div>
    </div>
</div>
