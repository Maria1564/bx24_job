<?php	
	include '_filter_init.php';
?>







<form action="" method="get" id="filter-form">
<div class="row">
		<input type="hidden" name="sort" id="form-sort" value="">
		<?if(!$arParams['ALL_DATA_PAGE']):?>
		<div class="col-md-4">
			<div class="form-group">
				<label>За какой период</label>
				<div class="period">
					<input class="form-control" type="date" name="DATE_FROM" value="<?= $_REQUEST['DATE_FROM'] ?>"> - 
					<input class="form-control" type="date" name="DATE_TO"  value="<?= $_REQUEST['DATE_TO'] ?>">
				</div>
			</div>

			<div class="form-group">
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
						<span class="input-help-text">
							Если у клиента несколько услуг в выбранном периоде, в списке останется только одна из них.
						</span>
					</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="checkbox" name="CLIENT_UNIQ_2" id="CLIENT_UNIQ_2" value="Y" <?= $_REQUEST['CLIENT_UNIQ_2'] == 'Y' ? 'checked' : '' ?>>
					<label class="form-check-label" for="CLIENT_UNIQ_2">
						Только уникальные клиенты за текущий год
						<span class="input-help-text">
							Показывает по одной услуге на каждого клиента, считая уникальность с начала текущего года.
						</span>
					</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="checkbox" name="CLIENT_UNIQ_3" id="CLIENT_UNIQ_3" value="Y" <?= $_REQUEST['CLIENT_UNIQ_3'] == 'Y' ? 'checked' : '' ?>>
					<label class="form-check-label" for="CLIENT_UNIQ_3">
						Уникальный за период существования агентства
						<span class="input-help-text">
							Показывает только первую услугу клиента за весь период работы агентства.
						</span>
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
			
		</div>
		<?endif?>
		<div class="col-md-2">
			<div class="form-group">	
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
			</div>
		</div>
		
		
		<div class="col-md-2">
			<div class="form-group">
				<label>Категория МСП</label>
				<select class="form-control" name="PROP[MSP_TYPE]">
					<option value="">Все</option>
					<option value="18" <?= $_REQUEST['PROP']['MSP_TYPE'] == '18' ? 'selected' : '' ?>>микро</option>
					<option value="19" <?= $_REQUEST['PROP']['MSP_TYPE'] == '19' ? 'selected' : '' ?>>малое</option>
					<option value="20" <?= $_REQUEST['PROP']['MSP_TYPE'] == '20' ? 'selected' : '' ?>>среднее</option>
				</select>
			</div>

			<div class="form-group">
				<label>Отрасль промышленности</label>
				<select class="form-control" name="PROP[INDUSTRIAL_SECTORS]" onchange="filterGetData()">
					<option value="">Все</option>
					<? foreach ($arIndustrialSectors as $id => $name): ?>
					<option value="<?= $id ?>" <?= $_REQUEST['PROP']['INDUSTRIAL_SECTORS'] == $id ? 'selected' : '' ?>>
						<?= $name ?>
					</option>
					<? endforeach ?>
				</select>
			</div>
			<?if(!$isConsultPage):?>
			<div class="form-group">
				<label>Виды услуг</label>
				<select class="form-control" name="PROP[DIRECTION_SERVICE]">
					<option value="">Все</option>
					<? foreach ($arDirectionServices as $arDirectionService): ?>
					<option value="<?= $arDirectionService['ID'] ?>" <?= ($_REQUEST['PROP']['DIRECTION_SERVICE'] ?? '') == $arDirectionService['ID'] ? 'selected' : '' ?>>
						<?= $arDirectionService['NAME'] ?>
					</option>
					<? endforeach ?>
				</select>
			</div>
			<div class="form-group">
				<label>Бюджет</label>
				<select class="form-control" name="BUDGET_SOURCE">
					<option value="">Все</option>
					<option value="regional" <?= ($_REQUEST['BUDGET_SOURCE'] ?? '') == 'regional' ? 'selected' : '' ?>>Региональный бюджет</option>
					<option value="federal" <?= ($_REQUEST['BUDGET_SOURCE'] ?? '') == 'federal' ? 'selected' : '' ?>>Федеральный бюджет</option>
				</select>
			</div>
			<?endif?>
		</div>
		<div class="col-md-12">
			<div style="margin-top: 20px; display: flex; gap: 8px;">
				
				<button type="button" onclick="filterGetData()" class="btn btn-dark btn-sm" >Фильтровать</button>
				<br/><br/>
				<button type="button" onclick="window.location.href = '<?= $arParams['SEF_FOLDER'] ?>'" class="btn btn-default btn-sm">Сбросить фильтр</button>
			</div>
		</div>
	</div>
</form>
