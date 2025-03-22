/* 
 * 
 * init js
 * 
 */
/* global ymaps, moment, place_coord, Recaptchafree, jsOption, ya, URL, Modernizr */

App = function()
{
   var _scroll_custom;
   function init()
   {
       _validInput();
       _fixedheader();
       _sliderBanners();
       _yaMapMain();
       _sliderMain();
       _eventsCalendar();
       _initSpecial();
       _initSearchBar();
       _filterDocs();
       _scroll_top();
       _imgaePopup();
       _docPopup();
       _controlQuestion();   
       _modalCenterPage();
       _internetReception();
       _initInputCalendar();
       _mainMenu();
       $('[data-toggle="tooltip"]').tooltip();
       
   }
   function onload()
   {
       _scroll_custom = $('.scrollbar-outer, .scrollbar-theme').scrollbar({
           ignoreMobile: false,
           ignoreOverlay: false
       });
       initSpeech();
   }
   /**
    * toggle type send
    * @returns {undefined}
    */
   function _internetReception(){
        $("input[name='send']").on("click", function(){
           $(".form-group__type-send").toggle();
        });
   }
   /**
    * init input calendar
    * @returns {undefined}
    */
   function _initInputCalendar(){
        $('input[data-input-date]').datetimepicker({
            inline: false,
            sideBySide: false,
            useCurrent: true,
            locale: 'ru',
            format: 'DD.MM.YYYY'
        });  
   }
   /**
    * valid input add class
    * @returns {undefined}
    */
   function _validInput(){
        $('input, textarea').each(function(){
           var val = $(this).val();
            if(val.length > 0){
                $(this).addClass("valid");
            } else{
                $(this).removeClass("valid");
            }
        });
        $('body').on("keypress, change", 'input, textarea', function(){
            var val = $(this).val();
            if(val.length > 0){
                $(this).addClass("valid");
            } else{
                $(this).removeClass("valid");
            }
        });
    }
    /**
     * popup on success message
     * @param {type} text
     * @returns false
     */
    function _okPopupMessage(text){
        var $modal_success = $("#modal_success");
        if ($modal_success.length < 1) {
           $("#modal_classic").clone().attr("id", "modal_success").appendTo("body");
            $modal_success = $("#modal_success");
            $modal_success.find('.modal-dialog').addClass("modal-sm");
        }
        $modal_success.find('.modal-body').html(text);
        setTimeout(function(){
           $modal_success.modal('show');
        }, 600);
        
        return false;
    }

    function _controlQuestion(){
        
        // toogle show answer
        $(".link-open-question").click(function(){
            var $this = $(this);
            var id = $this.attr("href");
            $this.toggleClass("open");
            $(id).removeClass("hidden").slideToggle("slow");
            if($this.hasClass("open")){
                $this.children("i.fa").attr("class", "fa fa-chevron-up");
            } else {
                $this.children("i.fa").attr("class", "fa fa-chevron-down");
            }
            return false;
        });
        
        // popup open, load form
        $('*[data-toggle="modal_classic"]').on('click', function (event) {
            var $this = $(this);
            var modal = $this.data("target");
            if ($(modal).length < 1) {
                $("#modal_classic").clone().attr("id", modal.substring(1)).appendTo("body");
                var page = $this.data("load-page");
                var title = $this.data("title");
                var $modal = $(modal);
                $modal.find('.modal-title').text(title);
                var jqxhr = $.ajax({
                    url: page,
                    dataType: "html",
                    method: "GET",
                    cache: false,
                    data: {"AJAX_PAGE": "Y"}
                }).done(function (data) {
                    var html = $(data).find(".box-body");
                    $modal.find('.modal-body').html(html);
                    _validInput();
                    loadUserConsent();
                    $modal.modal('show');
                }).fail(function () {
                    $modal.find('.modal-body').html("Ошибка запроса, повторите операцию позже или обратитесь к администратору сайта");
                    $modal.modal('show');
                }).always(function () {
                    if(window.Recaptchafree !== undefined){
                         Recaptchafree.reset();
                    }
                });
            } else{
                var $modal = $(modal);
                $modal.modal('show');
            }
            
        });
        
        // userconsent
        function loadUserConsent(){
            try{
                BX.UserConsent.loadFromForms();
                if (!BX.UserConsent)
                {
                    return;
                }
                var control = BX.UserConsent.load(BX('userconsent-container'));
                if (!control)
                {
                    return;
                }
                
                BX.addCustomEvent(
                    control,
                    BX.UserConsent.events.save,
                    function (data) {
                        var form = $("form[name='question_form']");
                        if(form.data("submit") == "Y"){ // if click button submit
                            form.trigger("submit");
                            form.data("submit", "N");
                        }
                    }
                );  
                BX.addCustomEvent(
                    control,
                    BX.UserConsent.events.refused,
                    function () {  
                        $("form[name='question_form']").data("submit", "N");
                    }
                );   
            } catch(e){
                console.log("error BX.UserConsent.loadFromForms");
            }
        }

        BX.ready(function () {
            loadUserConsent();
        });
        
        // load userconsent click
        $(document).on("click", "form[name='question_form'] input[type='submit']", function () {
            $(this).closest("form").data("submit", "Y");
            BX.onCustomEvent('userconsent-event', []);
            return false;
        });
        
        //ajax form
        $(document).on("submit", "form[name='question_form']", function () {
            var $name = $("input[name='user_name']", $(this)),
                $mail = $("input[name='user_email']", $(this)),
                $phone = $("input[name='user_phone']", $(this)),
                $q_categ = $("select[name='q_categ']", $(this)),
                $message = $("textarea[name='MESSAGE']", $(this)),
                $btn = $("button[type='submit']", $(this));
            var $form = $(this);
            var $wrap_form = $(this).parent(".mfeedback");
            var pattern = /^[a-zA-Z0-9_.+-]+@[a-z0-9-]+\.[a-z]{2,6}$/i;
            var flag_error = "N";
            var flag_ajax = 0;

            if($name.val().length === 0){
                setError($name, "Укажите, как к Вам обращаться");
                flag_error = "Y";
            }
            else if ($name.val().length < 3) {
                setError($name, "Должно быть не менее 3-х символов");
                flag_error = "Y";
            }
            else {
                removeError($name);  
            }

            if($message.val().length === 0){
                setError($message, "Не заполнены обязательные поля");
                flag_error = "Y";
            } else if ($message.val().length < 10) {
                setError($message, "Должно быть не менее 10-х символов");
                flag_error = "Y";
            } else if ($message.val().length > 500) {
                setError($message, "Должно быть не более 500 символов");
                flag_error = "Y";
            } else {
                removeError($message);  
            } 
            
            if ($mail.val().length === 0) {
               setError($mail, "Не заполнены обязательные поля");
               flag_error = "Y";
            } else if(!pattern.test($mail.val())){
                setError($mail, "Ошибка! Введен некорректный адрес email");
                flag_error = "Y";
            } else {
               removeError($mail);
            }

            if ($phone.val().length === 0) {
                setError($phone, "Введите номер телефона");
                flag_error = "Y";
            } else {
                removeError($mail);
            }

            if ($q_categ.val() === "" || $q_categ.val() === null) {
                setError($q_categ, "Выберите категорию");
                flag_error = "Y";
            } else {
                removeError($q_categ);
            }

            if (flag_error === "N" && flag_ajax !== 1) {
                flag_ajax = 1;
                $btn.prop("disabled", true);
                
                $.ajax({
                    type: $form.attr("method"),
                    url: $form.attr("action"),
                    data: $form.serialize() + "&submit=y&AJAX_PAGE=Y",
                    cache: false,
                    dataType: "html"
                }).done(function (data, textStatus, jqXHR) {
                   var html = $(data).find(".mfeedback");
                   $wrap_form.replaceWith(html);
                   var ok_message = $(data).find(".ok-message");
                   if(ok_message.length === 1){
                       $('#modal_question').modal('hide');
                       _okPopupMessage(ok_message.html());
                   }
                   loadUserConsent();
                }).fail(function (jqXHR, textStatus, errorThrown) {
                     alert(textStatus+": " +  errorThrown);
                }).always(function (jqXHR, textStatus) {
                    flag_ajax = 0;
                    $btn.prop("disabled", false);
                    if(window.Recaptchafree !== undefined){
                        Recaptchafree.reset();
                    }
                    _validInput();
                });
            }
            return false;
        });
        function setErrorCheckbox($el, text){
            $el.parent(".checkbox").addClass("has-error");
            $el.next().next(".help-block").remove();
            $el.parent(".checkbox").append( "<span class='help-block'>"+text+"</span>" );
        }
        function removeErrorCheckbox($el){
            $el.parent(".checkbox").removeClass("has-error");
            $el.next().next(".help-block").remove();
        }
        function setError($el, text){
            $el.closest(".form-group").addClass("has-error");
            $el.next().next(".help-block").remove();
            $el.parent(".form-group").append( "<span class='help-block'>"+text+"</span>" );
        }
        function removeError($el){
            $el.closest(".form-group").removeClass("has-error");
            $el.next().next(".help-block").remove();
        } 
    }
   
   function _docPopup(){
       $('a.view_popup_doc').on("click", function(){
           var link = $(this).attr("href");
           var title = $(this).attr("title");
           var ext  = link.split('.').pop();
          
           var jqxhr = $.ajax({
               url: link,
               dataType: "html",
               method: "GET",
               cache: false
           }).done(function(data) {
                $("#modal_doc .modal-title").html(title);
                $("#modal_doc .modal-body").html(data);
                $("#modal_doc").modal('show');
                
            });
            return false;
       });
       
   }
   function _mainMenu(){
        var isTouch = ('ontouchstart' in document.documentElement) || false;
        if(isTouch){
            $(".nav-main .dropdown-toggle").on("touchstart", toggleDropdown);
        } else {
            $(".nav-main .dropdown-toggle").on("mouseenter", toggleDropdown);
        }
        function toggleDropdown(event){
            var self = this,
            menu = $(".nav-main"),
            li,
            rectBoundList = 0,
            rectBoundMenu = 0,
            list;
            list = $(self).next("ul");
            list.css({"left": "", "display": "block"});
            rectBoundList = list[0].getBoundingClientRect();
            rectBoundMenu = menu[0].getBoundingClientRect();
            list.css({"display": ""});
            if(rectBoundMenu.right < rectBoundList.right){
                list.css({"left": "-" + (rectBoundList.right - rectBoundMenu.right) + "px"});
            } 
            if(event.type === 'mouseenter'){
               $(self).attr('aria-expanded', 'true');
               li = $(self).parent("li.dropdown");
               li.addClass('open');       
            }
        }
   }
   function _imgaePopup(){
       $('.chocolat-gallery').Chocolat();
   }
   
   function _scroll_top(){
       $('a[href^="#"]').click(function(){
		   var archor = $('a[name="'+this.hash.slice(1)+'"]');
		   if(archor.length > 0){
			   $('html, body').animate({ scrollTop:  $('a[name="'+this.hash.slice(1)+'"]').offset().top - 100 }, 1000 ); 
			   return false;
		   }
        });
   }
   
   function _filterDocs(){
        var $range = $('input[data-input="daterange"]');
        var range_date = $range.val(); 
        $range.daterangepicker({
                "autoApply": true,
                "applyClass": "btn-info",
                "cancelClass": "btn-info",
                "locale": {
                     "applyLabel": "Готово",
                     "cancelLabel": "Закрыть",
                     "fromLabel": "От",
                     "toLabel": "До"
                 }
        });
        if(range_date !== undefined){
            if(range_date.length === 0 ){
                var start = moment().subtract(30, 'days');
                var end = moment();
                $range.data('daterangepicker').setStartDate(start);
                $range.data('daterangepicker').setEndDate(end);
             }
        }
        
   };
   
   function _initSearchBar(){
       var scroll_width = 0;
       $('#search-panel').on('hidden.bs.collapse', function () {
            $("body").removeClass("no-scroll").css({"padding-right": ""});
            $(".bt-overlay").remove();
            $('input[type="text"]').blur();
            
       });
       $('#search-panel').on('show.bs.collapse', function () {
            scroll_width = window.innerWidth - document.documentElement.clientWidth;
            $("body").addClass("no-scroll").append('<div class="bt-overlay"></div>');
           // if(!$("body").hasClass("special")){
                $("body").css({"padding-right": scroll_width});
          //  }
            $('input[type="text"]').focus();
       });
       $('#search-panel').on('show.bs.collapse', function () {
            $('html, body').animate({scrollTop: 0}, 500);
       });
       $('#search-panel').on('shown.bs.collapse', function () {
            $('input[type="text"]').focus();
       });
       $('body').on('click', ".bt-overlay", function () {
           $('#search-panel').collapse('hide');
       });
       $('#search-panel .close').on('click', function () {
           $('#search-panel').collapse('hide');
       });
       $('.upper').on("click", function(){
           $('html, body').animate({scrollTop: 0}, 500);
       });
   }
   function _initSpecial(){
        var strClassFontSize = 'fz-medium fz-large';
        var strClassFontFamily = 'ff-serif';
        var strClassColor = 'tm-white tm-black tm-blue tm-brown';
        var strClassInterval = 'interval-medium interval-large';
        /*init special*/
        $('a.special').on("click", function (e) {
            //$.removeCookie('special_param', { path: '/'});
            var cookie = $.cookie('special_param');
            if(cookie === undefined) {
                cookie = JSON.stringify({"special": "Y", "theme": "tm-white", "fz": "", "ls": "", "ff": "", "image": "Y"});
            } else {
                var ar_param = JSON.parse(cookie);
                ar_param.special = "Y";
                cookie = JSON.stringify(ar_param);
            }
            $.cookie('special_param', cookie, { path: '/'});
            setSpecialParam();
            return false;
        });
        /*panel settings show*/
        $('#link_settings').click(function(){
            $('.settings-panel').slideToggle("slow");
        });
        /*panel settings close*/
        $(document).on("click", function (e) {
            var container = $(".special-panel");
            if (container.has(e.target).length === 0){
                $('.settings-panel').slideUp("slow");
            }
        });
        /*off special*/
        $('button.normal-version').on("click", function (e) {
            setParamCookie("special", "N");
            $('body').removeClass('special hide-image '+strClassFontSize +' '+ strClassFontFamily+' '+ strClassColor+' '+ strClassInterval);
        });
        /* font size */
        $('.font-size button').on("click", function(){
            $('.font-size button').removeClass("active");
            var attr = $(this).addClass('active').data("font-size");
            $('body').removeClass(strClassFontSize).addClass(attr);
            setParamCookie("fz", attr);
        });
        /* font family */
        $('.font-family button').click(function(){
            $('.font-family button').removeClass("active");
            var attr = $(this).addClass('active').data("font-family");
            $('button[data-font-family="'+attr+'"]').addClass('active');
            $('body').removeClass(strClassFontFamily).addClass(attr);
            setParamCookie("ff", attr);
        });
        /* modify theme */
        $('.color button').click(function(){
            $('.color button').removeClass("active");
            var attr = $(this).addClass('active').data("color");
            $('button[data-color="'+attr+'"]').addClass('active');
            $('body').removeClass(strClassColor).addClass(attr);
            setParamCookie("theme", attr);
        });
        /* modify char-interval */
        $('.char-interval button').click(function(){
            $('.char-interval button').removeClass("active");
            var attr = $(this).addClass('active').data("interval");
            $('body').removeClass(strClassInterval).addClass(attr);
            setParamCookie("ls", attr);
        });
        /* modify img show */
        $('.img-show-button').click(function(){
            var attr = $(this).data("image");
            var show_image = "Y";
            if(attr === "Y"){	
                $(this).children("i.fa").removeClass("fa-check-square-o").addClass("fa-square-o");
                show_image = "N";
                $('body').addClass("hide-image");
            } else{  
                $(this).children("i.fa").removeClass("fa-square-o").addClass("fa-check-square-o");
                show_image = "Y";
                $('body').removeClass("hide-image");
            }
            $(this).data("image", show_image);;
            setParamCookie("image", show_image);
        });
           
        function setParamCookie(param, data){
            var cookie = $.cookie('special_param');
            var ar_param;
            if(cookie !== undefined) {
                ar_param = JSON.parse(cookie);
                ar_param[param] = data;
                cookie = JSON.stringify(ar_param);
                $.cookie('special_param', cookie, { path: '/'});
            }
        }
        function setSpecialParam(){
            var cookie = $.cookie('special_param');
            if(cookie !== undefined) {
                var ar_param = JSON.parse(cookie);
                if(ar_param.special === "Y"){
                    var _class = "special";
                    if(ar_param.theme !== undefined) {
                        $('.color button').removeClass("active");
                        $('button[data-color="'+ar_param.theme+'"]').addClass('active');
                        _class += ' '+ar_param.theme;
                    } else {
                        $('button[data-color="tm-white"]').addClass('active');
                        _class += ' tm-white';
                    }
                    if(ar_param.fz !== undefined) {
                        $('.font-size button').removeClass("active");
                        $('button[data-font-size="'+ar_param.fz+'"]').addClass('active');
                        _class += ' '+ar_param.fz;
                    } else {
                        $('button[data-font-size=""]').addClass('active');
                    }
                    if(ar_param.ff !== undefined) {
                        $('.font-family button').removeClass("active");
                        $('button[data-font-family="'+ar_param.ff+'"]').trigger("click");
                        _class += ' '+ar_param.ff;
                    } else {
                        $('button[data-font-family=""]').addClass('active');
                    }
                    if(ar_param.ls !== undefined) {
                        $('.char-interval button').removeClass("active");
                        $('button[data-interval="'+ar_param.ls+'"]').addClass('active');
                        _class += ' '+ar_param.ls;
                    } else{
                        $('button[data-interval=""]').addClass('active');
                    } 
                    if(ar_param.image === "N") {
                        $('.img-show-button').find("i.fa").removeClass("fa-check-square-o").addClass("fa-square-o").data("image", "N");
                        _class += ' hide-image';
                    } else{
                        $('.img-show-button').find("i.fa").removeClass("fa-square-o").addClass("fa-check-square-o").data("image", "Y");
                        $('body').removeClass("hide-image");
                    }
					$('body').addClass(_class);
                }
            }                
        }
        setSpecialParam();
   }

   function _eventsCalendar(){
        var arDate = [], // массив дат событий
            arDateNew = [], // текущие и будущие события
            start_date = new Date(); // дата с ближайшим событием

        $(".list-events-main .item").each(function(){
            var data = $(this).data("date");
            var date_events = moment(data, "DD.MM.YYYY");
            var date_today = moment();
            if(date_today.isBefore(date_events)){ // если дата равна текущей или больше ее, то в новые события
                arDateNew.push(data);
            }
            arDate.push(data);
        });
        

        if(arDateNew.length > 0){
            start_date = moment(arDateNew[0], "DD.MM.YYYY").format("MM/DD/YYYY");
        }     
        
        $('#datetimepicker-events').datetimepicker({
            inline: true,
            sideBySide: false,
            useCurrent: false,
            defaultDate: start_date,
            locale: 'ru',
            format: 'DD.MM.YYYY',
            icons:{
                previous: 'ion ion-ios-play-outline ion-rotate-180',
                next: 'ion ion-ios-play-outline'
            }
        }).on("dp.change", function(date){
			console.log('date changed = ' + date);
			
			var currentHost = window.location.hostname;
			var selectedDate = e.date.format("DD.MM.YYYY");
			var paramsQ = {
				'arrFilter_DATE_ACTIVE_FROM_1': selectedDate + ' 00:00:00',
				'arrFilter_DATE_ACTIVE_FROM_2': selectedDate + ' 23:59:00',
				'set_filter':'Y'
			};

			var dateQueryString = Object.keys(paramsQ).map((key) => {
				return encodeURIComponent(key) + '=' + encodeURIComponent(paramsQ[key])
			}).join('&');

			var detailRedirect = '//' + currentHost + '/news/?' + dateQueryString;

			window.location.replace(detailRedirect);
			
			
			
           $(this).data("DateTimePicker").enabledDates(arDate);
           $(".list-events-main .item").hide();
           $('.list-events-main .item[data-date="'+date.date.format("DD.MM.YYYY")+'"]').fadeIn("slow");
        }).on("dp.update", function(date){
			console.log('date updated');
            $(this).data("DateTimePicker").enabledDates(arDate);
        }).on("dp.load", function(){
			// console.log('date loaded');
			// console.log('arDate = '+ arDate);
             $(this).data("DateTimePicker").enabledDates(arDate);
             $('.list-events-main .item[data-date="'+arDateNew[0]+'"]').fadeIn("slow");
        }).trigger("dp.load");  
   }
   function _sliderMain(){
        var owl_slider = $('.owl-slider-main').owlCarousel({
             loop:true,
             margin:0,
             nav:true,
             dots: true,
             items: 1,
             autoplay: true,
             autoplayHoverPause: true,
             navText: ['<i class="ion ion-ios-arrow-left"></i>', '<i class="ion ion-ios-arrow-right"></i>']
        });
   }
   function _sliderBanners(){
	   var carusel = $('.owl-banners-main');
	   var loop = (carusel.data("items") > 4) ? true : false;
	   if(loop) {
		   $(".wrap-main-banners .arrow-banners").show();
	   }
	   var owl = $('.owl-banners-main').owlCarousel({
             loop:loop,
             margin:0,
             nav:false,
             dots: false,
             responsive:{
                 0:{
                     items:1
                 },
                 750:{
                     items:2
                 },
                 992:{
                     items:3
                 },
                 1200:{
                     items:4
                 }   
             }
        });       
        $('.next-banners-main').click(function() {
            owl.trigger('next.owl.carousel');
            return false;
        });
        $('.prev-banners-main').click(function() {
            owl.trigger('prev.owl.carousel');
            return false;
        });
   }
   function _fixedheader(){
        var time = 0;
        $(window).on("resize", function(){
            clearTimeout(time);
            time = setTimeout(function(){
                var width_window = $(window).width();
                if(width_window < 768){
                    $('.wrap-fix-menu').removeClass('navbar-fixed-top');
                }
            }, 80);
        });
        $(window).scroll(function(e){
            var offset_top = $('.header-top').height(),
                scrollTop = $(document).scrollTop(),
                width_window = $(window).width();
            if(scrollTop > offset_top && width_window > 767){
                $('.wrap-fix-menu').addClass('navbar-fixed-top');
            } else {
                $('.wrap-fix-menu').removeClass('navbar-fixed-top');
                
            }
        });
   }
  
    /**
    * bootstrap modal center page
    * @returns false
    */
   function _modalCenterPage(){
              
        function setModalMaxHeight(element) {
            this.$element = $(element);
            this.$content = this.$element.find('.modal-content');
            var borderWidth = this.$content.outerHeight() - this.$content.innerHeight();
            var dialogMargin = $(window).width() < 768 ? 20 : 60;
            var contentHeight = $(window).height() - (dialogMargin + borderWidth);
            var headerHeight = this.$element.find('.modal-header').outerHeight() || 0;
            var footerHeight = this.$element.find('.modal-footer').outerHeight() || 0;
            var maxHeight = contentHeight - (headerHeight + footerHeight);

            this.$content.css({
                'overflow': 'hidden'
            });

            this.$element
                    .find('.modal-body').css({
                'max-height': maxHeight,
                'overflow-y': 'auto'
            });
        }

        $('.modal.center').on('show.bs.modal', function () {
            $(this).show();
            setModalMaxHeight(this);
        });

        $(window).on("resize", function () {
            if ($('.modal.center.in').length != 0) {
                setModalMaxHeight($('.modal.center.in'));
            }
        });
       return false;  
   }
   
    /*
     * sound select text ya
     * @returns {undefined}
     */
    function initSpeech(){
        var timePlaySound; // timer sound play
        var statusAudio = 'stop';    // stop || play   
        var audio = new Audio(); // audio
        var text = "";
        
        if(jsOption["type_voice"] == "ya"){  
            window.ya.speechkit.settings.lang = 'ru-RU';
            window.ya.speechkit.settings.apikey = jsOption["speechkit_apikey"];
            window.ya.speechkit.settings.model = 'notes';
            var tts = new ya.speechkit.Tts({ // sound obj
              emotion: 'good',
              speed: 1.1,
              speaker: 'jane'  
            });
            if(!jsOption["speechkit_apikey"] || jsOption["speechkit_apikey"] === "" || jsOption["speechkit_apikey"] === " "){ // not set api key yandex
                return;
            }
        } 
        
        audio.volume = 1;  // set volume max
        
        // hide || show 
        if($("body").hasClass("special")){
           $(".soundbar").removeClass("hide");
        } 
        $('a.special').on("click", function (e) {
            $(".soundbar").removeClass("hide");
        });
        $('button.normal-version').on("click", function (e) {
            $(".soundbar").addClass("hide");
        });

        if ('ontouchstart' in document.documentElement) {
             return;
        }
        
        $(".soundbar").removeClass("soundbar_hide"); // add soundbar
             
        $(".wrap-content").on("mouseup", function (e) { // select text and show button play
            var mouse_x, mouse_y;
            text = getSelectedText();
            var buttonPlay = $(".soundcursor"); 
            if(text && $("body").hasClass("special")){
                mouse_x = e.pageX;
                mouse_y = e.pageY;
                if(buttonPlay.length === 0){
                    $("body").append('<button class="soundcursor"><div class="soundcursor__icon"><i class="fa fa-play" aria-hidden="true"></i></div></button>');
                } 
                $(".soundcursor").css({"top": (mouse_y - 25), "left": (mouse_x + 10)});
            } else {
               $(".soundcursor").remove();
            }
        }).on("mousedown", function(){ // remove select text before new select
            removeSelectedText();
        });
                
        $("body").on("click", ".soundcursor", function(e){ // event button click play
            if(text){
                if(text.length > 3000){ // lenght message
                    var $modal_error = $("#modal_error");
                    if ($modal_error.length < 1) {
                       $("#modal_classic").clone().attr("id", "modal_error").appendTo("body");
                        $modal_error = $("#modal_error");
                    }
                    $modal_error.find('.modal-dialog').addClass("modal-sm");
                    $modal_error.find('.modal-title').html("Ошибка");
                    $modal_error.find('.modal-body').html("Выделенный текст должен иметь меньше 3000 символов, текущий размер - " + text.length + " символов");
                    $modal_error.modal('show');
                } else { // play
                    $(".soundbar_loader").removeClass("soundbar_loader_hide");
                    $(".soundbar__play").addClass("soundbar__play_hide");
                    playAudio(text);
                }
                
            }
            $(".soundcursor").remove();
            return false;
        });
        
        
        $(audio).on("ended", function(){ //event end play
            clearInterval(timePlaySound);
            $(".soundbar__play").removeClass("soundbar__play_hide");
            $(".soundbar__timers").addClass("soundbar__timers_hide");
        }).on("loadedmetadata", function(){ //event add lenght sound
            $(".soundbar__duration-time").text(formatTime(audio.duration));
        });
        
        // stop play
         $(".soundbar").on("click", function(){ // stop play
            audio.pause();
            statusAudio = "stop";
            $(".soundbar__play").removeClass("soundbar__play_hide");
            $(".soundbar__timers").addClass("soundbar__timers_hide");
            $(".soundbar_loader").addClass("soundbar_loader_hide");
            if(jsOption["type_voice"] == "rv"){
                responsiveVoice.cancel();
            }
         });
        

        // play text
        function playAudio(text){
            
            if(jsOption["type_voice"] == "ya"){
                audio.pause();
                statusAudio = "play";
                tts.speak(text,{
                    dataCallback: function (blob) {
                        if(statusAudio === "stop") return;
                        audio.src = URL.createObjectURL(blob);     
                        audio.play();	
                        $(".soundbar_loader").addClass("soundbar_loader_hide");
                        $(".soundbar__play").addClass("soundbar__play_hide");
                        $(".soundbar__timers").removeClass("soundbar__timers_hide");
                        timePlaySound = setInterval(function(){
                            $(".soundbar__curretn-time").text(formatTime(audio.currentTime));
                        }, 1000);
                    }
                });  
            } else if(jsOption["type_voice"] == "rv"){
                if(responsiveVoice.voiceSupport()) {
                    responsiveVoice.speak(text, "Russian Female",{
                        onstart: function(){
                            $(".soundbar_loader").addClass("soundbar_loader_hide");
                            $(".soundbar__play").addClass("soundbar__play_hide");
                            $(".soundbar__timers").removeClass("soundbar__timers_hide");
                            $(".soundbar__duration-time").html("&nbsp;");
                            $(".soundbar__curretn-time").html("&nbsp;");
                        }, 
                        onend: function(){
                            $(".soundbar__play").removeClass("soundbar__play_hide");
                            $(".soundbar__timers").addClass("soundbar__timers_hide");
                        }
                    });
               }
            }
            
        }
   }
   
   /**
    * format seconds in 00:00:00
    * @param {type} secs
    * @returns {String} 00:00:00
    */
   function formatTime(secs){
        var obTime = secondsToTime(secs);
        var strTime = "";
        if(obTime.h > 0){
            strTime = ('00' + obTime.h).slice(-2) + ":";
        }
        strTime += ('00' + obTime.m).slice(-2) + ":" +('00' + obTime.s).slice(-2);
        return strTime;
    }
   
    /**
     * get object in seconds 
     * @param {type} secs
     * @returns {init_L8.secondsToTime.obj}
     */
    function secondsToTime(secs){
        secs = Math.round(secs);
        var hours = Math.floor(secs / (60 * 60));

        var divisor_for_minutes = secs % (60 * 60);
        var minutes = Math.floor(divisor_for_minutes / 60);

        var divisor_for_seconds = divisor_for_minutes % 60;
        var seconds = Math.ceil(divisor_for_seconds);

        var obj = {
            "h": hours,
            "m": minutes,
            "s": seconds
        };
        return obj;
    }

    /*
     * get selection text
     * @returns {window@call;getSelection.text|document.selection@call;createRange.text}
     */
    function getSelectedText() {
        var selText = "";
        if (window.getSelection) {  // all browsers, except IE before version 9
            if (document.activeElement &&
                    (document.activeElement.tagName.toLowerCase() === "textarea" ||
                            document.activeElement.tagName.toLowerCase() === "input"))
            {
                var text = document.activeElement.value;
                selText = text.substring(document.activeElement.selectionStart,
                        document.activeElement.selectionEnd);
            } else {
                try {
                    if (window.getSelection) {
                        var selRange = window.getSelection().toString();
                    } else {
                        var selRange = document.getSelection();
                    }
                }catch (err) {
                    console.log(err);
                }
                selText = selRange;
            }
        } else {
            if (document.selection.createRange) { // Internet Explorer
                var range = document.selection.createRange();
                selText = range.text;
            }
        }
        if (selText !== "") {
            return selText;
        } else {
            return false;
        }
    }
    
    /*
     * remove selected text
     * @returns {Boolean}
     */
    function removeSelectedText() {
        if (window.getSelection) {
            if (window.getSelection().empty) {  // Chrome
                window.getSelection().empty();
            } else if (window.getSelection().removeAllRanges) {  // Firefox
                window.getSelection().removeAllRanges();
            }
        } else if (document.selection) {  // IE?
            document.selection.empty();
        }
        return true;
    }
    
    function loadScript(url, callback){
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.async = true;
        if (script.readyState){  //IE
            script.onreadystatechange = function(){
                if (script.readyState === "loaded" ||
                        script.readyState === "complete"){
                    script.onreadystatechange = null;
                    callback();
                }
            };
        } else {  //Others
            script.onload = function(){
                callback();
            };
        }
        script.src = url;
        document.getElementsByTagName("head")[0].appendChild(script);
    }
    
    function supports_html5_storage(){
        try {
          return 'localStorage' in window && window['localStorage'] !== null;
      } catch (e) {
          return false;
        }
    }
    
    function _yaMapMain(){

        var map_id = document.querySelector('#ya-map-main');
                
        if(!map_id){  
            return false;
        }     
                
        if(typeof jsOption["api_map_key_ya"] === "undefined"){  
            console.warn("twim.gossite: not key api map yandex;");
            return false;
        }

        if(typeof window.ymaps !== "undefined"){
           initMap();
        } else {
           loadScript('https://api-maps.yandex.ru/2.1/?apikey='+jsOption["api_map_key_ya"]+'&lang=ru_RU', initMap);
        }

        function initMap() {
            ymaps.ready(function(){
                var  coord, title, myMap, myPlacemark, iconColor = "#0e4779";
                
                if(typeof jsOption["coord_ya"] === "undefined"){  
                    console.warn("twim.gossite: not set coord map yandex;");
                    return false;
                }     
                if(typeof jsOption["ya_map_iconColor"] !== "undefined"){  
                    iconColor = jsOption["ya_map_iconColor"];
                }
                
                title = map_id.getAttribute("data-title");
                coord = coordsToArray(jsOption["coord_ya"]);
                
                if(!coord){
                   console.warn("twim.gossite: not valid coord map yandex;");
                   return false;
                }
                
                myMap = new ymaps.Map('ya-map-main', {
                        center: coord,
                        zoom: 10,
                        controls: ['zoomControl', 'fullscreenControl', 'trafficControl', 'typeSelector', 'geolocationControl']     
                    });
                    
                myMap.behaviors.disable(['scrollZoom']); 
                myMap.container.fitToViewport();
                 
                myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
                    iconCaption: title
                }, {
                    preset: 'islands#icon',
                    iconColor: iconColor
                });
                 
                myMap.geoObjects.add(myPlacemark);          
            });
        };
        
        function coordsToArray(coordsStr){
            var arCoords = coordsStr.split(",");
            for (var index = 0; index < arCoords.length; index++) {
                arCoords[index] = arCoords[index].trim();
            }
            if(Array.isArray(arCoords) && arCoords.length >= 2){
                return arCoords;
            } else {
                return false;
            }  
        }
   }
    
   return {
       init: init,
       onload: onload,
       getSelectedText: getSelectedText,
       removeSelectedText: removeSelectedText,
       secondsToTime: secondsToTime, 
       formatTime: formatTime,
       loadScript: loadScript,
       supports_html5_storage: supports_html5_storage
   };
}();


