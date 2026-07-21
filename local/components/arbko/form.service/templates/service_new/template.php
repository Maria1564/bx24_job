<script>
	app.managers = <?= CUtil::PhpToJSObject(Helper::getManagers()) ?>;
</script>


<ul class="s-ul-2">
	<li><a href="/service/"><i class="fa fa-arrow-left"></i> В список услуг</a></li>
<? if ($arResult['CLIENT']): ?>
<li><a href="/clients/<?= $arResult['CLIENT']['ID'] ?>/"><i class="fa fa-user"></i>  На страницу клиента</a></li>
<? endif ?>
<? if ($_REQUEST['id'] > 0): ?>
<li><a href="/service/<?= $_REQUEST['id'] ?>/"><i class="fa fa-black-tie"></i>  На страницу услуги</a></li>
<? endif ?>
</ul>
<div class="add-form-wrapper" style="max-width: 800px; margin: auto">
	
	
    <form action="" method="post" id="form_service">
	    <div id="service-name-text"></div>
		<input  type="hidden"  name="PROPERTY[STATUS]" value="<?= $_REQUEST['PROPERTY']['STATUS'] ?>">
		<input  type="hidden"  name="xDATE_ACTIVE_FROM" value="<?= $_REQUEST['DATE_ACTIVE_FROM'] ?>">
		<? if ($_REQUEST["success"]): ?>   
		<div class="alert alert-success">
		    Данные обновлены
		</div>
		<? endif ?>
		
		<? if ($arResult["error"]): ?>   
		<div class="alert alert-danger">
		    <?= $arResult["error"] ?>
		</div>
		<? endif ?>
		
		
		
		<div class="form-group">
			<label>Клиент: </label>
			<? if (!$arResult['CLIENT']): ?>
			
			<? else: ?>
			
			<? endif ?>
			<span id="client-link" href="/clients/<?= $arResult['CLIENT']['ID'] ?>/" target="_blank"><?= $arResult['CLIENT']['TYPE_NAME_INN'] ?></span>    
			<input id="client-input-id" type="hidden" class="form-control" name="PROPERTY[CLIENT]" value="<?= $arResult['CLIENT']['ID'] ?>">
			<a  onclick="client.formSearchClientOpen()">Выбрать</a>
		</div>
		
		<div class="form-group">
			<label>Название услуги</label>
			<input  type="text" required="" class="form-control" name="NAME" class="ajax-search-inn"  placeholder="Название услуги" readonly="readonly"
			onclick="alert('Название услуги формируется из выбранной услуги');$('#DIRECTION_SERVICE').focus()"
		    value="<?= $_REQUEST['NAME'] != '' ? $_REQUEST['NAME'] : '' ?>"
		    >
		</div>
		
		<? //Список услуг направления SD ?>
		<? include '_direction_section.php'?>
		
		
		
		
		
		
		<? //Денег получено (прямая поддержка) ?>
		<? include '_money_section.php'?>
		
		<? include '_date_section.php'?>
		
		<? include '_bottom_section.php'?>
		
		
		
		<div class="form-group">
			<label>Комментарий</label>
			<textarea  class="form-control" name="PREVIEW_TEXT"><?= $_REQUEST['PREVIEW_TEXT'] != '' ? $_REQUEST['PREVIEW_TEXT'] : '' ?></textarea>
			<small id="emailHelp" class="form-text text-muted"></small>
		</div>
		
		<? if ($_REQUEST['id'] > 0): ?>
		<button type="submit" class="btn-effect__js btn btn-primary" name="BTN_UPDATE">Обновить услугу</button>
		<? else: ?>
		<button type="submit" class="btn-effect__js btn btn-primary" name="BTN_ADD">Создать услугу</button>
		<? endif ?>
		
	</form>
</div>
