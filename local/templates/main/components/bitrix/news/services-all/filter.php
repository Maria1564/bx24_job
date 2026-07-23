<?php	
	include '_filter_init.php';
?>







<div class="row">
    <form action="" method="get" id="filter-form">
	<input type="hidden" name="sort" id="form-sort" value="">
	<?if(!$arParams['ALL_DATA_PAGE']):?>
	<div class="col-md-3">
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
		<div class="form-check">
		<input class="form-check-input" type="checkbox" name="CLIENT_UNIQ" id="CLIENT_UNIQ" value="Y" <?= $_REQUEST['CLIENT_UNIQ'] == 'Y' ? 'checked' : '' ?>>
		<label class="form-check-label" for="CLIENT_UNIQ">
		   Только уникальные клиенты
		</label>
	    </div>
		
		<div class="form-check">
		<input class="form-check-input" type="checkbox" name="DATE_CLOSE" id="DATE_CLOSE" value="Y" <?= $_REQUEST['DATE_CLOSE'] == 'Y' ? 'checked' : '' ?>>
		<label class="form-check-label" for="DATE_CLOSE">
		   Фильтр по дате закрытия
		   <span class="input-help-text">
		     При выбранных датах показываются только услуги, 
			 которые были закрыты в выбранный промежуток времени
		   </span>
		</label>
		<br/><br/>
	    </div>
	    </div>
	</div>
<?endif?>
	<div class=" <?=!$arParams['ALL_DATA_PAGE']?'col-md-3':'col-md-4'?>">
	    <div class="form-group">
		<label>За какой период</label>
		<div class="period">
		    <input class="form-control" type="date" name="DATE_FROM" value="<?= $_REQUEST['DATE_FROM'] ?>"> - 
		    <input class="form-control" type="date" name="DATE_TO"  value="<?= $_REQUEST['DATE_TO'] ?>">
		</div>

	    </div>
		
		<div class="form-group">
		<label >Сумма (руб.) </label>
		  <div class="period">
		    <input class="form-control" type="number" name="MONEY_FROM" value="<?= $_REQUEST['MONEY_FROM'] ?>"> - 
		    <input class="form-control" type="number" name="MONEY_TO"  value="<?= $_REQUEST['MONEY_TO'] ?>">
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

	    <div style="margin-top: 50px;">

		<button type="button" onclick="filterGetData()" class="btn btn-success btn-sm" >Фильтровать</button>
		<br/><br/>
		<button type="button" onclick="window.location.href = '<?= $arParams['SEF_FOLDER'] ?>'" class="btn btn-default btn-sm">Сбросить фильтр</button>
	    </div>
	</div>
    </form>
</div>
