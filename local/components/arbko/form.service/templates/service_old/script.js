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

		
		
	//	$(this).addClass('disabled').text('.....');
       
        
      //  return true;
    });
	$('#form_service').on('submit',function(){
		
			if($(this).hasClass('sended'))return false;
			$('#form_service').addClass('sended');
			return true
	})
     });