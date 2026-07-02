<div>
	<div class="col-md-12">
		<div class="form-group">
			<label style="width:190px">
			<input type="checkbox" name="PROPERTY[BX24_STATUS_EXT]" value="1" <?= $_REQUEST["PROPERTY"]['BX24_STATUS_EXT']==1?'checked':'' ?>>
			<span>Успешно реализовано</span>
			</label>
			
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label style="width:190px">
			<input type="checkbox" name="PROPERTY[CLIENT_REFUSED]" value="1" <?= $_REQUEST["PROPERTY"]['CLIENT_REFUSED']==1?'checked':'' ?>>
			<span>Отказ от услуги</span>
			</label>			
		</div>
	</div>
	
	<div class="col-md-12">
		<div class="form-group">
			<label style="">
			<input type="checkbox" name="ADD_TASK_TO_B24" value="1" <?= $_REQUEST["PROPERTY"]['BX24_TASK_ID']>0?'checked disabled':'' ?>>
			<span>Добавить задачу в Битрикс24</span>
			</label>			
			<?if($_REQUEST["PROPERTY"]['BX24_TASK_ID']):?>
			  <a href="https://arbko.bitrix24.ru/company/personal/user/6/tasks/task/view/<?=$_REQUEST["PROPERTY"]['BX24_TASK_ID']?>/" target="_blank"> ( услуга в Битрикс24 )</a>
			<?endif?>
		</div>
	</div>
	
</div>