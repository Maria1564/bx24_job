<?
	
//	l($_REQUEST['PROPERTY']['DIRECTION_SERVICE']);
?>
<div class="form-section form-section-direction row">
	<div class="form-group col-md-12" >
		
		<?
			//$arDirections = Helper::getDirections();
			//l($_REQUEST['PROPERTY']['DIRECTION_SERVICE']);
		?>
		<label>Список услуг</label>
		<select id="DIRECTION_SERVICE" name="PROPERTY[DIRECTION_SERVICE]" class="form-control" required  style="max-width:200px;" onchange="selectDirectionServiceEvent()">
			<option value="">Выбрать</option>
			<?foreach($arResult['DIRECTION_SERVICES'] as $ar0):?>
			<?foreach($ar0 as $ar):?>
			<option
			data-is_show_input="<?=$ar['PROPERTY_IS_SHOW_INPUT_VALUE']?>"
			value="<?=$ar['ID']?>" 
			<?=$ar['ID']== $_REQUEST['PROPERTY']['DIRECTION_SERVICE']?'selected':''?>><?=$ar['NAME']?></option>
			<?endforeach?>
			<?endforeach?>
			
		</select>
		
	</div>
	<input  style="display:none" type="text" class="form-control " id="SERVICE_CUSTOM_NAME" name="SERVICE_CUSTOM_NAME" value="" placeholder="Введите назание услуги...">
</div>
<script>
	<?if($_REQUEST['PROPERTY']['DIRECTION_SERVICE']):?>
	formInit();
	<?endif?>
	</script>
