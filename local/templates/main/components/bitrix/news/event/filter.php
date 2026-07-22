<?php	
	include '_filter_init.php';
?>







<div class="row" style="margin-bottom:30px;">
    <form action="" method="get" id="filter-form">
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
		
		<div class="col-md-2">
			<div class="form-group">	
				<div class="form-check">
					<input 
					class="form-check-input" 
					type="checkbox"  
					id="org_type_10" 
					name='PROP[ORG_TYPE][]' 
					value="52"
					<?= in_array(52, $_REQUEST['PROP']['ORG_TYPE']) ? 'checked' : '' ?>
					>
					<label class="form-check-label" for="org_type_10">
						Физ.лица
					</label>
				</div>

				<div class="form-check">
					<input 
					class="form-check-input" 
					type="checkbox"  
					id="sz" 
					name='PROP[ORG_TYPE][]' 
					value="51"
					<?= in_array(51, $_REQUEST['PROP']['ORG_TYPE']) ? 'checked' : '' ?>
					>
					<label class="form-check-label" for="sz">
						Самозанятые
					</label>
				</div>
				<div class="form-check">
					<input 
					class="form-check-input" 
					type="checkbox" 
					id="org_type_4" 
					name='PROP[ORG_TYPE][]' 
					value="53"
					<?= in_array(53, $_REQUEST['PROP']['ORG_TYPE']) ? 'checked' : '' ?>
					>
					<label class="form-check-label" for="org_type_4">
						Юр Лица
					</label>
				</div>
			
				
			</div>
		</div>	
		
		
		<div class="col-md-3">
			
			<div style="margin-top: 25px;">
				
				<button type="button" onclick="filterGetData()" class="btn btn-success btn-sm" >Фильтровать</button>
				<br/><br/>
				<button type="button" onclick="window.location.href = '<?= $arParams['SEF_FOLDER'] ?>'" class="btn btn-default btn-sm">Сбросить фильтр</button>
			</div>
			
			
		</div>
	</form>
</div>
