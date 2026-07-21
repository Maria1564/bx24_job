var inputTextTemplate = '';
var serviceDirection = 'SD';

//
function formInit(){
	console.log('...formInit...');
	//Проверяем выбранные опции
	//если установлен вывод формы ввода названия то показываем
	let $option = $('#DIRECTION_SERVICE option:selected')
	let isCustomService = $option.data('is_show_input')==='Y';
	if(isCustomService){
		$('#SERVICE_CUSTOM_NAME').show();
		//Теперь из названия услуги нужно получить текст кастомной части.
		let service = $("select[name='PROPERTY[DIRECTION_SERVICE]'] option:selected").text();
		inputTextTemplate = service;
		let legacyInputTextTemplate = serviceDirection + ' — ' + service;
		console.log(inputTextTemplate);
		let serviceName = $("input[name='NAME']").val();
		let customText = serviceName.replace(legacyInputTextTemplate,"").replace(inputTextTemplate,"").trim();
		if(customText!==inputTextTemplate){
			$('#SERVICE_CUSTOM_NAME').val(customText);
		}
		$('#SERVICE_CUSTOM_NAME').keyup();
	}
	
	selectDirectionEvent(true);
	if(!isCustomService){
		generateServiceName();
	}
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
		if($(this).hasClass('sended'))return false;
		$('#form_service').addClass('sended');
		return true
	})
	$('#SERVICE_CUSTOM_NAME').on('keyup',function(){
		let text = $(this).val();
		if(text!=""){
			text = ' '+text;
		}
    	let $el = $("input[name='NAME']").val(inputTextTemplate+''+text);
	})
});

function selectDirectionEvent(unsetDirectionVal = false){
	console.log('...selectDirectionEvent...');
	let val = serviceDirection;
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
	let serviceVal = $("select[name='PROPERTY[DIRECTION_SERVICE]']").val();
	console.log('serviceVal = '+serviceVal);
	let service = $("select[name='PROPERTY[DIRECTION_SERVICE]'] option:selected").text();
	let name = service;
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
