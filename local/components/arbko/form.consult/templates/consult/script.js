var fsCanHide = false;
function validDate(date, theInput) {
    var date = document.getElementById("startDate").value;
    todayDate = getTodaysDate();
    if (date > todayDate)
        theInput.value = todayDate;
}

function getTodaysDate(){
    date = new Date();
    day = date.getDate();
    month = date.getMonth() + 1;
    year = date.getFullYear();

    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;

    today = year + "-" + month + "-" + day; 

    return today;
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
	
	
	
	$('#form_consult').on('submit',function(e){
		if($("input[name='PROPERTY[FINANCE_SOURCE]'").val()==""){
			$("input.fin_inp").css("border-color", "red");
			e.preventDefault();
			return true;
		}	
	});

	
	
	
});