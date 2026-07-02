//
console.log('contact init');

class Contact {
	constructor() {
		this.clientId = false;
		this.form = new ContactForms(this);
	}
	save(formData){
		if(!this.clientId){
			alert('Ошибка. Не указан ID клиента!');
			return false;
			
		}
		formData+='&CLINET_ID='+ this.clientId;
		console.log('save');
	    console.log(formData);
		$.ajax({type: "POST",
			url: '/api/contact/add.php',
			data: formData, // serializes the form's elements.
			success: function (data) {
				console.log(data);        
				// reloadPage();
			},
			error:function(data){console.log(data);}
		});
	}
}

class ContactForms {
	constructor(_contact) {
		this.contact = _contact;
		this.contactAddFornHtml;
		doRequest('/api/js-forms/contacts-forms.php', {}, (data)=> {
			this.contactAddFornHtml = data;
			console.log( this.contactAddFornHtml);
		});
		
	}
	add() {
		$('#simpleModal').modal('show')
		$('#simpleModal .modal-title').html('Добавление контакта')
		$('#simpleModal .modal-body').html( this.contactAddFornHtml )
	}
    formSubmit(_form) {
	    this.contact.save($(_form).serialize());
		
		}
	}
