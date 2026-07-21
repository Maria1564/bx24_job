<div class="form-section form-section-money row">
	<div class="form-group">
		<table>
			<tr>
				<td>
					<label>Региональный бюджет</label>
					<input style="max-width: 200px;" type="text"  class="form-control input-format-money" name="PROPERTY[REGIONAL_BUDGET]" value="<?= $_REQUEST['PROPERTY']['REGIONAL_BUDGET'] ?>" >
					<small id="emailHelp" class="form-text text-muted">только цифры,сумма в рублях</small>
				</td>
				
				<td>
					<label>Федеральный бюджет</label>
					<input style="max-width: 200px;" type="text"  class="form-control input-format-money" name="PROPERTY[FEDERAL_BUDGET]" value="<?= $_REQUEST['PROPERTY']['FEDERAL_BUDGET'] ?>" >
					<small id="emailHelp" class="form-text text-muted">только цифры,сумма в рублях</small>
				</td>
			</tr>
		</table>
	</div>
</div>
