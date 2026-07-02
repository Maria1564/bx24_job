<script>
	app.managers = <?= CUtil::PhpToJSObject(Helper::getManagers()) ?>;
</script>
<?
	//l($arResult);
	//$arCurrentManager = Manager::getManagerData();
	//l($arCurrentManager);
	//l(Helper::getManagers());
	//$arCLient = Client::getClientById($arResult['CLIENT']);
	//l( $arCLient['TYPE_NAME_INN'] );
?>
<a data-href="/consult/<?= $arResult['ID'] ?>/" onclick=" window.history.back();" style="margin-right: 20px;"><i class="fa fa-arrow-left"></i>  назад</a> 
<? if ($arResult["SERVICE"]): ?>

<a href="/clients/<?= $arResult['CLIENT']['ID'] ?>/">На страницу клиента</a>

<h1>Редактирование консультации </h1>
<? else: ?>

<h1>Новая консультация</h1>

<? endif ?>
<br>
<br>
<div class="add-form-wrapper">
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
	
    <form id="form_consult" action="" method="post">
		
		
		<div class="form-group">
			<label>Клиент</label>
			<? if (!$arResult['CLIENT']): ?>
			<? else: ?>
			<? endif ?>
			<span id="client-link" href="/clients/<?= $arResult['CLIENT']['ID'] ?>/" target="_blank"><?= $arResult['CLIENT']['TYPE_NAME_INN'] ?></span>    
			<input id="client-input-id" type="hidden" class="form-control" name="PROPERTY[CLIENT]" value="<?= $arResult['CLIENT']['ID'] ?>">
			<a   id="client-select-btn" onclick="client.formSearchClientOpen()">Выбрать</a>
		</div>
		
		<div class="form-group">
			<input type="hidden" id="service-input-id" class="form-control" name="PROPERTY[SERVICE]" value="<?= $arResult['PROPERTY']['SERVICE']["ID"] ?>">
			<label>Услуга</label>
			<span id="service-link"><?= $arResult['PROPERTY']['SERVICE']["NAME"] ?></span>
			<a style="cursor: pointer" onclick="service.formSearchServiceOpen()">Выбрать</a>
		</div>
		
		
		<div class="form-group">
			<input type="hidden" id="input-manager-id" class="form-control" name="PROPERTY[MANAGER]" value="<?= $arResult["MANAGER"]['USER_ID'] ?>">
			<label>Менеджер</label>
			<span id="input-manager-name"><?= $arResult["MANAGER"]['FIO'] ?></span>
			<a style="cursor: pointer" onclick="popupChangeManager('setManager')">Сменить</a>
		</div>
		
		<div class="form-group">
			<label>Запись</label>
			<input type="text" required="" class="form-control" name="NAME" class="ajax-search-inn"  placeholder="Название консультации"
			value="<?= $_REQUEST['NAME'] != '' ? $_REQUEST['NAME'] : '' ?>"
			>
			<small id="emailHelp" class="form-text text-muted">Название консультации</small>
		</div>
		
		
		
		<div class="row ">
			<div class="form-group col-md-3" >
				
				<?
					$arDirections = Helper::getDirections();
				?>
				<label>Направление</label>
				<select  name="PROPERTY[DIRECTION]" class="form-control" style="display:inline;max-width:120px;" required onchange="selectDirectionEvent()">
					<option value="">Выбрать</option>
					<?foreach($arDirections as $ar):?>			
					<option value="<?=$ar['UF_XML_ID']?>" <?=$ar['UF_XML_ID']== $_REQUEST['PROPERTY']['DIRECTION']?'selected':''?>><?=$ar['UF_NAME']?></option>
					<?endforeach?>			
				</select>
			</div>
			<div class="form-group col-md-4">
				<label>Дата и время</label>
				<input id="startDate" type="date" class="form-control" name="DATE" style="display: inline;width: 150px;"
				value="<?= $_REQUEST['DATE'] != '' ? $_REQUEST['DATE'] : date('Y-m-d') ?>"   oninput="validDate(this.value, this)" >
				<input type="time" class="form-control" name="TIME" style="display: inline;width: 100px;"
				value="<?= $_REQUEST['TIME'] != '' ? $_REQUEST['TIME'] : date('H:i') ?>" >
				<small id="emailHelp" class="form-text text-muted"></small>
			</div>
			
		</div>
		
		<? include '_finance_source.php'?>
		
		
		
		<div class="form-group">
			<label>Комментарий</label>
			<textarea required="" class="form-control" name="PREVIEW_TEXT"><?= $_REQUEST['PREVIEW_TEXT'] != '' ? $_REQUEST['PREVIEW_TEXT'] : '' ?></textarea>
			<small id="emailHelp" class="form-text text-muted"></small>
		</div>
		
		<? if ($_REQUEST['id'] > 0): ?>
		<button type="submit" class="btn-effect__js btn btn-primary" name="BTN_UPDATE">Обновить</button>
		<? else: ?>
		<button type="submit" class="btn-effect__js btn btn-primary" name="BTN_ADD">Создать</button>
		<? endif ?>
		
	</form>
</div>
<?
	//l($arResult);
?>