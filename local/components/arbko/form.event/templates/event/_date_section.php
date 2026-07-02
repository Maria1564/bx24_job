<div class="form-section form-section-date row">
	<div class="form-group col-md-6">
		<label>Дата начала мероприятия</label>
		<input type="datetime-local" class="form-control" name="DATE" style="display: inline;" value="<?= $_REQUEST['DATE'] != '' ? $_REQUEST['DATE'] : date('Y-m-d') ?> <?= $_REQUEST['TIME'] != '' ? $_REQUEST['TIME'] : '' ?>" >
		<input type="time" class="form-control" name="TIME" style="display: none;width: 100px;" value="<?= $_REQUEST['TIME'] != '' ? $_REQUEST['TIME'] : date('H:i') ?>" >
		<small id="emailHelp" class="form-text text-muted"></small>
	</div>
	
	<div class="form-group col-md-6">
		<label>Дата закрытия мероприятия</label>
		<input type="datetime-local" class="form-control" name="DATE_END" style="display: inline;" value="<?= $_REQUEST['DATE_END'] != '' ? $_REQUEST['DATE_END'] : "" ?> <?= $_REQUEST['TIME_END'] != '' ? $_REQUEST['TIME_END'] : '' ?>" >
		<input type="time" class="form-control" name="TIME_END" style="display: none;width: 100px;" value="<?= $_REQUEST['TIME_END'] != '' ? $_REQUEST['TIME_END'] :"" ?>" >
		
	</div>
	
</div>

