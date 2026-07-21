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
		
		<br><br>
		<? include '_finance_source.php'?>
		<? /*
		<div class="form-group">
					<?
						$arINCOME = Helper::getFinanceSource();
						
					?>
					<label>Источник финансирования</label>
					<select  name="PROPERTY[FINANCE_SOURCE]" class="form-control" >
					<option  value="">Выберите значение</option>
						<?foreach($arINCOME as $t):?>
						<option <?= $_REQUEST['PROPERTY']['FINANCE_SOURCE'] == $t ? 'selected' : '' ?> value="<?=$t?>"><?=$t?></option>
						<?endforeach?>
					</select>
				
		</div>
		*/?>
	</div>
</div>
