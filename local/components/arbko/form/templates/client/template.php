<script>
        app.managers = <?= CUtil::PhpToJSObject(Helper::getManagers()) ?>;
</script>
<?
//l($arResult);
// $arCurrentManager = Manager::getManagerData();
//l($arCurrentManager);
//$arCLient = Client::getClientById($arResult['CLIENT']);
//l( $arCLient['TYPE_NAME_INN'] );
?>
<div class="add-form-wrapper">


    <form action="" method="post">


	<div class="form-group">
	    <label>Клиент</label>
	    <? if (!$arResult['CLIENT']): ?>
		    <a  onclick="popup.open({
	                                    url: '/ajax/manager/list.php',
	                                    clickItemFunctionName: 'functTest',
	                                    selectedManager: <?= $USER->GetID() ?>
	                                })">Выбрать</a>
		<? else: ?>
		    <a id="client-link" href="/clients/<?= $arResult['CLIENT']['ID'] ?>/" target="_blank"><?= $arResult['CLIENT']['TYPE_NAME_INN'] ?></a>
		    <a  onclick="popup.open({
	                                    url: '/ajax/manager/list.php',
	                                    clickItemFunctionName: 'functTest',
	                                    selectedManager: <?= $USER->GetID() ?>
	                                })">Сменить</a>
		<? endif ?>
	    <input id="client-input" type="hidden" class="form-control" name="PROPERTY[CLIENT]" value="<?= $arResult['CLIENT']['ID'] ?>">	
	</div>

	<div class="form-group">
	    <input type="hidden" id="input-manager-id" class="form-control" name="PROPERTY[MANAGER]" value="<?= $arResult["MANAGER"]['USER_ID'] ?>">
	    <label>Менеджер</label>
	    <span id="input-manager-name"><?= $arResult["MANAGER"]['FIO'] ?></span>
	    <a style="cursor: pointer" onclick="popupChangeManager('setManager')">Сменить</a>
	</div>



	<div class="form-group">
	    <label>Запись</label>
	    <input type="text" required="" class="form-control" name="NAME" class="ajax-search-inn"  placeholder="Название услуги">
	    <small id="emailHelp" class="form-text text-muted">Название услуги</small>
	</div>

	<div class="form-group">
	    <label>Задача битрикс</label>
	    <a href="">Привязать задачу</a>
	    <input type="hidden" class="form-control" name="PROPERTY[BITRIX24]">	
	</div>


	<div class="form-group">
	    <label>Дата и время</label>
	    <input type="date" class="form-control" name="DATE" style="display: inline;width: 150px;" value="<?= date('Y-m-d') ?>">
	    <input type="time" class="form-control" name="TIME" style="display: inline;width: 100px;" value="<?= date('H:i') ?>">
	    <small id="emailHelp" class="form-text text-muted"></small>
	</div>

	<div class="form-group">
	    <label>Комментарий</label>
	    <textarea required="" class="form-control" name="PREVIEW_TEXT"></textarea>
	    <small id="emailHelp" class="form-text text-muted"></small>
	</div>

	<button type="submit" class="btn-effect__js btn btn-primary" name="BTN_ADD">Создать услугу</button>
    </form>
</div>
<?
//l($arResult);
?>