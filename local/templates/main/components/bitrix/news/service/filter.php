<?php	
	include '_filter_init.php';
?>







<div class="row">
    <form action="" method="get" id="filter-form">
		<input type="hidden" name="sort" id="form-sort" value="">
		<?if(!$arParams['ALL_DATA_PAGE']):?>
		<div class="col-md-4">
			<? /*
				<div class="form-group" style="display: none">
				<label>Оказаны услуги</label>
				<select class="form-control" name="PROP[TYPE]">
				<option value="">Все</option>
				<option value="1" <?= $_REQUEST['PROP']['TYPE'] == 1 ? 'selected' : '' ?>>Услуга</option>
				<option value="2"<?= $_REQUEST['PROP']['TYPE'] == 2 ? 'selected' : '' ?>>Консультация</option>
				</select>
				</div>
			*/?>
			<div class="form-group">
				<?if(!$arParams['ALL_DATA_PAGE']):?>
				<label>Клиент</label>
				<select class="form-control" name='PROP[CLIENT]'	>
					<option value="">Все</option>
					<? foreach ($arClients as $client): ?>
					<option value=' <?= $client['ID'] ?>' <?= $_REQUEST['PROP']['CLIENT'] == $client['ID'] ? 'selected' : '' ?>><?= $client['PROPERTIES']['ORG_TYPE']['VALUE'] ?> <?= $client['NAME'] ?></option>
					<? endforeach ?>
				</select>
				<?endif?>
				<?if(!$isConsultPage):?>				
				<div class="form-check">
					<input class="form-check-input" type="checkbox" name="DATE_OPEN" id="DATE_OPEN" value="Y" <?= $_REQUEST['DATE_OPEN'] == 'Y' ? 'checked' : '' ?>>
					<label class="form-check-label" for="DATE_OPEN">
						Только открытые услуги
						<span class="input-help-text">При выбранных датах показываются только те услуги, 
						которые открыты в выбранный промежуток  </span>
					</label>
				</div>
				<?endif?>
				<div class="form-check">
					<input class="form-check-input" type="checkbox" name="CLIENT_UNIQ" id="CLIENT_UNIQ" value="Y" <?= $_REQUEST['CLIENT_UNIQ'] == 'Y' ? 'checked' : '' ?>>
					<label class="form-check-label" for="CLIENT_UNIQ">
						Только уникальные клиенты
					</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="checkbox" name="CLIENT_UNIQ_2" id="CLIENT_UNIQ_2" value="Y" <?= $_REQUEST['CLIENT_UNIQ_2'] == 'Y' ? 'checked' : '' ?>>
					<label class="form-check-label" for="CLIENT_UNIQ_2">
						Только уникальные клиенты за текущий год
						<span class="input-help-text">
							Чтобы считать уникальными с начала года.
						</span>
					</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="checkbox" name="CLIENT_UNIQ_3" id="CLIENT_UNIQ_3" value="Y" <?= $_REQUEST['CLIENT_UNIQ_3'] == 'Y' ? 'checked' : '' ?>>
					<label class="form-check-label" for="CLIENT_UNIQ_3">
						Уникальный за период существования агентства
					</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="checkbox" name="DATE_CLOSE" id="DATE_CLOSE" value="Y" <?= $_REQUEST['DATE_CLOSE'] == 'Y' ? 'checked' : '' ?>>
					<label class="form-check-label" for="DATE_CLOSE">
						Фильтр по дате закрытия
						<span class="input-help-text">
							При выбранных датах показываются только те услуги, 
							которые были закрыты в выбранный промежуток времени
						</span>
					</label>
					<br/><br/>
				</div>
			</div>
		<div class="form-group">	
			<div class="form-check">
				<input 
				class="form-check-input" 
				type="checkbox"  
				id="org_type_10" 
				name='PROP[ORG_TYPE][]' 
				value="<?= Client::ORG_TYPE_FIZ_ID ?>"
				<?= in_array(Client::ORG_TYPE_FIZ_ID, $_REQUEST['PROP']['ORG_TYPE']) ? 'checked' : '' ?>
				>
				<label class="form-check-label" for="org_type_10">
					Физ.лица
				</label>
			</div>
			
			<?/*
			<div class="form-check">
				<input 
				class="form-check-input" 
				type="checkbox"  
				id="org_type_16" 
				name='PROP[ORG_TYPE][]' 
				value="<?= Client::ORG_TYPE_SZ_ID ?>"
				<?= in_array(Client::ORG_TYPE_SZ_ID, $_REQUEST['PROP']['ORG_TYPE']) ? 'checked' : '' ?>
				>
				<label class="form-check-label" for="org_type_16">
					Самозанятые
				</label>
			</div>
			*/?>
			<?// теперь изем самозанятых по галке?>
			<div class="form-check">
				<input 
				class="form-check-input" 
				type="checkbox"  
				id="sz" 
				name='PROP[SZ][]' 
				value="17"
				<?= in_array(17, $_REQUEST['PROP']['SZ']) ? 'checked' : '' ?>
				>
				<label class="form-check-label" for="sz">
					Самозанятые
				</label>
			</div>
			
			
			<div class="form-check">
				<input 
				class="form-check-input" 
				type="checkbox"  
				id="org_type_3" 
				name='PROP[ORG_TYPE][]' 
				value="<?= Client::ORG_TYPE_INDIVIDUAL_ID ?>"
				<?= in_array(Client::ORG_TYPE_INDIVIDUAL_ID, $_REQUEST['PROP']['ORG_TYPE']) ? 'checked' : '' ?>
				>
				<label class="form-check-label" for="org_type_3">
					ИП
				</label>
			</div>
			<div class="form-check">
				<input 
				class="form-check-input" 
				type="checkbox" 
				id="org_type_4" 
				name='PROP[ORG_TYPE][]' 
				value="<?= Client::ORG_TYPE_OOO_ID ?>"
				<?= in_array(Client::ORG_TYPE_OOO_ID, $_REQUEST['PROP']['ORG_TYPE']) ? 'checked' : '' ?>
				>
				<label class="form-check-label" for="org_type_4">
					Юр Лицо
				</label>
			</div>
			
			<?/***Голубой клиент? 30.08.22***/?>
			<div class="form-check">
				<input 
				class="form-check-input" 
				type="checkbox"  
				id="blue_client" 
				name='PROP[BLUE_CLIENT][]' 
				value="22"
				>
				<label class="form-check-label" for="blue_client">
					Голубой клиент?
				</label>
			</div>
			<?/***СХ 20.03.23***/?>
			<div class="form-check">
				<input 
				class="form-check-input" 
				type="checkbox"  
				id="sx" 
				name='PROP[SX][]' 
				value="23"
				>
				<label class="form-check-label" for="sx">
					Сельское хозяйство
				</label>
			</div>
			
			<?/***Крупный бизнес? 05.11.25***/?>
			<div class="form-check">
				<input 
				class="form-check-input" 
				type="checkbox"  
				id="BIG_BUSINESS" 
				name='PROP[BIG_BUSINESS][]' 
				value="54"
				>
				<label class="form-check-label" for="BIG_BUSINESS">
					Крупный бизнес?
				</label>
			</div>
			<?/***Ветеран СВО/член семьи ветерана СВО? 05.11.25***/?>
			<div class="form-check">
				<input 
				class="form-check-input" 
				type="checkbox"  
				id="SVO" 
				name='PROP[SVO][]' 
				value="55"
				>
				<label style="display: inline;" class="form-check-label" for="SVO">
					Ветеран СВО/член семьи ветерана СВО?
				</label>
			</div>
			
			
			
			
		</div>
			
		</div>
		<?endif?>
		<div class=" <?=!$arParams['ALL_DATA_PAGE']?'col-md-3':'col-md-3'?>">
			<div class="form-group">
				<label>За какой период</label>
				<div class="period">
					<input class="form-control" type="date" name="DATE_FROM" value="<?= $_REQUEST['DATE_FROM'] ?>"> - 
					<input class="form-control" type="date" name="DATE_TO"  value="<?= $_REQUEST['DATE_TO'] ?>">
				</div>
				
			</div>
			
			<?if(!$arParams['ALL_DATA_PAGE']):?>
			<?if(!$isConsultPage):?>
			<div class="form-group">
				<label >Сумма (руб.) </label>
				<div class="period">
					<input class="form-control" type="number" name="MONEY_FROM" value="<?= $_REQUEST['MONEY_FROM'] ?>"> - 
					<input class="form-control" type="number" name="MONEY_TO"  value="<?= $_REQUEST['MONEY_TO'] ?>">
				</div>
			</div>
			<?endif?>
			<?endif?>
		</div>
		
		
		<div class="col-md-2">
			<div class="form-group">
				<label >Отдел</label>
				<select name="PROP[DIRECTION]" class="form-control"  id="client-departament-select-new" >
					<option value="" >Все</option>
					<? foreach ($arDirections as $id => $arr): ?> 
					<option value="<?= $arr['UF_XML_ID'] ?>" <?= $_REQUEST['PROP']['DIRECTION'] == $arr['UF_XML_ID'] ? 'selected' : '' ?>><?= $arr['UF_NAME'] ?></option>
					<? endforeach ?>
				</select>
			</div>
			
			<!-- sms -->
			<?if(!$arParams['ALL_DATA_PAGE']):?>
			<div class="form-group">
				<div class="form-check">
					<input class="form-check-input" type="checkbox" name="SMS_SEND" id="SMS_SEND" value="Y" <?= $_REQUEST['SMS_SEND'] == 'Y' ? 'checked' : '' ?>>
					<label class="form-check-label" for="SMS_SEND">
						Отправлено СМС
					</label>
					<br/><br/>
				</div>
				
				<label >SMS оценка</label>
				<div class="period">
					<input class="form-control" type="number" name="SMS_VOTE_FROM" value="" style="width:70px" min="0" max="10"> - 
					<input class="form-control" type="number" name="SMS_VOTE_TO"  value="" style="width:70px" min="0" max="10">
				</div>
			</div>
			<?endif?>
			<div class="form-group">
				<label>Категория МСП</label>
				<select class="form-control" name="PROP[MSP_TYPE]">
					<option value="">Все</option>
					<option value="18" <?= $_REQUEST['PROP']['MSP_TYPE'] == '18' ? 'selected' : '' ?>>микро</option>
					<option value="19" <?= $_REQUEST['PROP']['MSP_TYPE'] == '19' ? 'selected' : '' ?>>малое</option>
					<option value="20" <?= $_REQUEST['PROP']['MSP_TYPE'] == '20' ? 'selected' : '' ?>>среднее</option>
				</select>
			</div>
		</div>
		
		
		
		<div class="col-md-2">
			<div class="form-group">
				<label>Менеджер</label>
				<select class="form-control" name='PROP[MANAGER]'  id="clinet-manger-select" >
					<option value="">Все</option>
					<? foreach ($arManagers as $id => $user): ?>
					<option  
					group="<?=$user['UF_DIRECTIONS']?>" 
					value='<?= $id ?>' <?= $_REQUEST['PROP']['MANAGER'] == $id ? 'selected' : '' ?>> 
						<?= $user['LAST_NAME'] ?> <?= $user['NAME'] ?>
					</option>
					<? endforeach ?>
				</select>
			</div>
		</div>
		
		<div class="col-md-2">
		<div class="form-group">
				<label>Источник финансирования</label>
				<?
					$arINCOME = Helper::getFinanceSource();
					
				?>
				<select size="12" multiple class="form-control"  name="PROP[FINANCE_SOURCE][]">
					<option value="">Все</option>
					<?foreach($arINCOME as $t):?>
					<option <?= in_array($t, $_REQUEST['PROP']['FINANCE_SOURCE']) ? 'selected' : '' ?> value="<?=$t?>"><?=$t?></option>
					<?endforeach?>
				</select>
			</div>
			
			<div class="form-group">
				<label for="exampleFormControlSelect1">Реализована?</label>
				<select class="form-control" <? /*name="PROP[STATUS]"*/?> name="STATUS">
					<option value="">Все</option>
					<option value="work" <?= $_REQUEST['STATUS'] == "work" ? 'selected' : '' ?>>В работе</option>
					<option value="success" <?= $_REQUEST['STATUS'] ==  "success" ? 'selected' : '' ?>>Успешно завершена</option>
					<option value="failed" <?= $_REQUEST['STATUS'] ==  "failed" ? 'selected' : '' ?>>Не успешно завершена</option>
					<option value="done-no-done" <?= $_REQUEST['STATUS'] ==  "done-no-done" ? 'selected' : '' ?>>Не реализованные  и  реализованные </option>  
					<? /*
						<option value="2" <?= $_REQUEST['PROP']['STATUS'] == 2 ? 'selected' : '' ?>>Да</option>
						<option value="1" <?= $_REQUEST['PROP']['STATUS'] == 1 ? 'selected' : '' ?>>Нет</option>
					*/
					?>
				</select>
			</div>
			
			<div style="margin-top: 50px;">
				
				<button type="button" onclick="filterGetData()" class="btn btn-success btn-sm" >Фильтровать</button>
				<br/><br/>
				<button type="button" onclick="window.location.href = '<?= $arParams['SEF_FOLDER'] ?>'" class="btn btn-default btn-sm">Сбросить фильтр</button>
			</div>
			
			
		</div>
	</form>
</div>
