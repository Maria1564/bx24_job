<div class="form-section-contacts form-group">
	<?/*<label>Дополнительные контакты</label>*/?>
	
	
	<div class="client-contact-wrap">
		<?
			if($arResult["CLIENT"]['ID']){
				$contactsArr = Contact::getClientContacts($arResult["CLIENT"]['ID']);
			}
		?>
		<? if($arResult["CLIENT"]['ID']):?>
		
		<?if($contactsArr):?>
		<div class="title">Дополнительные контакты <span style="color:red;font-size: 13px;">(Все телефоны должны быть уникальны)</span></div>
		<?foreach($contactsArr as $i => $contact):?>
		<div class="contacts-list row">
			<div class="col-md-3">
				<input requred style="min-width:200px;" autocomplete="off" type="text" class="form-control"  name="CONTACT[NAME][<?=$i?>]"   value="<?=$contact['NAME']?>" placeholder="Иванов Иван Иванович" >
				<input type="hidden" name="CONTACT[ID][<?=$i?>]"   value="<?=$contact['ID']?>">
			</div>
			
			<div class="col-md-3">
				<input required  autocomplete="off" type="text" class="form-control input-phone-mask"  name="CONTACT[PHONE][<?=$i?>]" value="<?=$contact['PHONE']?>" placeholder="+7 --- --- -- --" >
			</div>
			<div class="col-md-3">
				<input requred autocomplete="off" type="email" class="form-control"  name="CONTACT[EMAIL][<?=$i?>]" value="<?=$contact['EMAIL']?>"  placeholder="ivanoff@mail.ru">
			</div>
			<div class="col-md-2">
				<input type="text" class="form-control" name="CONTACT[POST][<?=$i?>]" value="<?=$contact['POST']?>" placeholder="Директор">
				<input type="hidden" name="CONTACT[PREVIEW_TEXT][<?=$i?>]" value="<?=$contact['PREVIEW_TEXT']?>">
			</div>
			<div class="col-md-1">						  
				<input  type="checkbox" class=""  name="CONTACT[ACTIVE][<?=$i?>]" value="N"  title="Удалить контакт">
				<span title="Удалить контакт" style="position: absolute;margin-left: 5px; color: red;">x </span>
			</div>
		</div>
		<?endforeach?>
		<?endif?>
		<?endif?>
		<a style="background-color: #419641;color: #fff; padding: 10px; border: none;margin-bottom:10px;display:inline-block;" class="add-contact-a" onclick="addContacts()">+ Добавить контактное лицо</a>
		<div id="contacts-items" style="display:none">
			<div class="contacts-list row">
				<div class="col-md-3 чfiz-hide ooo-user-name-field">
					<input requred style="min-width:200px;" autocomplete="off" type="text" class="form-control"  name="CONTACT[NAME][]"   placeholder="Иванов Иван Иванович" >
				</div>
				<div class="col-md-3">
					<input  requred autocomplete="off" type="text" class="form-control input-phone-mask"  name="CONTACT[PHONE][]" placeholder="+7 --- --- -- --" >
				</div>
				<div class="col-md-3">
					<input autocomplete="off" type="email" class="form-control"  name="CONTACT[EMAIL][]"  placeholder="ivanoff@mail.ru">
				</div>
				<div class="col-md-2">
					<input autocomplete="off" type="text" class="form-control" name="CONTACT[POST][]" placeholder="Директор">
					<input type="hidden" name="CONTACT[PREVIEW_TEXT][]" value="">
				</div>
			</div>
		</div>
	</div>
</div>
