var $html = jQuery('html');
var $document = jQuery(document);
var $window = jQuery(window);
var isTouch = $html.hasClass('touch');
var isIE = $html.hasClass('ie');
var pressEvent = isTouch ? 'touchend' : 'click';
var settingPopup = {
    margin: [0, 0],
    image: {
        protect: true
    },
    smallBtn: true,
    toolbar: false,
    lang: "ru",
    i18n: {
        ru: {
            CLOSE: "Закрыть",
            NEXT: "Вперед",
            PREV: "Назад",
            ERROR: "Запрошенный контент не может быть загружен. <br/> Повторите попытку позже.",
            PLAY_START: "Начать слайд-шоу",
            PLAY_STOP: "Пауза слайд-шоу",
            FULL_SCREEN: "На весь экран",
            THUMBS: "Эскизы",
            DOWNLOAD: "Download",
            SHARE: "Поделиться",
            ZOOM: "Увеличить"
        }
    },
    beforeLoad: function() {
        var src = this.src;

        if(this.src.search('#') >= 0) {
            var $cnt = $(this.src);

            $('.error,.has-error,.has_error',$('form',$cnt).trigger('reset')).removeClass('error has-error has_error');
        }

    }
};


jQuery(document).ready(function($) {

    if($.fn.fancybox) {

        $('.js-popup').fancybox(settingPopup);

        $document.on(pressEvent,'.js-close-popup',function(){
            $.fancybox.close();
        });

        // $.fancybox.open({
        //     src  : '#popup__registration',
        //     type : 'inline',
        //     opts : settingPopup
        // });
    }

    if($.fn.styler) $('.js-inp-styled').styler();

    if($.fn.mask) {
        $.mask.definitions['~'] = '[+-]';
        $('.js-mask-tel').mask('+7 ?(999) 999-99-99');
    }

    if($.fn.mCustomScrollbar && !isTouch) {
        $('.js-custom-scroll').mCustomScrollbar();
    }

    if($.validate) {

        $.validate({
            validateOnBlur : false,
            scrollToTopOnError : false,
            borderColorOnError : false,
            errorMessagePosition: $('#help-block-hide'),
            onSuccess : function(form) {

                var action = form.data('ajax-href') || false;

                if(action) {

                    var UTM = '';

                    if($_GET('utm_source')) {
                        UTM = '&utm_source=' + $_GET('utm_source') + '&' +
                            'utm_medium=' + $_GET('utm_medium') + '&' +
                            'utm_campaign=' + $_GET('utm_campaign') + '&' +
                            'utm_content=' + $_GET('utm_content') + '&' +
                            'utm_term=' + $_GET('utm_term');
                    }

                    $.ajax({
                        data: form.serialize() + UTM,
                        type: form.attr('method') || 'POST',
                        url: action,
                        beforeSend: function(){
                            form.addClass('unit-loader');
                        },
                        success: function(data){
                            form.removeClass('unit-loader');
                            showMessage(form,data);
                        }
                    });

                    return false;
                }
            }
        });

        $(document).on('focus','[data-validation]',helpBlockHide);
    }

    if($.fn.scrollspy) {
        $('[data-scrollspy]').scrollspy({
            target: ''
        });
    }

    $document.on(pressEvent,'.js-anchor',function(){
        var $this = $(this);
        var id = $this.attr('href') || $this.data('href');

        $('html, body').stop().animate({ scrollTop: $(id).offset().top }, {
            duration: 'slow',
            easing: 'linear'
        });

        return false;
    });

    $document.on(pressEvent,'.js-overlay',function(){
        var $this = $(this);

        $html.removeClass($this.attr('data-remove-class'));

        $this.remove();
    });

    $document.on(pressEvent,'.js-book',function(){
        var $this = $(this);
        var $contain = $this.closest('[data-book-contain]');
        var id = $this.data('book-id');
        var classOpen = $contain.data('book-classopen');

        $('[data-book="' + id + '"]').slideToggle();

        $contain.hasClass(classOpen) ? $contain.removeClass(classOpen) : $contain.addClass(classOpen);

        return false;
    });


    $document.on(pressEvent,'.js-popover[data-type="click"]',function(){
        var $this = $(this);
        var id = $this.data('popover-content-id');
        var direction = $this.data('popover-direction');
        var $popover = $('[data-popover="' + id + '"]');

        $popover.addClass('unit-popover--' + direction + ' unit-popover--show');

        return false;
    });

    $document.on(pressEvent,'.js-popover-close',function(){
        var $this = $(this);

        $this.parents('[data-popover]').removeClass('unit-popover--show');

        return false;
    });

    $document.on(pressEvent,'.js-sidebar-filter-show',function(){
        var $this = $(this);

        $html.addClass('html--sidebar-filter-show');
        addOverlay($this,'html--sidebar-filter-show');

        return false;
    });

    $document.on(pressEvent,'.js-sidebar-menu-show',function(){
        var $this = $(this);

        $html.addClass('html--sidebar-menu-show');
        addOverlay($this,'html--sidebar-menu-show');

        return false;
    });

    $document.on(pressEvent,'.js-sidebar-filter-close',function(){

        $html.removeClass('html--sidebar-filter-show');
        removeOverlay();

        return false;
    });

    $document.on(pressEvent,'.js-sidebar-menu-close',function(){

        $html.removeClass('html--sidebar-menu-show');
        removeOverlay();

        return false;
    });

    $document.on(pressEvent,'.js-tab',function(){
        var $this = $(this);
        var id = $this.data('tab-id');
        var $contain = $this.closest('[data-tab-contain]');
        var sectionClassActive = $contain.data('tab-section-classactive');
        var tabClassActive = $this.data('tab-classactive');

        $('[data-tab]',$contain).removeClass(sectionClassActive);
        $('[data-tab="' + id + '"]',$contain).addClass(sectionClassActive);

        $('[data-tab-id]',$this.parent()).removeClass(tabClassActive);
        $this.addClass(tabClassActive);

        return false;
    });

    $document.on(pressEvent,'.js-show-all-tags',function(){
        var $this = $(this);
        var classRemoveTags = $this.data('tab-class-hide');
        var $contain = $this.closest('[data-tags-contain]');

        $('.' + classRemoveTags,$contain).removeClass(classRemoveTags);

        $this.closest('[data-tab-more]').remove();

        return false;
    });

    $document.on('change','.js-tab-change',function(){
        var $this = $(this);
        var id = $this.val();
        var $contain = $this.closest('[data-tab-contain]');
        var sectionClassActive = $contain.data('tab-section-classactive');

        console.log(id);

        $('[data-tab]',$contain).removeClass(sectionClassActive);
        $('[data-tab="' + id + '"]',$contain).addClass(sectionClassActive);

        return false;
    });

});

