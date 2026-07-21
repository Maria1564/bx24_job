
<?
	/*
		* РЕДАКТИРОВАНИЕ КЛИЕНТА
	*/
	$arIndustry = Helper::getOrgIndustry();
//	l($arResult['CLIENT']);
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
						<a class="fiz-ur-link fiz-link <?= $_REQUEST['PROPERTY']['ORG_TYPE'] == Client::ORG_TYPE_FIZ_ID&& $arResult['CLIENT']["PROPERTIES"]['SZ']['VALUE'] != 'Y' ? 'active' : '' ?>" 
						onclick="setFormType('fiz',<?= Client::ORG_TYPE_FIZ_ID ?>)">Физлицо</a>  
						<a class="fiz-ur-link ur-link <?= $_REQUEST['PROPERTY']['ORG_TYPE'] != Client::ORG_TYPE_FIZ_ID ? 'active' : '' ?>" 
						onclick="setFormType('ur',<?= Client::ORG_TYPE_OOO_ID ?>)">Юрлицо</a>
						<?// NEW IP?>
						<a class="fiz-ur-link ip-link <?= $_REQUEST['PROPERTY']['ORG_TYPE'] == 4 ? 'active' : '' ?>" onclick="setFormType('ip',<?=Client::ORG_TYPE_INDIVIDUAL_ID?>)">ИП</a>
						<a class="fiz-ur-link sz-link <?= $_REQUEST['PROPERTY']['ORG_TYPE'] == 16 ? 'active' : '' ?>" onclick="setFormType('sz',16)">Самозанятый</a>
						<?/*
							<a class="fiz-ur-link sz-link <?= $arResult['CLIENT']["PROPERTIES"]['SZ']['VALUE'] == 'Y' ? 'active' : '' ?>" onclick="setFormType('sz',16)">Самозанятый</a>
						*/?>						
					</label>

				</div>	
				
					<div id="sz_block_hide" class="form-group BLUE-field" style="position: relative ;<?if($_REQUEST['PROPERTY']['ORG_TYPE'] == 4):?> display:block;<?endif?>">
						<label>Самозанятый?</label>
						<input type="checkbox" name="PROPERTY[SZ]" <?if($_REQUEST['PROPERTY']['SZ']==17):?>checked<?endif?> value="Y">
					</div>
				
				
				<? /*
					<input type="hidden"  class="input-BX24_COMPANY_ID"  name="PROPERTY[BX24_COMPANY_ID]">
					* 
				*/
				?>
				<input type="hidden"  class="input-ORG_TYPE"  name="PROPERTY[ORG_TYPE]" >
				<?/*<input type="hidden"  class="input-SZ"  name="PROPERTY[SZ]" value="<?=$arResult['CLIENT']["PROPERTIES"]['SZ']['VALUE_ENUM_ID'] ?>">*/?>
				<div class="form-group fiz-hide sz-show" style="position: relative">
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
				
				
				<div class="form-group" style="position: relative">
					<label>Общий контакт клиента</label>
					<div class="row">
						<div class="col-md-4 чfiz-hide ooo-user-name-field">
							<input style="min-width:300px;" autocomplete="off" type="text" class="form-control"  name="PROPERTY[CONTACT_NAME]"  placeholder="Имя"
							value="<?= $_REQUEST['PROPERTY']['CONTACT_NAME'] != '' ? $_REQUEST['PROPERTY']['CONTACT_NAME'] : '' ?>">
						</div>
						<div class="col-md-3">
							<input  autocomplete="off" type="text" class="form-control  input-phone-mask-new"  name="PROPERTY[PHONE]"  placeholder="Телефон"
							value="<?= $_REQUEST['PROPERTY']['PHONE'] != '' ? $_REQUEST['PROPERTY']['PHONE'] : '' ?>" >
						</div>
						<div class="col-md-3">
							<input autocomplete="off" type="email" class="form-control"  name="PROPERTY[EMAIL]"  placeholder="email"
							value="<?= $_REQUEST['PROPERTY']['EMAIL'] != '' ? $_REQUEST['PROPERTY']['EMAIL'] : '' ?>" >
						</div>
						<?/*
						<div class="col-md-2">
							<input autocomplete="off" type="text" class="form-control"  name="PROPERTY[CONTACT_POST]"  placeholder="должность"
							value="<?= $_REQUEST['PROPERTY']['CONTACT_POST'] != '' ? $_REQUEST['PROPERTY']['CONTACT_POST'] : '' ?>" >
						</div>
						*/?>
					</div>
				</div>
				<div>
					<div class="form-group">
						<div class="row">
							<?
								$arRAION_NEW = Helper::getListValue(Client::CLIENT_IBLOCK_ID, 'RAION_NEW');
								//l($arMSP_TYPE);
							?>
							<div class="col-12 col-md-3 form-group">
								<label>Регион</label>
								<select required name="PROPERTY[RAION_NEW]" class="form-control" >
									<option value="" >Выберите регион</option>
									<? foreach ($arRAION_NEW as $id => $val): ?> 
									<option value="<?= $id ?>" <?= $_REQUEST['PROPERTY']['RAION_NEW'] == $id ? 'selected' : '' ?>><?= $val['VALUE'] ?></option>
									<? endforeach ?>
								</select>	   
							</div>
						</div>	
					</div>
				</div>
				
				
				
				<div class="form-group BLUE-field" style="position: relative">
					<label>Креативный предприниматель?</label>
					<input type="checkbox" name="PROPERTY[KREATIV]" <?if($_REQUEST['PROPERTY']['KREATIV']==57):?>checked<?endif?> value="Y">
				</div>
				
				
				<? include '_org-info.php'?>
				
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
						<label>Реальная деятельность</label>
						<select name="PROPERTY[INDUSTRY]" class="form-control" >
							<option value="" >Выберите  значение</option>
							<? foreach ($arIndustry as $id => $name): ?> 
							<option value="<?= $id ?>" <?= $_REQUEST['PROPERTY']['INDUSTRY']['ID'] == $id ? 'selected' : '' ?>><?= $name ?></option>
							<? endforeach ?>
						</select>	   
					</div>
				</div>
				
				<? include '_contacts.php'?>
				
				
				
				<div class="form-group">
					<input required="" style="opacity: 0;height: 1px;width: 300px;" type="text" id="input-manager-id" class="form-control" name="PROPERTY[MANAGER]" value="<?= $arResult["MANAGER"]['USER_ID'] ?>">
					<label>Менеджер*</label>
					<span id="input-manager-name"><?= $arResult["MANAGER"]['FIO'] ?></span>
					<a style="cursor: pointer" onclick="popupChangeManager('setManager')">Сменить</a>
				</div>
				
				<div class="form-group">
					<label>Описание</label>
					<textarea  class="form-control" name="PREVIEW_TEXT"><?= $_REQUEST['PREVIEW_TEXT'] ?></textarea>
				</div>
				<div class="form-group">
					<?
						$arINCOME = Helper::getIncomings();
						
					?>
					<label>Откуда пришел</label>
					<select  name="PROPERTY[SOURCE_OF_INCOME]" class="form-control" required="">
					<option  value="">Выберите значение</option>
						<?foreach($arINCOME as $t):?>
						<option <?= $_REQUEST['PROPERTY']['SOURCE_OF_INCOME'] == $t ? 'selected' : '' ?> value="<?=$t?>"><?=$t?></option>
						<?endforeach?>
					</select>
					<? /*
					<textarea  class="form-control" name="PROPERTY[SOURCE_OF_INCOME]"><?= $_REQUEST['PROPERTY']['SOURCE_OF_INCOME'] != '' ? $_REQUEST['PROPERTY']['SOURCE_OF_INCOME'] : '' ?></textarea>
					*/?>
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