// internet recieption
var AppIR = function(){

    function init(){
        _toggleAgancy();
        _toggleSecondName();
        _addCouthor();
        _toggleRegistration();
        _fileInputCustom();
        _initPopup();
    }
    
    /**
     * переключение категорий и выбор органа для обращения
     * @returns {undefined}
     */
    function _toggleAgancy(){
        $("input[data-category]").change(function(e){
           var $self = $(this);
           var category = $self.val();
           var selectActiveCategory = $(".wrap-select[data-category-toggle="+category+"]");
           selectActiveCategory.removeClass("hidden");
           selectActiveCategory.find("select").prop("disabled", false);
           $(".wrap-select[data-category-toggle]").not(selectActiveCategory).addClass("hidden").find("select").prop("disabled", true);
        });
    }
    /**
     * отключение поля отчества
     * @returns {undefined}
     */
    function _toggleSecondName(){
        $('input[data-disabled-input]').change(function(){
            var $self = $(this);
            var input = $self.data("disabled-input");
            if($self.prop('checked')){
                $(input).prop("disabled", true);
            } else {
                $(input).prop("disabled", false);
            }
        });
    }
    /**
     * Упарвление соавторами
     * @returns {undefined}
     */
    function _addCouthor(){
        var template =  $("#coauthor-template").html();
        var $wrapper = $(".ir-coauthors-include");
        var $couthors = $wrapper.find(".ir-coauthor");
        var countCouthors = $couthors.length;
        
        $couthors.find(".ir-coauthor_btn").on("click", function(e){
            $(this).parents(".ir-coauthor").remove();
        });
        
        $("#add-coauthor").on("click", function(e){
            countCouthors++;
            var tempCouthor = template.replace(/#ID#/gi, countCouthors);
            var $coauthor = $(tempCouthor);
            var $btnRemoveCouthor = $coauthor.find(".ir-coauthor_btn");
            $btnRemoveCouthor.on("click", function(e){
                $coauthor.remove();
            });
            $wrapper.append($coauthor);
        });  
    }
    /**
     * управление файлами
     * @returns {undefined}
     */
    function _fileInputCustom(){
        var $wrapper = $( ".file-upload" );   
        
        initCustonFile($wrapper);
        
        function initCustonFile($input){
            var wrapper = $input,
            inp = wrapper.find( ".file-upload__input-file" ),
            btn = wrapper.find( ".file-upload__button" ),
            clearBtn = wrapper.next( ".file-upload-clear" );
    
            clearBtn.on("click", function(e){ // clear file
                inp.val("");
                btn.text(btn.data("text"));
                clearBtn.addClass("hidden");
            });

            // Crutches for the :focus style:
            inp.focus(function(){
                wrapper.addClass( "focus" );
            }).blur(function(){
                wrapper.removeClass( "focus" );
            });

            inp.change(function(){
                if(inp[0].files.length > 0 ){
                    btn.text(inp[0].files.length + " " + declOfNum(inp[0].files.length, ['файл', 'файла', 'файлов']));
                    clearBtn.removeClass("hidden");
                }
            }).change();

            $( window ).resize(function(){
                inp.triggerHandler( "change" );
            });
        }

        function declOfNum(number, titles) {  
            cases = [2, 0, 1, 1, 1, 2];  
            return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];  
        }
 
    }
    /**
     * показ полей для пароля, если при создании обращения, клиент хочет зарегистрироваться 
     * @returns {undefined}
     */
    function _toggleRegistration(){
        var $wrapPassord = $(".ir-wrapper-password-inputs");
        $("#ir-toggle-reg").on("change", function(e){
            if($(this).prop("checked")){
                $wrapPassord.removeClass("hidden");
            } else{
                $wrapPassord.addClass("hidden");
            }
        });  
    }
    /**
     * popup success
     * @returns {undefined}
     */
    function _initPopup(){
        var $popupSuccess = $(".ir-popup_success");
        if($popupSuccess.length > 0){
            $popupSuccess.fadeIn();
        }
    }
    
   
    return{
        init: init
    };
}();


jQuery(function($) {
    App.init();
    AppIR.init();
});

$(window).on("load", function(){
    App.onload();
});

// фикс для битрикса, чтобы точно определял тач
if (Modernizr.touchevents) { 
    $('html').removeClass("bx-no-touch").addClass("bx-touch");
}

