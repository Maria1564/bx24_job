var searchResult, orgData, userType, company;

$(document).ready(function () {
    
    $('button[type="submit"]').click(function(){
        var _this = this;
        setTimeout(function(){
            $(_this).attr('disabled',true).text('.....');
        },100)
        
        return true;
    });

    $('.fiz-ur-link.active').click();
    var myEfficientFn = debounce(function () {
        if (userType === 'fiz')
            return false;
        searchResult = $(this).data('result');
        var text = $(this).val();
        var len = text.length;
        doRequest(
                "/api/search/org.php",
                {s: text},
                function (result) {
                    makeLIst(result.result);
                });
    }, 500);


    $('#input-org-name').on('keyup', myEfficientFn);
    $('#input-org-inn').on('keyup', myEfficientFn);
    $(document).mouseup(function (e) {
        var container = $(".input-serach-result");
        if (container.has(e.target).length === 0) {
            container.hide();
        }
    });
});

function makeLIst(result) {
    $(searchResult).show();
    // console.log(result);
    orgData = result;
    var t = '';
    for (var key in result) {
        console.log(result[key]);
        var obj = result[key];
        t += '<li><a onclick="setOrgData(' + key + ')">' + obj.NAME + '</a><span>Инн: ' + obj.INN + '</span></li>';

    }
    $(searchResult).html('<div class="sResult"><ul>' + t + '</ul></div>')
}
function setOrgData(id) {
    console.log('==setOrgData==')
    var org = orgData[id];
    console.log(org);
    $('.input-NAME').val(org.NAME);
    $('.input-INN').val(org.INN);
    $('.input-OGRN').val(org.OGRN);
    $('.input-ADDRESS').val(org.ADDRESS);
    $('.input-OKVED').val(org.OKVED);

    if (org.TYPE === 'INDIVIDUAL') {
        $('.input-ORG_TYPE').val(4);
        $('.ooo-user-name-field').hide();
    } else {
        $('.input-ORG_TYPE').val(3);
        $('.ooo-user-name-field').show();
    }
    $(searchResult).html("");
}

function setFormType(type, idOrgType) {
    console.log(type)
    $('.fiz-ur-link').removeClass('active');
    if (type === 'fiz') {
        $('.fiz-hide').hide();
        $('.NAME-field').find('label').text('Фамилия Имя Отчество');
    } else {
        $('.NAME-field').find('label').text('Название ИП или организации');
        $('.fiz-hide').show();
    }
    $('.input-ORG_TYPE').val(idOrgType);
    $('.' + type + '-link').addClass('active');
    userType = type;
}
/*
 * 
 */
var searchCLientFromBx24Handler = function (company1) {
    company = company1
    console.log(company.result);
    if (company.result.length > 0) {
        var list = '<tr>\n\
                      <th>ID</th>\n\
                      <th>Название</th>\n\
                      <th>Выбор</th>\n\
                      <th>Ссылка</th>\n\
                 </tr>';
        for (var id in company.result) {
            list += '<tr id="tr-'+id+'">\n\
                      <td>' + company.result[id].ID + '</td>\n\
                      <td>' + company.result[id].TITLE + '</td>\n\
                      <td><a onclick="setBx24CompanyData(' + id + ')">выбрать</a></td>\n\
                      <td><a href="https://pm.admoblkaluga.ru/crm/company/details/' + company.result[id].ID + '/" target="_blank"> открыть в bitrix24</a></td>\n\
                 </tr>';
        }
        $('.form-result').html('<table>' + list + '</table>');
    } else {
        $('.form-result').html('<center><br><br>Ничего не найдено!</center>');
    }
}
function setBx24CompanyData(number) {
    console.log(company.result[number]);
    var comp = company.result[number];
    $('.input-NAME').val(comp.TITLE);
    $('.input-BX24_COMPANY_ID').val(comp.ID);
    // $('.input-INN').val(org.INN);
    //$('.input-OGRN').val(org.OGRN);
    //$('.input-ADDRESS').val(org.ADDRESS);
    // $('.input-OKVED').val(org.OKVED);
    // $('.input-TYPE').val(org.TYPE);
    // $(searchResult).html("");
}
function popupSelectClientFromBX24() {
    var callbackName = "s";
    var x = window.event.pageX;
    var y = window.event.pageY;
    console.log(screen.height)
    console.log(y)
    if (y > screen.height / 2) {
        y -= 200;
    }


    $('.xmodal-content-title').html('Поиск компании в Bitrix24');
    $('.xmodal-content-body').html(
            '<form action="/api/bx24/company/search.php" onsubmit="formSubmitHandler(this,searchCLientFromBx24Handler);return false;">\n\
                 <input style="width: 400px;padding: 5px;" type="text" class="" name="title" placeholder="Введите название клиента">\n\
                 <button class="send btn btn-primary" >поиск</button>\n\
             </form>\n\
      <div class="form-result"></div>');
    $('.xmodal-content').css({left: x, top: y, height: 'auto'})
    $('.xmodal-background').show();
    $('.xmodal-content').show();
}

var contactTempalte = '';
function addContacts(){
  
  if(contactTempalte!=""){
    $('#contacts-items').append(contactTempalte);
  }
  else 
  {
	  contactTempalte = 	$('#contacts-items').html();
	  $('#contacts-items').show();
  }
	
}

function checkboxRemovePhotoEvent(){

	if($('input[name="PREVIEW_PICTURE_DELETE"]').is(":checked")){
	  $('.client-image').css('opacity','0.3');
	}
	else {
	 $('.client-image').css('opacity','1');
	}
	
}