function helpBlockHide() {
    var $parent = $(this).parent();
    $parent.removeClass('has-error');
    $('.error',$parent).removeClass('error').removeAttr('style');
}

function showMessage(form,message) {
    var $message = $(message);
    if($message.data('status-error')) {
        form.prepend($message);
    } else {
        form.html($message);
    }
}

function removeOverlay() {
    $('.unit-overlay[data-remove-class]').remove();
}

function addOverlay($this,className) {
    var insertHtml = '<div class="unit-overlay js-overlay" data-remove-class="' + className + '"></div>';
    var $wrap = $this.parents('[data-overlay]');
    var $overlay = $('.unit-overlay[data-remove-class]');

    if($overlay.length < 1) {

        $wrap.length > 0 ? $wrap.after(insertHtml) : $this.after(insertHtml);
    } else {
        if($('.unit-overlay[data-remove-class="' + className + '"]').length < 1) {
            $html.removeClass($overlay.attr('data-remove-class'));
            $overlay.remove();
            addOverlay($this,className);
        } else {
            $overlay.remove();
        }
    }
}

function $_GET(param) {
    var vars = {};
    window.location.href.replace( location.hash, '' ).replace(
        /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
        function( m, key, value ) { // callback
            vars[key] = value !== undefined ? value : '';
        }
    );

    if ( param ) {
        return vars[param] ? vars[param] : null;
    }
    return vars;
}