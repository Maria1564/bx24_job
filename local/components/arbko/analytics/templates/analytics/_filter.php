<?php	
	include '_filter_init.php';
?>




<div class="row">
    <form action="" method="get" id="filter-form">
		<input type="hidden" name="sort" id="form-sort" value="">
		
		
		<div class=" col-md-4">
			<div class="form-group">
				<label>За какой период</label>
				<div class="period">
					<input class="form-control" type="date" name="DATE_FROM" value="<?= $_REQUEST['DATE_FROM'] ?>"> - 
					<input class="form-control" type="date" name="DATE_TO"  value="<?= $_REQUEST['DATE_TO'] ?>">
				</div>
			</div>
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
				<label for="exampleFormControlSelect1">Реализована?</label>
				<select class="form-control" <? /*name="PROP[STATUS]"*/?> name="STATUS">
					<option value="">Все</option>
					<option value="work" <?= $_REQUEST['STATUS'] == "work" ? 'selected' : '' ?>>В работе</option>
					<option value="success" <?= $_REQUEST['STATUS'] ==  "success" ? 'selected' : '' ?>>Успешно завершена</option>
					<option value="failed" <?= $_REQUEST['STATUS'] ==  "failed" ? 'selected' : '' ?>>Не успешно завершена</option>
					<option value="done-no-done" <?= $_REQUEST['STATUS'] ==  "done-no-done" ? 'selected' : '' ?>>Не реализованные  и  реализованные </option>  
				</select>
			</div>
			
		</div>
		
		<div class="col-md-2">
		<button type="button" onclick="filterGetData()" class="btn btn-success btn-sm" >Фильтровать</button>
		<button type="button" onclick="window.location.href = '<?= $arParams['SEF_FOLDER'] ?>'" class="btn btn-default btn-sm">Сбросить фильтр</button>
		</div>
	</form>
</div>
<br/>
