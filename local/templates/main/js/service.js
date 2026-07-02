var service = new Service();
function Service() {
    this.searchData = {}
	
	this.searchSubmitHandler = function (data) {
        console.log('cleantSeacrchHandler')
        console.log(data);
        service.searchData = data.result;
        var resutl = '';
        if (data.result.length > 0) {
            for (var i = 0; i < data.result.length; i++) {
                resutl += '<tr><td>' + data.result[i].ID + '</td>\n\
                           <td>' + data.result[i].TITLE + '</td>\n\
                           <td><a onclick="service.setServiceData(' + i + ')">выбрать</a></td>\n\
                       </tr>';
            }

        }
        $('.form-result').html('<table>' + resutl + '</table>');

    }
    this.cleantSeacrchHandler = function (data) {
        console.log('cleantSeacrchHandler')
        console.log(data);
        service.searchData = data.result;
        var resutl = '';
        if (data.result.length > 0) {
            for (var i = 0; i < data.result.length; i++) {
                resutl += '<tr><td>' + data.result[i].ID + '</td>\n\
                           <td>' + data.result[i].NAME + '</td>\n\
                           <td><a onclick="service.setClientData(' + i + ')">выбрать</a></td>\n\
                       </tr>';
            }

        }
        $('.form-result').html('<table>' + resutl + '</table>');

    }
}

Service.prototype.setServiceData = function (i) {
    console.log("------ setServiceDatafsdfsdfs ID " + i + " ---------");
    var _service = service.searchData[i];
    console.log(_service);
	
    $('#bx24_task_link').show().text(_service.TITLE).attr('href', app.config.bx24crmlink+'/' + _service.ID + '/');
	 $('#bx24_task_link_btn').hide();
    //$('#service-input-id').val(_client.ID);
    //  $('#client-select-btn').text();
    xmodalHide();
}
Service.prototype.setClientData = function (i) {
    console.log("------ setClientData ID " + i + " ---------");
    var _client = service.searchData[i];
    console.log(_client);
    $('#service-link').text(_client.NAME).attr('href', '/clients/' + _client.ID + '/');
    $('#service-input-id').val(_client.ID);
    //  $('#client-select-btn').text();
    xmodalHide();
}
Service.prototype.setServiceData = function (i) {
    console.log("------ setServiceData ID " + i + " ---------");
    var _service = service.searchData[i];
    console.log(_service);
    $('#service-link').text(_service.NAME).attr('href', '/clients/' + _service.ID + '/');
    $('#service-input-id').val(_service.ID);
    //  $('#client-select-btn').text();
    xmodalHide();
}
Service.prototype.getInformationFromEGRNById = function (id) {
    console.log("------ getInformationFromEGRNById ID " + id + " ---------");
    doRequest('/api/client/get-info.php', {client_id: id, html: true}, function (data) {
        console.log(data)
        $('.client-contragent-info').html(JSON.stringify(data))
    });
}
Service.prototype.delete = function (id,callBackFunction="") {
    console.log("------ Service.delete ID " + id + " ---------");
	if (window.confirm("Запись будет удалена!")) {
 doRequest('/api/service/delete.php', {id: id}, function (data) {
        console.log(data)
		if(callBackFunction){
		  callBackFunction(data);
		} 
    });

  }
   
}

Service.prototype.formSearchServiceOpen = function () {
    console.log("------ formSearchServiceOpen ---------");
   
    
    var clinetID = $('#client-input-id').val();
    //если выбран клиент то показываем его услуги
    if (clinetID>0) {
          var form = renderTemplate('service-search-template');
        xmodalShow("Выбор услуги", form);
         $('.xmodal-content-body').find('.form').hide();
        doRequest('/api/client/get-services.php', {client_id: clinetID}, function (data) {
          //  console.log(data)
            if (data.result.length > 0) {
                var services = '';
                 service.searchData = data.result;
                for (var i = 0; i < data.result.length; i++) {
                    services += '<tr><td>' + data.result[i].ID + '</td>\n\
                           <td>' + data.result[i].NAME + '</td>\n\
                           <td><a onclick="service.setServiceData(' + i + ')">выбрать</a></td>\n\
                       </tr>';
                }
               
                $('.form-result').html('<table>' + services + '</table>');
            }else {
                 $('.form-result').html('У клиента нет оказанных услуг');
            }
            //$('.client-contragent-info').html(JSON.stringify(data))
        });
    }else {
        xmodalShow("Выбор услуги", "Для начала необходимо <a href='#client' onclick='client.formSearchClientOpen()'>выбрать клиента!</a>");
		}
    
}

