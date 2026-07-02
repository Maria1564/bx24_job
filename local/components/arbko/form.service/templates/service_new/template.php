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
			<input type="hidden" id="input-manager-id" class="form-control" name="PROPERTY[MANAGER]" value="<?= $arResult["MANAGER"]['USER_ID'] ?>">
			<label>Менеджер: </label>
			<span id="input-manager-name"><?= $arResult["MANAGER"]['FIO'] ?></span>
			<a style="cursor: pointer" onclick="popupChangeManager('setManager')">Сменить</a>
		</div>
		
		
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
			onclick="alert('Название услуги формируется из направления и услуги');$('select[name=\'PROPERTY[DIRECTION]\']').focus()"
		    value="<?= $_REQUEST['NAME'] != '' ? $_REQUEST['NAME'] : '' ?>"
		    >
		</div>
		
		<? //Направление ?>
		<? include '_direction_section.php'?>
		
		
		
		
		
		
		<? //Денег получено (прямая поддержка) ?>
		<? include '_money_section.php'?>
		
		<div class="form-group" style="display:none">
			<label>Задача в битрикс24</label>
			
			<a id="bx24_task_link" style="cursor: pointer;  <?=$_REQUEST["PROPERTY"]['BX24_TASK_ID'] > 0?'':'display:none'?>" href="https://arbko.bitrix24.ru/company/personal/user/6/tasks/task/view/<?=$_REQUEST["PROPERTY"]['BX24_TASK_ID']?>/" target="_blank">услуга привязана к задаче в arbko.bitrix24.ru</a>
			
			<a id="bx24_task_link_btn" style="cursor: pointer; <?=$_REQUEST["PROPERTY"]['BX24_TASK_ID'] > 0?'display:none':''?>" onclick="selectTaskBx24()">Привязать задачу</a>
			
			
			<input type="hidden" id="input-BX24_TASK_ID" class="form-control" name="PROPERTY[BX24_TASK_ID]" value="<?= $_REQUEST["PROPERTY"]['BX24_TASK_ID'] ?>">	
		</div>
		
		
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
<div type="html/tpl" id="service-task-bx24-template" style="display: none">
    <div>
		<form action="/api/bx24/service/search.php" class="form" onsubmit="formSubmitHandler(this, service.searchSubmitHandler);return false">
			<input type="hidden" name="CLIENT_ID" value="<?= $_REQUEST['client_id'] ?>">
			<input type="text" class="" style="min-width: 387px;padding: 5px;" name="q" placeholder="Введите название задачи">
			<button class="send btn btn-success" >поиск</button>
		</form>
		<div class="form-result"></div>
	</form> 
</div>
</div>