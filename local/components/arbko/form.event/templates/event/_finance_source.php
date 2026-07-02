<?
	$strValue = $_REQUEST['PROPERTY']['FINANCE_SOURCE'];
    $arVal = explode(", ",$strValue);
	if(strpos($arValue,",")!==false){
	
	
	}
	//l( $arVal);
?>

	<div class="form-group" style="position: relative;">
			<?
				$arINCOME = Helper::getFinanceSource();
				
			?>
			<label>Источник финансирования</label>
			<input type="hidden"  id="checkbox-fs-value" name="PROPERTY[FINANCE_SOURCE]" value="<?=$_REQUEST['PROPERTY']['FINANCE_SOURCE']?>">
			<input type="text" onclick="$('.cb-fs-wrap').show();setTimeout(function(){fsCanHide = true},100)"  class="form-control fin_inp" id="checkbox-fs-display-value"  value="<?=$_REQUEST['PROPERTY']['FINANCE_SOURCE']?>" readonly>
			<div class="cb-fs-wrap">		
				<?foreach($arINCOME as $t):?>
				<div class="item">
					<label>
						<input onclick="setCheckboxFS()" class="checkbox-fs" type="checkbox" <?=in_array($t,$arVal) ? 'checked' : '' ?> value="<?=$t?>"> <?=$t?>
					</label>
				</div>
				<?endforeach?>
			
		</div>
			<? /*
				<textarea  class="form-control" name="PROPERTY[SOURCE_OF_INCOME]"><?= $_REQUEST['PROPERTY']['SOURCE_OF_INCOME'] != '' ? $_REQUEST['PROPERTY']['SOURCE_OF_INCOME'] : '' ?></textarea>
			*/?>
		</div>
		
		
		
		<?
			
			/*
				<div class="form-group">
			<?
				$arINCOME = Helper::getFinanceSource();
				
			?>
			<label>Источник финансирования</label>
			<select  name="PROPERTY[FINANCE_SOURCE]" class="form-control" required="">
				<option  value="">Выберите значение</option>
				<?foreach($arINCOME as $t):?>
				<option <?= $_REQUEST['PROPERTY']['FINANCE_SOURCE'] == $t ? 'selected' : '' ?> value="<?=$t?>"><?=$t?></option>
				<?endforeach?>
			</select>
		
		</div>
				
			*/?>