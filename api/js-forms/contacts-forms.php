<?
	//
?>
<form id="contact-add"  onsubmit="window.contact.form.formSubmit(this);  return false;">
	
	<div class="form-group NAME-field" style="position: relative">
	    <br/>
	    <label >ФИО</label>
		<input required autocomplete="off" type="text"  class="form-control input-NAME" id="input-org-name" name="NAME"  placeholder="Иванов Иван Иванович" >
		<br/>
		<div class="row">
			<div class="col-md-6">
				<label >Телефон</label>
				<input required autocomplete="off" type="text"  class="form-control input-NAME "  name="PHONE"  placeholder="+7 --- --- -- --" >
			</div>
			<div class="col-md-6">
				<label >Email</label>
				<input required autocomplete="off" type="email"  class="form-control input-NAME" id="input-org-name" name="EMAIL"  placeholder="ivanoff@mail.ru" >
			</div>
		</div>
	</div>
	<button class="btn btn-success">Добавить</button>
	<div class="form-log"></div>
</form>