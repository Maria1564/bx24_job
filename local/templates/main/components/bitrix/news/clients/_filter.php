
<form action="" method="get" id="filter-form" onsubmit="filterGetData();return false;">
    <input type="hidden" name="sort" id="form-sort" value="">
	
    <div class="form-group search-text-wrap">
		<input type="text" class="form-control" name="t" value="<?= $_REQUEST['t'] ?>" placeholder="Поиск">
	</div>
    <div class="row">
		<div class="col-md-2">
			<div class="form-group" style="display:none">
				<label for="exampleFormControlSelect1">Фильтр по деятельности</label>
				<select class="form-control" name='PROP[INDUSTRY]'>
					<option value="">Все</option>
					<? foreach ($arIndustry as $id => $client): ?>
					<option value='<?= $id ?>' <?= $_REQUEST['PROP']['INDUSTRY'] == $id ? 'selected' : '' ?>> 
						<?= $client ?>
					</option>
					<? endforeach ?>
				</select>
			</div>
			
			<div class="form-group">
                <label>ОКВЭД</label>
                <input
                    type="text"
                    class="form-control"
                    name="PROP[OKVED]"
                    value="<?= htmlspecialchars($_REQUEST['PROP']['OKVED']) ?>"
                    placeholder="Например 47.11"
                >
            </div>
			
		</div>
		<div class="col-md-2">
		
			<div class="form-group">
				<label for="">Фильтр по району</label>
				<select class="form-control" name='PROP[RAION_NEW]'>
					<option value="">Все</option>
					<? foreach ($arRAION_NEW as $id => $regionArr): ?>
					<option value='<?= $id ?>' <?= $_REQUEST['PROP']['RAION_NEW'] == $id ? 'selected' : '' ?>> 
						<?= $regionArr['VALUE'] ?>
					</option>
					<? endforeach ?>
				</select>
			</div>

			
			<?/*
			<div class="form-group" style="display:none">
				<label for="">Фильтр по району</label>
				<select class="form-control" name='PROP[REGION]'>
					<option value="">Все</option>
					<? foreach ($arRegions as $id => $regionArr): ?>
					<option value='<?= $id ?>' <?= $_REQUEST['PROP']['REGION'] == $id ? 'selected' : '' ?>> 
						<?= $regionArr['NAME'] ?>
					</option>
					<? endforeach ?>
				</select>
			</div>
			*/?>
			
			<div class="form-check">
				<input class="form-check-input" type="radio" name="MSP" id="MSP1" value="" <?= $_REQUEST['MSP'] == '' ? 'checked' : '' ?>>
				<label class="form-check-label" for="MSP1">
					Все
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="MSP" id="MSP2" value="Y" <?= $_REQUEST['MSP'] == 'Y' ? 'checked' : '' ?>>
				<label class="form-check-label" for="MSP2">
					МСП
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="MSP" id="MSP3" value="N" <?= $_REQUEST['MSP'] == 'N' ? 'checked' : '' ?>>
				<label class="form-check-label" for="MSP3">
					Не МСП
				</label>
			</div>
			
			<div class="form-check">
				<input 
				class="form-check-input" 
				type="checkbox"  
				id="KREATIV" 
				name='PROP[KREATIV][]' 
				value="57"
				>
				<label style="display: inline;" class="form-check-label" for="KREATIV">
					Креативный предприниматель?
				</label>
			</div>
			
			
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
			
			<div class="form-check">
				<input class="form-check-input" type="radio" name="INN" id="INN1" value="" <?= $_REQUEST['INN'] == '' ? 'checked' : '' ?>>
				<label class="form-check-label" for="INN1">
					Все
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="INN" id="INN2" value="Y" <?= $_REQUEST['INN'] == 'Y' ? 'checked' : '' ?>>
				<label class="form-check-label" for="INN2">
					Только с ИНН
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="INN" id="INN3" value="N" <?= $_REQUEST['INN'] == 'N' ? 'checked' : '' ?>>
				<label class="form-check-label" for="INN3">
					Без ИНН
				</label>
			</div>
			
			
			
			
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="exampleFormControlSelect1">Менеджер</label>
				<select class="form-control" name='PROP[MANAGER]' id="clinet-manger-select">
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
			
			<?/*
			<div class="form-check">
				<input 
				class="form-check-input" 
				type="checkbox"  
				id="org_type_1" 
				name='PROP[ORG_TYPE][]' 
				value="<?= Client::ORG_TYPE_KFX_ID ?>"
				<?= in_array(Client::ORG_TYPE_KFX_ID, $_REQUEST['PROP']['ORG_TYPE']) ? 'checked' : '' ?>
				>
				<label class="form-check-label" for="org_type_1">
					КФХ
				</label>
			</div>

			<div class="form-check">
				<input 
				class="form-check-input" 
				type="checkbox"  
				id="org_type_2" 
				name='PROP[ORG_TYPE][]' 
				value="<?= Client::ORG_TYPE_OTHER_ID ?>"
				<?= in_array(Client::ORG_TYPE_OTHER_ID, $_REQUEST['PROP']['ORG_TYPE']) ? 'checked' : '' ?>
				>
				<label class="form-check-label" for="org_type_2">
					Иное
				</label>
			</div>
			*/?>
			
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
			
			<?/* теперь изем самозанятых по галке?>
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
			*/?>
			
			
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
			
			
			<div class="form-check" id="plus_samoz" style="left: 16px;position: relative;font-size: 13px; 
				<?if(in_array(Client::ORG_TYPE_INDIVIDUAL_ID, $_REQUEST['PROP']['ORG_TYPE'])):?> display:block;<?endif?>">
				<input 
				class="form-check-input" 
				type="checkbox"  
				id="sz" 
				name='PROP[SZ][]' 
				value="17"
				<?= in_array(17, $_REQUEST['PROP']['SZ']) ? 'checked' : '' ?>
				>
				<label class="form-check-label" for="sz">
					+ Самозанятые
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
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label>Статус клиента</label>
				<select class="form-control" name="WORK_STATUS">
					<option value="">Все</option>
					<option value="1" <?= $_REQUEST['WORK_STATUS'] == '1' ? 'selected' : '' ?>>Есть активности</option>
					<option value="2" <?= $_REQUEST['WORK_STATUS'] == '2' ? 'selected' : '' ?>>Нет активностей</option>
					<option value="3" <?= $_REQUEST['WORK_STATUS'] == '3' ? 'selected' : '' ?>>Нет услуг</option>
				</select>
			</div>
			
			<div class="form-group">
				<label>Откуда пришел</label>
				<?
					$arINCOME = Helper::getIncomings();
					
				?>
				<select class="form-control"  name="PROP[SOURCE_OF_INCOME]">
					<option value="">Все</option>
					<?foreach($arINCOME as $t):?>
					<option <?= $_REQUEST['PROP']['SOURCE_OF_INCOME'] == $t ? 'selected' : '' ?> value="<?=$t?>"><?=$t?></option>
					<?endforeach?>
				</select>
			</div>
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
				<label>Оказаны услуги</label>
				<select class="form-control" name="SERVICE_TYPE">
					<option value="">Все</option>
					<option value="SERVICE" <?= $_REQUEST['SERVICE_TYPE'] == 'SERVICE' ? 'selected' : '' ?>>Услуги</option>
					<option value="CONSULT" <?= $_REQUEST['SERVICE_TYPE'] == 'CONSULT' ? 'selected' : '' ?>>Консультация</option>
				</select>
			</div>
			
			<div class="form-group">
				<label >Уникальный клиент</label>
				<select name="UNIQUE" class="form-control"  id="client-departament-select-new" >
					<option value="" >Выбрать</option>
					<option <?= $_REQUEST['UNIQUE'] == '2026' ? 'selected' : '' ?> value="2026">2026</option>
					<option <?= $_REQUEST['UNIQUE'] == '2025' ? 'selected' : '' ?> value="2025">2025</option>
					<option <?= $_REQUEST['UNIQUE'] == '2024' ? 'selected' : '' ?> value="2024">2024</option>
					<option <?= $_REQUEST['UNIQUE'] == '2023' ? 'selected' : '' ?> value="2023">2023</option>
					<option <?= $_REQUEST['UNIQUE'] == '2022' ? 'selected' : '' ?> value="2022">2022</option>
					<option <?= $_REQUEST['UNIQUE'] == '2021' ? 'selected' : '' ?> value="2021">2021</option>
					<option <?= $_REQUEST['UNIQUE'] == '2020' ? 'selected' : '' ?> value="2020">2020</option>
				</select>
			</div>
			
			<div style="margin-top: 50px;">
				
				<button type="button" onclick="filterGetData()" class="btn btn-success btn-sm" >Фильтровать</button>
				<br/><br/>
				<button type="button" onclick="window.location.href = '/clients/'"class="btn btn-default btn-sm">Сбросить фильтр</button>
			</div>
		</div>
		
		
	
		
		
		
	</div>
</form>
