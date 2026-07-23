<?php	
	include '_filter_init.php';
?>







<form action="" method="get" id="filter-form">
	<div class="row">
		<input type="hidden" name="sort" id="form-sort" value="">
		
		<div class="col-md-4">
			<div class="form-group">
				<label>Дата мероприятия</label>
				<div class="period">
					<input class="form-control" type="date" name="DATE_FROM" value="<?= $_REQUEST['DATE_FROM'] ?>"> -
					<input class="form-control" type="date" name="DATE_TO"  value="<?= $_REQUEST['DATE_TO'] ?>">
				</div>
				
			</div>
		
		</div>
		
		<div class="col-md-12">
			
			<div style="margin-top: 20px; display: flex; gap: 8px;">
				
				<button type="button" onclick="filterGetData()" class="btn btn-dark btn-sm" >Фильтровать</button>
				<br/><br/>
				<button type="button" onclick="window.location.href = '<?= $arParams['SEF_FOLDER'] ?>'" class="btn btn-default btn-sm">Сбросить фильтр</button>
			</div>
			
			
		</div>
	</div>
</form>
