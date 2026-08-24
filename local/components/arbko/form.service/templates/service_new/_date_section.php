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

<?
$contractProvidedEnumId = '';
$contractProvidedValue = $_REQUEST['PROPERTY']['CONTRACT_PROVIDED'];
$isContractProvided = $contractProvidedValue != '';
$rsContractProvidedEnum = CIBlockPropertyEnum::GetList(
	array(),
	array('IBLOCK_ID' => Service::IBLOCK_ID, 'CODE' => 'CONTRACT_PROVIDED', 'XML_ID' => 'Y')
);
if ($arContractProvidedEnum = $rsContractProvidedEnum->Fetch()) {
	$contractProvidedEnumId = $arContractProvidedEnum['ID'];
	if ($contractProvidedValue == 'Y') {
		$contractProvidedValue = $contractProvidedEnumId;
	}
}

$contractProvidedDate = $_REQUEST['PROPERTY']['CONTRACT_PROVIDED_DATE'];
$contractProvidedDateInput = '';
if ($contractProvidedDate != '') {
	$contractProvidedTimestamp = MakeTimeStamp($contractProvidedDate);
	if (!$contractProvidedTimestamp) {
		$contractProvidedTimestamp = strtotime($contractProvidedDate);
	}
	if ($contractProvidedTimestamp) {
		$contractProvidedDateInput = date('Y-m-d', $contractProvidedTimestamp);
	}
}
?>
<div class="form-section form-section-contract row">
	<div class="form-group col-md-6">
		<input type="hidden" name="PROPERTY[CONTRACT_PROVIDED]" value="">
		<label style="width:190px">
			<input
				type="checkbox"
				id="contract-provided-checkbox"
				name="PROPERTY[CONTRACT_PROVIDED]"
				value="<?= $contractProvidedEnumId ?>"
				<?= $isContractProvided ? 'checked' : '' ?>
			>
			Предоставлен контракт
		</label>
	</div>

	<div class="form-group col-md-6">
		<label style="width:190px">Дата предоставления контракта</label>
		<input
			type="date"
			class="form-control"
			id="contract-provided-date"
			name="PROPERTY[CONTRACT_PROVIDED_DATE]"
			style="display: inline;width: 150px;"
			value="<?= $contractProvidedDateInput ?>"
		>
	</div>
</div>
