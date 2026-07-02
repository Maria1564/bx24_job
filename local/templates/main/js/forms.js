var filterFormId = "filter-form";
$(document).ready(function () {
///ajax-search-inn
    // filterGetData();

});

function popupChangeManager(callbackName) {

    var x = window.event.pageX;
    var y = window.event.pageY;
    console.log(screen.height)
    console.log(y)
    if (y > screen.height / 2) {
        y -= 200;
    }
    console.log(app.managers);
    var list = '';
    for (var id in app.managers) {
        list += '<tr><td>' + app.managers[id].FIO + '</td><td><a onclick="' + callbackName + '(' + id + ')">выбрать</a></td><td></td></tr>';
    }
    $('.xmodal-content-title').html('Выберите значение');
	let searchT = '<div><input type="text" name="name" id="mamaner-search" placeholder="Поиск" onkeyup="mamanerJsFilter()" autocomplete="off"></div>';
    $('.xmodal-content-body').html(searchT+'<table id="mamaner-table">' + list + '</table>');
    $('.xmodal-content').css({left: x, top: y})
    $('.xmodal-background').show();
    $('.xmodal-content').show();

}
function mamanerJsFilter(){
	var phrase = document.getElementById('mamaner-search');
    var table = document.getElementById('mamaner-table');
    var regPhrase = new RegExp(phrase.value, 'i');
    var flag = false;
    for (var i = 1; i < table.rows.length; i++) {
        flag = false;
        for (var j = table.rows[i].cells.length - 1; j >= 0; j--) {
            flag = regPhrase.test(table.rows[i].cells[j].innerHTML);
            if (flag) break;
        }
        if (flag) {
            table.rows[i].style.display = "";
        } else {
            table.rows[i].style.display = "none";
        }

    }
	
}
function setManager(id) {
    console.log(id);
    $('#input-manager-id').val(id);
    $('#input-manager-name').text(app.managers[id].FIO);
    xmodalHide();
}
function xmodalHide() {
    $('.xmodal-background').hide();
    $('.xmodal-content').hide();
}
function xmodalShow(title, body1) {
    var body = body1 ? body1 : '<div class="loading"></div>';
    var x = window.event.pageX;
    var y = window.event.pageY + 20;
    console.log(screen.height)
    console.log(y)
    if (y > screen.height / 2) {
        y -= 200;
    }
    $('.xmodal-content-title').html(title);
    $('.xmodal-content-body').html(body);
    $('.xmodal-content').css({left: x, top: y})
    $('.xmodal-background').show();
    $('.xmodal-content').show();

}
function filterGetData() {
    var formData = $('#' + filterFormId).serialize();
    updateURL(formData);
    formData += '&ajax=y';
    // console.log(window.location.href);
    //console.log(formData);
    $.ajax({type: "POST",
        url: window.location.href,
        data: formData, // serializes the form's elements.
        success: function (data) {
            // console.log(data);
            //   console.log(app);
			location.reload(); // fixed 04/09/24
            $('#filter-content').html(data);
			if($('.items-count').length){
            $('.items-count').html(app.data.count);
			}

        }
    });
}

function SetSorting() {
    var sort = $('#sorting__chosen option:checked').val();
    console.log(sort);
    $('#form-sort').val(sort);
    filterGetData();
}
function updateURL(filterData) {
    console.log(filterData);
    if (history.pushState) {
        var baseUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
        var newUrl = baseUrl + '?' + filterData;
        history.pushState(null, null, newUrl);
    } else {
        console.warn('History API не поддерживается');
    }
}

function Search() {
    console.log('Search');
    var q = $('#search-input').val();
    console.log(q.length);
    if (q.length > 1) {
        $.ajax({type: 'GET', url: '/ajax/search.php?ajax=y&q=' + q, dataType: 'html',
            success: function (data) {
                console.log(data);
                $('.search-result').html('<div class="search-inner">' + data + '</div>');

            }
        })
    } else {
        $('.search-result').html('');
    }
}

function formSubmitHandler(_this, CallBack) {
    console.log('formSubmitHandler');
    var url = $(_this).attr('action');
    var $btn = $(_this).find('button.send');
    var formResult = $(_this).find('.form-result');
    var btnText = $($btn).text();
    $btn.text('......').attr('disabled', true);
    console.log(url);
    var formData = $(_this).serialize();
	 console.log(formData);
    $.ajax({type: "POST",
        url: url,
        data: formData, // serializes the form's elements.
        success: function (data) {
		console.log(data);
            $btn.addClass('btn-success').text(btnText).attr('disabled', false);
            if (formResult.length > 0 && data.message !== undefined) {
                formResult.html('<div>' + data.message + '</div>')
                setTimeout(function () {
                    formResult.html('');
                }, 2000);
            }
            setTimeout(function () {
                $btn.removeClass('btn-success')
            }, 2000);

            CallBack(data)

        },
	error:function(data){console.log(data);}
    });
    return false;
}