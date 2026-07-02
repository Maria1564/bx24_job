//https://frontender.info/essential-javascript-functions/
var popup = new Popup();
function Popup() {

}

Popup.prototype.open = function (configInt) {

    var config = configInt || {};
    console.log(config);
    $('#simpleModal').modal('show')
    doRequest(config.url, configInt, function (data) {
        $('#simpleModal .modal-title').html(data.title)
        $('#simpleModal .modal-body').html(data.body)

    });


}


function doRequest(action, dataObj, callBack) {
    var data = jQuery.param(dataObj);
    $.ajax({type: "POST",
        url: action,
        data: data, // serializes the form's elements.
        success: function (data) {
            //console.log(data);
            if (callBack != undefined) {
                callBack(data);
            }
        },
		error:function(data){
		     console.log('>>>>doRequest:error');
			 console.log(data);
			}
    });
}

function debounce(func, wait, immediate) {
    var timeout;
    return function () {
        var context = this, args = arguments;
        var later = function () {
            timeout = null;
            if (!immediate)
                func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow)
            func.apply(context, args);
    };
}

function renderTemplate(name, data) {
    var template = document.getElementById(name).innerHTML;
 
    for (var property in data) {
        if (data.hasOwnProperty(property)) {
            var search = new RegExp('{' + property + '}', 'g');
            template = template.replace(search, data[property]);
        }
    }
    return template;
}