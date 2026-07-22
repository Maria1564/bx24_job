<div class="form-section-contacts form-section-org-info fiz-hide">
	<div class="row org-info " >
		<div class="col-12 col-md-3 form-group">
			<label>ОГРН</label>
			<input autocomplete="off" type="text" id="input-OGRN" class="form-control input-OGRN" name="PROPERTY[OGRN]"  placeholder="123456789" required
			value="<?= $_REQUEST['PROPERTY']['OGRN'] != '' ? $_REQUEST['PROPERTY']['OGRN'] : '' ?>" >
			<small id="emailHelp" class="form-text text-muted"></small>
		</div>
		
		<div class="col-12 col-md-3 form-group">
			<label>ЮР. АДРЕС</label>
			<input autocomplete="off" type="text" value="<?= $_REQUEST['PROPERTY']['ADDRESS'] != '' ? $_REQUEST['PROPERTY']['ADDRESS'] : '' ?>" id="input-ADDRESS" class="form-control input-ADDRESS" name="PROPERTY[ADDRESS]"  placeholder="г.Москва, Ивановых 36, корпус 1" required>
			<small id="emailHelp" class="form-text text-muted"></small>
		</div>
		
		<? /*
			<div class="form-group fiz-hide">
			<label>МСП <input type="checkbox" name="PROPERTY[MSP]" value="1" <?= $_REQUEST['PROPERTY']['MSP'] != '' ? 'checked' : '' ?>></label>
			
			<small id="emailHelp" class="form-text text-muted"></small>
			</div>
		*/ ?>
		
		<div class="col-12 col-md-3 form-group fiz-hide">
			<label>ОКВЭД</label>
			<input type="text" class="form-control input-OKVED"  name="PROPERTY[OKVED]" placeholder="" required
			value="<?= $_REQUEST['PROPERTY']['OKVED'] != '' ? $_REQUEST['PROPERTY']['OKVED'] : '' ?>" >
			<small id="emailHelp" class="form-text text-muted"></small>
		</div>
		
		<?
			$arMSP_TYPE = Helper::getListValue(Client::CLIENT_IBLOCK_ID, 'MSP_TYPE');
			//l($arMSP_TYPE);
		?>
		<div class="col-12 col-md-3 form-group fiz-hide">
			<label>Тип МСП</label>
			<select name="PROPERTY[MSP_TYPE]" class="form-control" required>
				<option value="" >Выберите направление</option>
				<? foreach ($arMSP_TYPE as $id => $val): ?> 
				<option value="<?= $id ?>" <?= $_REQUEST['PROPERTY']['MSP_TYPE'] == $id ? 'selected' : '' ?>><?= $val['VALUE'] ?></option>
				<? endforeach ?>
			</select>	   
		</div>
		
	</div>
	<?/*
	<div class="row org-info" >
		<?
			$arRAION_NEW = Helper::getListValue(Client::CLIENT_IBLOCK_ID, 'RAION_NEW');
			//l($arMSP_TYPE);
		?>
		<div class="col-12 col-md-3 form-group ">
			<label>Регион</label>
			<select required name="PROPERTY[RAION_NEW]" class="form-control" >
				<option value="" >Выберите регион</option>
				<? foreach ($arRAION_NEW as $id => $val): ?> 
				<option value="<?= $id ?>" <?= $_REQUEST['PROPERTY']['RAION_NEW'] == $id ? 'selected' : '' ?>><?= $val['VALUE'] ?></option>
				<? endforeach ?>
			</select>	   
		</div>
	</div>
	*/?>
	
</div>
