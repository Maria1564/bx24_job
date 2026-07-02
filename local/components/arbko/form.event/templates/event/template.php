<script>
	app.managers = <?= CUtil::PhpToJSObject(Helper::getManagers()) ?>;
</script>


<ul class="s-ul-2">
	<li><a href="/event/"><i class="fa fa-arrow-left"></i> В список мероприятий</a></li>
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
			<label>Название мероприятия</label>
			<input  type="text" required="" class="form-control" name="NAME" class="ajax-search-inn"  placeholder="Название мероприятия" value="<?= $_REQUEST['NAME'] != '' ? $_REQUEST['NAME'] : '' ?>">
		</div>
		
		<? //Направление ?>
		<? //include '_direction_section.php'?>
		
		
		
		
		
		
		<? //Денег получено (прямая поддержка) ?>
		<? //include '_money_section.php'?>
		
		<div class="form-group" style="display:none">
			<label>Задача в битрикс24</label>
			
			<a id="bx24_task_link" style="cursor: pointer;  <?=$_REQUEST["PROPERTY"]['BX24_TASK_ID'] > 0?'':'display:none'?>" href="https://arbko.bitrix24.ru/company/personal/user/6/tasks/task/view/<?=$_REQUEST["PROPERTY"]['BX24_TASK_ID']?>/" target="_blank">услуга привязана к задаче в arbko.bitrix24.ru</a>
			
			<a id="bx24_task_link_btn" style="cursor: pointer; <?=$_REQUEST["PROPERTY"]['BX24_TASK_ID'] > 0?'display:none':''?>" onclick="selectTaskBx24()">Привязать задачу</a>
			
			
			<input type="hidden" id="input-BX24_TASK_ID" class="form-control" name="PROPERTY[BX24_TASK_ID]" value="<?= $_REQUEST["PROPERTY"]['BX24_TASK_ID'] ?>">	
		</div>
		
		
		<? include '_date_section.php'?>
		
		<? //include '_bottom_section.php'?>
		
		
		
		<div class="form-group">
			<label>Описание мероприятия</label>
			<textarea  class="form-control" name="PREVIEW_TEXT"><?= $_REQUEST['PREVIEW_TEXT'] != '' ? $_REQUEST['PREVIEW_TEXT'] : '' ?></textarea>
			<small id="emailHelp" class="form-text text-muted"></small>
		</div>
		
		<div class="">
			<p>Для кого: </p>
			<div class="form-group">	
				<div class="form-check">
					<input 
					class="form-check-input" 
					type="checkbox"  
					id="org_type_10" 
					name='PROP[ORG_TYPE][]' 
					value="52"
					<?= in_array('Физические лица', $_REQUEST['PROPERTY']['ORG_TYPE']) ? 'checked' : '' ?>
					>
					<label class="form-check-label" for="org_type_10">
						Физ.лица
					</label>
				</div>

				<div class="form-check">
					<input 
					class="form-check-input" 
					type="checkbox"  
					id="sz" 
					name='PROP[ORG_TYPE][]' 
					value="51"
					<?= in_array('Самозанятые', $_REQUEST['PROPERTY']['ORG_TYPE']) ? 'checked' : '' ?>
					>
					<label class="form-check-label" for="sz">
						Самозанятые
					</label>
				</div>
				<div class="form-check">
					<input 
					class="form-check-input" 
					type="checkbox" 
					id="org_type_4" 
					name='PROP[ORG_TYPE][]' 
					value="53"
					<?= in_array('Юр.лица', $_REQUEST['PROPERTY']['ORG_TYPE']) ? 'checked' : '' ?>
					>
					<label class="form-check-label" for="org_type_4">
						Юр Лица
					</label>
				</div>
			
				
			</div>
		</div>
		
		<div class="form-section row" id="cont_items">
			<div class="form-group" style="display:flex;border-bottom: solid 1px;padding-bottom: 20px">
				<div style="margin-right:30px;">
					<label>Клиент: </label>
					<span id="client-link" href="/clients/<?= $arResult['CLIENT']['ID'] ?>/" target="_blank"><?= $arResult['CLIENT']['TYPE_NAME_INN'] ?></span>    
					<input id="client-input-id" type="hidden" class="form-control" name="PROPERTY[CLIENT]" value="<?= $arResult['CLIENT']['ID'] ?>">
					<a  onclick="client.formSearchClientOpen()">Выбрать</a>
				</div>
				<div>
					<label>Контакт</label>
					<select class="form-control" id="select_contact" name="PROPERTY[CONTACT][]">
					
					</select>
				</div>
			</div>
			<a style="display: inline-block;padding: 10px;background-color: #4AA14A;color: #ffff;text-decoration: none;" class="add-contact-a" onclick="addContacts()">+ Добавить контакт</a>	
			
			
			<?if(CSite::InDir('/event/edit/')):?>
				<?
				$list_contacts_id = $arResult["CLIENT"]["PROPERTIES"]["CONTACT"]["VALUE"];
				$contacts = Contact::getClientContactsId($idContact = $arResult["CLIENT"]["PROPERTIES"]["CONTACT"]["VALUE"]);
				?>
				<?if($contacts):?>
					<?foreach($contacts as $contact):?>
						<?$client = Client::getClientById($contact["CLIENT"]);?>
						<?
						$cl_contacts = Contact::getClientContacts($client["ID"]);
						?>
						<div class="form-group" style="display:flex;border-bottom: solid 1px;padding-bottom: 20px;margin-top:30px;position:relative;">
							<div style="margin-right:30px;">
								<label>Клиент: </label>
								<span id="client-link" href="/clients/<?= $client["ID"] ?>/" target="_blank"><?= $client["NAME"] ?></span>    
								<input id="client-input-id" type="hidden" class="form-control" name="PROPERTY[CLIENT]" value="<?= $arResult['CLIENT']['ID'] ?>">
							</div>
							<div>
								<label>Контакт</label>
								<select class="form-control" id="select_contact" name="PROPERTY[CONTACT][]">
									<?foreach($cl_contacts as $cont):?>
									<?
									// указываем выбранный контакт
									?>
									<option <?if($cont["ID"] == $contact["ID"] ):?>selected<?endif?> value="<?=$cont["ID"]?>"><?=$cont["NAME"]?></option>*/?>
									<?/*<option <?if(in_array($cont["ID"], $list_contacts_id)):?>selected<?endif?> value="<?=$cont["ID"]?>"><?=$cont["NAME"]?></option>*/?>
									<?
									if(in_array($cont["ID"], $list_contacts_id)):
										$list_contacts_id = array_diff($list_contacts_id, array($cont["ID"]));
									endif;
									?>
									
									<?endforeach?>
								</select>
							</div>
							<div style="position: absolute;right: 10px;" onclick="delContact(this)"><span style="padding: 10px;background-color: #DF5151;color: #fff;cursor: pointer;">Удалить</span></div>
						</div>
					<?endforeach?>
				<?endif?>
			<?endif?>
			
		</div>	
		
		<?/*
		<?if($contacts):?>
			<div class="contacts">
			<p>Текущие участники:</p>
			<?foreach($contacts as $contact):?>
				<?$client = Client::getClientById($contact["CLIENT"]);?>
				<div style="-webkit-box-shadow: 4px 8px 8px 0px rgba(34, 60, 80, 0.2);-moz-box-shadow: 4px 8px 8px 0px rgba(34, 60, 80, 0.2);box-shadow: 4px 8px 8px 0px rgba(34, 60, 80, 0.2);padding: 40px;background: #fff;border-radius: 10px;margin-bottom:20px;
				display:flex;flex-wrap:wrap;justify-content:space-between;">
					<div>
						<a href="/clients/<?=$client["ID"]?>/"><?=$client["NAME"]?></a>
						<p style="margin-top:10px;"><span style="font-weight:bold;"><?=$contact["NAME"]?></span></p>
						<p><?=$contact["PREVIEW_TEXT"]?></p>
					</div>
					<div>
						<div>Телефон: <span style="font-weight:bold;"><?=$contact["PHONE"]?></span></div>
						<div>Почта: <span style="font-weight:bold;"><?=$contact["EMAIL"]?></span></div>
					</div>
				</div>
			<?endforeach?>
			</div>
		<?endif?>
		*/?>
		
		
		<?/*
		<div id="contacts-items" style="display:none">
			<div class="form-section row">
				<div class="form-group" style="display:flex;padding-bottom: 20px">
					<div style="margin-right:30px;">
						<label>Клиент: </label>
						<span id="client-link" href="/clients/<?= $arResult['CLIENT']['ID'] ?>/" target="_blank"><?= $arResult['CLIENT']['TYPE_NAME_INN'] ?></span>    
						<input id="client-input-id" type="hidden" class="form-control" name="PROPERTY[CLIENT]" value="<?= $arResult['CLIENT']['ID'] ?>">
						<a  onclick="client.formSearchClientOpen()">Выбрать</a>
					</div>
					<div>
						<label>Контакт</label>
						<select class="form-control" id="select_contact" name="PROPERTY[CONTACT]">
						
						</select>
					</div>
				</div>
			</div>
		</div>
		*/?>
		
		
		<?
		//print_r($arResult["CLIENT"]["PROPERTIES"]["CONTACT"]["VALUE"]);
		?>
		
		
		
		<? if ($_REQUEST['id'] > 0): ?>
		<button type="submit" class="btn-effect__js btn btn-primary" name="BTN_UPDATE">Обновить мероприятие</button>
		<? else: ?>
		<button type="submit" class="btn-effect__js btn btn-primary" name="BTN_ADD">Создать мероприятие</button>
		<? endif ?>
		
	</form>
</div>
<?/*
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
*/?>