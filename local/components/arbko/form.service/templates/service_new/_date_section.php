<div class="form-section form-section-date row">
	<div class="form-group col-md-6">
		<label style="width:190px">Дата начала услуги</label>
		<input type="date" class="form-control" name="DATE" style="display: inline;width: 150px;"
		value="<?= $_REQUEST['DATE'] != '' ? $_REQUEST['DATE'] : date('Y-m-d') ?>" >
		<input type="time" class="form-control" name="TIME" style="display: none;width: 100px;"
		value="<?= $_REQUEST['TIME'] != '' ? $_REQUEST['TIME'] : date('H:i') ?>" >
		<small id="emailHelp" class="form-text text-muted"></small>
	</div>
	
	<div class="form-group col-md-6">
		<label style="width:190px">Дата закрытия услуги<br>
			<small id="emailHelp" class="form-text text-muted" style="font-weight:normal">Не обязательный параметр</small>
		</label>
		<input type="date" class="form-control" name="DATE_END" style="display: inline;width: 150px;"
		value="<?= $_REQUEST['DATE_END'] != '' ? $_REQUEST['DATE_END'] : "" ?>" >
		<input type="time" class="form-control" name="TIME_END" style="display: none;width: 100px;"
		value="<?= $_REQUEST['TIME_END'] != '' ? $_REQUEST['TIME_END'] :"" ?>" >
		
	</div>
</div>