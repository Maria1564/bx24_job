var filterParams = {sort: "name"};
$(document).ready(function () {
    $('#filter-form input').change(function () {
        FilterUpdate();
    });
    var t = 0;
    if ($('#catalog-list').data('count')) {
        t = $('#catalog-list').data('count');
    }
    $('#filter-total').text(t);

});
function FilterUpdate() {
    var filterData = $('#filter-form input').serialize();
    updateURL(filterData);
    filterData += "&ajax=y";
    $.ajax({
        type: 'POST',
        data: filterData,
        url: '/',
        dataType: 'html',
        success: function (data) {
            //  window.location.search = filterData;
            console.log(data);
            $('.unit-catalog').replaceWith(data);
            var t = 0;
            if ($('#catalog-list').data('count')) {
                t = $('#catalog-list').data('count');
            }
            $('#filter-total').text(t);
            FIlterUpdateTitle();
            FilterMakeLabels();
        }
    })
}
function FIlterUpdateTitle() {
    console.log('FIlterUpdateTitle');

    var h1 = '';
    $('input[name="tag[]"]').each(function () {
        if ($(this).prop('checked') == true) {
            h1 += $(this).data('name') + ', ';
            console.log($(this).data('name'))
        }
    });
    if (h1 === "") {
        h1 = 'Каталог  ';
    }
    $('h1').html(h1.slice(0, -2));
}
function FilterRemove(id) {
    $('#filter-' + id).fadeOut(100, function () {
        $(this).remove()
    })
    $('#filter__contacts-data' + id).prop('checked', false);//.prop('checked',false);
    FilterUpdate();
    $('#filter__contacts-data' + id).closest('div').removeClass('checked');
}
function FilterReset() {
    window.location.href = "/";
}
function updateURL(filterData) {
    if (history.pushState) {
        var baseUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
        var newUrl = baseUrl + '?' + filterData;
        history.pushState(null, null, newUrl);
    } else {
        console.warn('History API не поддерживается');
    }
}

function SetSorting() {
    var sort = $('#sorting__chosen option:checked').val();
    filterParams.sort = sort;
    GetCatalogItems();
}

function GetCatalogItems() {
    var params = window.location.search;
    $.ajax({type: 'POST', data: {ajax: "y", sort: filterParams.sort}, url: '/' + params, dataType: 'html',
        success: function (data) {
            $('.unit-catalog').replaceWith(data);
        }
    })
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

function FilterMakeLabels() {
    var tags = '';
    $('input[name="tag[]"]').each(function () {
        if ($(this).prop('checked') == true) {
            var id = $(this).val();
            tags += '<div class="unit-header__filter-clarification___tags-item" id="filter-' + id + '" >' +
                    '<div class="unit-tag unit-tag--activity">' +
                    '<i class="unit-tag__icon js-" onclick="FilterRemove(' + id + ')"></i>' +
                    '<div class="unit-tag__text">' + $(this).data('name') + '</div>' +
                    '</div>' +
                    '</div>';
        }
    });
    $('#filter-selected-tags').html(tags);
    //
    tags = '';
    $('input[name="city[]"]').each(function () {
        if ($(this).prop('checked') == true) {
            var id = $(this).data('value');
            tags += '<div class="unit-header__filter-clarification___tags-item" id="filter-' + id + '" >' +
                    '<div class="unit-tag unit-tag--activity">' +
                    '<i class="unit-tag__icon js-" onclick="FilterRemove(' + id + ')"></i>' +
                    '<div class="unit-tag__text">' + $(this).data('name') + '</div>' +
                    '</div>' +
                    '</div>';
        }
    });
    $('#filter-selected-city').html(tags);
}


