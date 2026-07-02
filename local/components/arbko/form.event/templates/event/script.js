var inputTextTemplate = '';

//
function formInit(){
	console.log('...formInit...');
	//Проверяем выбранные опции
	//если установлен вывод формы ввода названия то показываем
	let $option = $('#DIRECTION_SERVICE option:selected')
	if($option.data('is_show_input')==='Y'){
		$('#SERVICE_CUSTOM_NAME').show();
		//Теперь из назавния услуги нужно получить текст кастомной части.
		//например  SD — Другое: это просто текст!!!
		//получаем сначала шаблон текста
		let direction = $("select[name='PROPERTY[DIRECTION]']").val();
		let service = $("select[name='PROPERTY[DIRECTION_SERVICE]'] option:selected").text();
		inputTextTemplate = direction + ' — '+ service;
		console.log(inputTextTemplate);
		let serviceName = $("input[name='NAME']").val();
		let customText = serviceName.replace(inputTextTemplate,"").trim();
		if(customText!==inputTextTemplate){
			$('#SERVICE_CUSTOM_NAME').val(customText);
		}
	}
	
	selectDirectionEvent(true);
}
function functTest(manager_id) {
	console.log(manager_id);
	var manager = app.managers[manager_id];
	console.log(manager);
	// $('#simpleModal').modal('hide')
	$('#manager-span').html(manager.FIO);
}

function selectTaskBx24(){
	var form = renderTemplate('service-task-bx24-template');
    xmodalShow("Поиск задачи в CRM Bitrix24", form);
}

$(document).ready(function () {
    
    $('button[type="submit"]').click(function(){
	});
	
	$('#form_service').on('submit',function(e){
		/*if($("input[name='PROPERTY[FINANCE_SOURCE]'").val()==""){
			$("input.fin_inp").css("border-color", "red");
			e.preventDefault();
			return true;
		}*/	
		if($(this).hasClass('sended'))return false;
		$('#form_service').addClass('sended');
		return true
	})
	/*$('#SERVICE_CUSTOM_NAME').on('keyup',function(){
		let text = $(this).val();
		if(text!=""){
			text = ' '+text;
		}
    	let $el = $("input[name='NAME']").val(inputTextTemplate+''+text);
	})*/
});

function selectDirectionEvent(unsetDirectionVal = false){
	console.log('...selectDirectionEvent...');
	let $el = $("select[name='PROPERTY[DIRECTION]']");
	let val = $el.val();
	console.log(val);
	if(!unsetDirectionVal){
		$("select[name='PROPERTY[DIRECTION_SERVICE]").val("");
		$('#SERVICE_CUSTOM_NAME').hide();
	}
	
	$("#DIRECTION_SERVICE").find('option').hide();
	
	$("#DIRECTION_SERVICE option").each(function(){
		let direction = $(this).data('direction')		
		console.log(direction);
		if(direction === val){
			$(this).show();		
		}
	});
	if(!unsetDirectionVal){
	    generateServiceName();
		
	}
}
function selectDirectionServiceEvent(){
	let $option = $('#DIRECTION_SERVICE option:selected')
	$('#SERVICE_CUSTOM_NAME').hide();
	generateServiceName();
	if($option.data('is_show_input')==='Y'){
		$('#SERVICE_CUSTOM_NAME').show();
		$('#SERVICE_CUSTOM_NAME').keyup();
	}
	
	
}
function generateServiceName(){
	let direction = $("select[name='PROPERTY[DIRECTION]']").val();
	let serviceVal = $("select[name='PROPERTY[DIRECTION_SERVICE]']").val();
	console.log('serviceVal = '+serviceVal);
	let service = $("select[name='PROPERTY[DIRECTION_SERVICE]'] option:selected").text();
	let name = direction + ' — '+ service;
	if(name.length && serviceVal){
		inputTextTemplate = name;
    	let $el = $("input[name='NAME']").val(name);
	}
	else {
		inputTextTemplate = '';
		$("input[name='NAME']").val("");
	}
}

function setCheckboxFS(){
	$("input.fin_inp").css("border-color", "#ccc");
	let $checkbox_fs_value = $('#checkbox-fs-value');
	$checkbox_fs_value.val('');
	let selVal= [];
	$('.checkbox-fs').each(function(){
	  if($(this).prop('checked')){
		  selVal.push($(this).val())
	  }
	});
	console.log(selVal)
	$checkbox_fs_value.val(selVal.join(', '));
	$('#checkbox-fs-display-value').val(selVal.join(', '));
	
}

var contactTempalte = '\
		<div class="form-group" style="display:flex;border-bottom: solid 1px;padding-bottom: 20px">\
				<div style="margin-right:30px;">\
					<label>Клиент: </label>\
					<span id="client-link" target="_blank"></span>\
					<input id="client-input-id" type="hidden" class="form-control" name="PROPERTY[CLIENT]">\
					<a onclick="client.formSearchClientOpen()">Выбрать</a>\
				</div>\
				<div>\
					<label>Контакт</label>\
					<select class="form-control" id="select_contact" name="PROPERTY[CONTACT][]"></select>\
				</div>\
			</div>';
function addContacts(){
	if(contactTempalte!=""){
		$('#cont_items').prepend(contactTempalte);
	}
}	

function delContact(elem){
	//$(elem).remove();
	$(elem.closest('.form-group')).remove();
}

$(document).ready(function(){
	$('.unit-mainz').on('click',function(){
		if(fsCanHide){
		if(!$(this).hasClass('cb-fs-wrap')){
		    fsCanHide = false;
	     	$('.cb-fs-wrap').hide();
		}
		}
		});
	
	$(document).mouseup(function (e){ // событие клика по веб-документу
		var div = $(".cb-fs-wrap"); // тут указываем ID элемента
		if (!div.is(e.target) // если клик был не по нашему блоку
		    && div.has(e.target).length === 0) { // и не по его дочерним элементам
			div.hide(); // скрываем его
		}
	});
});