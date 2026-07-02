
<?
	/*
		* РЕДАКТИРОВАНИЕ КЛИЕНТА
	*/
	$arIndustry = Helper::getOrgIndustry();
	//l($arResult["CLIENT"]);
	l($_REQUEST['PROPERTY']['ORG_TYPE']);
?>
<div class="add-form-wrapper" style="width:100%;max-width: 100%">
	
    <div class="controls-top">
		<? if ($arResult["CLIENT"]): ?>
		<a href="/clients/<?= $arResult["CLIENT"]['ID'] ?>/"><i class="fa fa-user"></i> в карточку клиента</a>
		<? else: ?>
		<a href="/clients/"><i class="fa fa-arrow-left"></i>   в список клиентов</a>
		<? endif ?>
	</div>
    <? if ($arResult["CLIENT"]): ?>
	<h1>Редактирование клиента <?= $arResult["CLIENT"]['NAME'] ?> </h1>
    <? else: ?>
	<h1>Добавить клиента</h1>
    <? endif ?>
    <? if (!$arResult["CLIENT"]): ?>
	<div class="row">
		<div class="col-md-5"> <a  onclick="popupSelectClientFromBX24()">Выбрать клиента из битрикс 24</a></div>  
		
	</div>
    <? endif ?>
    <br>
	
	
	
    <form action="" enctype="multipart/form-data" method="post">
		<div class="row">
			<div class="col-md-9">
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
				<div class="form-group" >
					<label>Тип клиента: 
						<a class="fiz-ur-link fiz-link <?= $_REQUEST['PROPERTY']['ORG_TYPE'] == Client::ORG_TYPE_FIZ_ID ? 'active' : '' ?>" onclick="setFormType('fiz',<?= Client::ORG_TYPE_FIZ_ID ?>)">Физ. лицо</a>  
						<a class="fiz-ur-link ur-link <?= $_REQUEST['PROPERTY']['ORG_TYPE'] != Client::ORG_TYPE_FIZ_ID ? 'active' : '' ?>" 
						onclick="setFormType('ur',<?= $_REQUEST['PROPERTY']['ORG_TYPE'] == Client::ORG_TYPE_OOO_ID ? Client::ORG_TYPE_OOO_ID : Client::ORG_TYPE_INDIVIDUAL_ID ?>)">Юр. лицо</a>
					</label>
					
				</div>
				
				<? /*
					<input type="hidden"  class="input-BX24_COMPANY_ID"  name="PROPERTY[BX24_COMPANY_ID]">
					* 
				*/
				?>
				<input type="hidden"  class="input-ORG_TYPE"  name="PROPERTY[ORG_TYPE]" >
				<div class="form-group fiz-hide" style="position: relative">
					<label>ИНН</label>
					<input autocomplete="off" type="text" id="input-org-inn" class="form-control input-INN" name="PROPERTY[INN]" data-result="#sr-inn" class="ajax-search-inn"  placeholder="123456789" 
					value="<?= $_REQUEST['PROPERTY']['INN'] != '' ? $_REQUEST['PROPERTY']['INN'] : '' ?>">
					<div id="sr-inn" class="input-serach-result"></div>
				</div>
				
				<div class="form-group NAME-field" style="position: relative">
					<label >Название ИП или организации</label>
					<input autocomplete="off" type="text"  class="form-control input-NAME" id="input-org-name" name="NAME"  data-result="#sr-name" 
					placeholder="" 
					value='<?= $_REQUEST['NAME'] ?>'
					>
					<small id="emailHelp" class="form-text text-muted"></small>
					<div id="sr-name" class="input-serach-result"></div>
				</div>
				
				<div class="org-info fiz-hide" style="xdisplay: none">
					<div class="form-group">
						<label>ОГРН</label>
						<input autocomplete="off" type="text" id="input-OGRN" class="form-control input-OGRN" name="PROPERTY[OGRN]"  placeholder="123456789" 
						value="<?= $_REQUEST['PROPERTY']['OGRN'] != '' ? $_REQUEST['PROPERTY']['OGRN'] : '' ?>" >
						<small id="emailHelp" class="form-text text-muted"></small>
					</div>
					
					<div class="form-group">
						<label>ЮР. АДРЕС</label>
						<input autocomplete="off" type="text" value="<?= $_REQUEST['PROPERTY']['ADDRESS'] != '' ? $_REQUEST['PROPERTY']['ADDRESS'] : '' ?>" id="input-ADDRESS" class="form-control input-ADDRESS" name="PROPERTY[ADDRESS]"  placeholder="г.Москва, Ивановых 36, корпус 1">
						<small id="emailHelp" class="form-text text-muted"></small>
					</div>
					
					<? /*
						<div class="form-group fiz-hide">
						<label>МСП <input type="checkbox" name="PROPERTY[MSP]" value="1" <?= $_REQUEST['PROPERTY']['MSP'] != '' ? 'checked' : '' ?>></label>
						
						<small id="emailHelp" class="form-text text-muted"></small>
						</div>
					*/ ?>
					
					<div class="form-group fiz-hide">
						<label>ОКВЭД</label>
						<input type="text" class="form-control input-OKVED"  name="PROPERTY[OKVED]" placeholder="" 
						value="<?= $_REQUEST['PROPERTY']['OKVED'] != '' ? $_REQUEST['PROPERTY']['OKVED'] : '' ?>" >
						<small id="emailHelp" class="form-text text-muted"></small>
					</div>
				</div>
				<?
					$arDEPARTMENT = Helper::getListValue(Client::CLIENT_IBLOCK_ID, 'DEPARTMENT');
					//l($arDEPARTMENT);
				?>
				
				<div class="row">
				<div class="col-md-6 form-group">
					<label>Направление</label>
					<select name="PROPERTY[DEPARTMENT]" class="form-control" >
						<option value="" >Выберите направление</option>
						<? foreach ($arDEPARTMENT as $id => $val): ?> 
						<option value="<?= $id ?>" <?= $_REQUEST['PROPERTY']['DEPARTMENT'] == $id ? 'selected' : '' ?>><?= $val['VALUE'] ?></option>
						<? endforeach ?>
					</select>	   
				</div>
				<? //l($_REQUEST['PROPERTY']['INDUSTRY'])?>
				
				<div class="col-md-6 form-group">
					<label>Сфера деятельности</label>
					<select name="PROPERTY[INDUSTRY]" class="form-control" >
						<option value="" >Выберите сферу деятельности</option>
						<? foreach ($arIndustry as $id => $name): ?> 
						<option value="<?= $id ?>" <?= $_REQUEST['PROPERTY']['INDUSTRY']['ID'] == $id ? 'selected' : '' ?>><?= $name ?></option>
						<? endforeach ?>
					</select>	   
				</div>
				</div>
				<div class="form-section-contacts form-group">
					<label>Контакт руководителя</label>
					<div class="row">
						<div class="col-md-4 fiz-hide ooo-user-name-field">
							<input style="min-width:300px;" autocomplete="off" type="text" class="form-control"  name="PROPERTY[CONTACT_NAME]"  placeholder="Имя"
							value="<?= $_REQUEST['PROPERTY']['CONTACT_NAME'] != '' ? $_REQUEST['PROPERTY']['CONTACT_NAME'] : '' ?>">
						</div>
						<div class="col-md-3">
							<input  autocomplete="off" type="text" class="form-control input-phone-mask"  name="PROPERTY[PHONE]"  placeholder="Телефон"
							value="<?= $_REQUEST['PROPERTY']['PHONE'] != '' ? $_REQUEST['PROPERTY']['PHONE'] : '' ?>" >
						</div>
						<div class="col-md-3">
							<input autocomplete="off" type="email" class="form-control"  name="PROPERTY[EMAIL]"  placeholder="email"
							value="<?= $_REQUEST['PROPERTY']['EMAIL'] != '' ? $_REQUEST['PROPERTY']['EMAIL'] : '' ?>" >
						</div>
						<div class="col-md-2">
							<input autocomplete="off" type="text" class="form-control"  name="PROPERTY[CONTACT_POST]"  placeholder="должность"
							value="<?= $_REQUEST['PROPERTY']['CONTACT_POST'] != '' ? $_REQUEST['PROPERTY']['CONTACT_POST'] : '' ?>" >
						</div>
					</div>
					
					<div class="client-contact-wrap">
						<?
							if($arResult["CLIENT"]['ID']){
								$contactsArr = Contact::getClientContacts($arResult["CLIENT"]['ID']);
							}
						?>
						<? if($arResult["CLIENT"]['ID']):?>
						
						<?if($contactsArr):?>
						<div class="title">Дополнительные контакты</div>
						<?foreach($contactsArr as $contact):?>
						<div class="contacts-list row">
							<div class="col-md-3">
								<input requred style="min-width:200px;" autocomplete="off" type="text" class="form-control"  name="CONTACT[NAME][]"   value="<?=$contact['NAME']?>" placeholder="Иванов Иван Иванович" >
							</div>

							<div class="col-md-3">
								<input requred  autocomplete="off" type="text" class="form-control input-phone-mask"  name="CONTACT[PHONE][]" value="<?=$contact['PHONE']?>" placeholder="+7 --- --- -- --" >
							</div>
							<div class="col-md-3">
								<input requred autocomplete="off" type="email" class="form-control"  name="CONTACT[EMAIL][]" value="<?=$contact['EMAIL']?>"  placeholder="ivanoff@mail.ru">
							</div>
							
	
	                       <div class="col-md-2">
								<input  type="text" class="form-control"  name="CONTACT[PREVIEW_TEXT][]" value="<?=$contact['PREVIEW_TEXT']?>" placeholder="Должность" >
							</div>
							<div class="col-md-1">						  
								<input  type="checkbox" class=""  name="CONTACT[ACTIVE][]" value="N"  title="Удалить контакт">
								<span title="Удалить контакт" style="position: absolute;margin-left: 5px; color: red;">x </span>
							</div>
						</div>
						<?endforeach?>
						<?endif?>
						<?endif?>
						<a   class="add-contact-a" onclick="addContacts()">+ Добавить контакт</a>
						<div id="contacts-items" style="display:none">
							<div class="row">
								<div class="col-md-5 fiz-hide ooo-user-name-field">
									<input requred style="min-width:300px;" autocomplete="off" type="text" class="form-control"  name="CONTACT[NAME][]"   placeholder="Иванов Иван Иванович" >
								</div>
								<div class="col-md-3">
									<input  requred autocomplete="off" type="text" class="form-control input-phone-mask"  name="CONTACT[PHONE][]" placeholder="+7 --- --- -- --" >
								</div>
								<div class="col-md-2">
									<input autocomplete="off" type="email" class="form-control"  name="CONTACT[EMAIL][]"  placeholder="ivanoff@mail.ru">
								</div>
								<div class="col-md-2">
									<input autocomplete="off" type="text" class="form-control"  name="CONTACT[PREVIEW_TEXT][]"  placeholder="Должность">
								</div>
							</div>
						</div>
					</div>
				</div>
				
				
				<div class="form-group">
					<input type="hidden" id="input-manager-id" class="form-control" name="PROPERTY[MANAGER]" value="<?= $arResult["MANAGER"]['USER_ID'] ?>">
					<label>Менеджер</label>
					<span id="input-manager-name"><?= $arResult["MANAGER"]['FIO'] ?></span>
					<a style="cursor: pointer" onclick="popupChangeManager('setManager')">Сменить</a>
				</div>
				
				<div class="form-group">
					<label>Описание</label>
				<textarea  class="form-control" name="PREVIEW_TEXT"><?= $_REQUEST['PREVIEW_TEXT'] ?></textarea>
				</div>
				<div class="form-group">
				<label>Откуда пришел</label>
				<textarea  class="form-control" name="PROPERTY[SOURCE_OF_INCOME]"><?= $_REQUEST['PROPERTY']['SOURCE_OF_INCOME'] != '' ? $_REQUEST['PROPERTY']['SOURCE_OF_INCOME'] : '' ?></textarea>
				</div>
				
				<? if ($arResult["CLIENT"]): ?>
				<button type="submit" class="btn btn-success" name="BTN_SAVE">Сохранить</button>
				<button type="submit" class="btn btn-primary" name="BTN_UPDATE">Обновить</button>
				<? else: ?> 
				<button type="submit" class="btn btn-success" name="BTN_SAVE">Добавить</button>
				<button type="submit" class="btn btn-primary"  name="BTN_ADD_AND_ADD_SERVICE">Добавить и создать услугу</button>
				<button type="submit" class="btn btn-primary"  name="BTN_ADD_AND_ADD_CONSALT">Добавить и создать консультацию</button>
				<? endif ?>
				
				
				
				</div>
				<div class="col-md-3">
				
				<? if ($arResult["CLIENT"]['PREVIEW_PICTURE']['SRC']) {
				?>
				     <img src="<?= $arResult["CLIENT"]['PREVIEW_PICTURE']['SRC'] ?>" class="client-image" style="max-width: 300px">
					 <br/>
				<label>
				Удалить фото:
				<input type="checkbox" name="PREVIEW_PICTURE_DELETE" value="Y" onclick="checkboxRemovePhotoEvent()">
				</label>
				<br/>
				<?
				}
				?>
				<input type="file" name="file">
				
				</div>
				
				</div>
				
				
				
				</form>
				<? //l($_REQUEST) ?>
				</div>
				<?
				//l($arResult);
				?>
								