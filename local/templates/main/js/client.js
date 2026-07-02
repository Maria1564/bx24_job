var client = new Client();
function Client() {
    this.searchData= {}
  this.cleantSeacrchHandler =  function(data){
      console.log('cleantSeacrchHandler')
      console.log(data);
      client.searchData = data.result;
      var resutl = '';
      if(data.result.length>0){
          for(var i = 0; i < data.result.length; i++){
             resutl +='<tr><td>' + data.result[i].ID + '</td>\n\
                           <td>' + data.result[i].NAME + '</td>\n\
                           <td><a onclick="client.setClientData(' + i + ')">выбрать</a></td>\n\
                       </tr>';
          }
          
      }
       $('.form-result').html('<table>'+resutl+'</table>');
      
  }
}
Client.prototype.setClientData = function (i) {
    console.log("------ setClientData ID " + i + " ---------");   
    var _client = client.searchData[i];
     console.log(_client); 
       $('#client-link').text(_client.NAME).attr('href','/clients/'+_client.ID+'/');
       $('#client-input-id').val(_client.ID);
     //  $('#client-select-btn').text();
      xmodalHide();
	  
	  $.ajax({
		data: {id:_client.ID},
		type: 'POST',
		url: '/api/event/get_contact.php',
		success: function(data){
			if(data.result){
				$("#select_contact").html('');
				for(var i = 0; i < data.result.length; i++){
					$("#select_contact").append('<option value="' + data.result[i].ID +'">'+data.result[i].NAME+'</option>');
				}
			}
			else{
				alert("Нет контактов");
			}
		}
	});
	  
}


Client.prototype.getInformationFromEGRNById = function (id) {
    console.log("------ getInformationFromEGRNById ID " + id + " ---------");
    doRequest('/api/client/get-info.php', {client_id: id, html: true}, function (html) {
        console.log(html)
        $('.client-contragent-info').html(html)
    });
}


Client.prototype.formSearchClientOpen = function () {
    console.log("------ formSearchClientOpen ---------");
    var form = renderTemplate('client-search-template');
    xmodalShow("Поиск клиента",form);
    
}



var raiting = new Raiting();
function Raiting() {
    this.data = {}
    this.formSubmitHandler = function (data) {
        console.log('=formSubmitHandler=');
        raiting.data = data.result;
        console.log(data);
        console.log(raiting.data);
        $('.VALUE_UF_RAITING').text(raiting.data.UF_RAITING);
    }
}

Raiting.prototype.openServiceEditPopup = function () {
    var form = renderTemplate('raiting-edit-template', raiting.data);
    xmodalShow("Редактирование оценки", form);

}