App = function () {
    function a() {
        $("input, textarea").each((function () {
            $(this).val().length > 0 ? $(this).addClass("valid") : $(this).removeClass("valid")
        })), $("body").on("keypress, change", "input, textarea", (function () {
            $(this).val().length > 0 ? $(this).addClass("valid") : $(this).removeClass("valid")
        }))
    }

    function t(e) {
        var a = o(e), t = "";
        return a.h > 0 && (t = ("00" + a.h).slice(-2) + ":"), t += ("00" + a.m).slice(-2) + ":" + ("00" + a.s).slice(-2)
    }

    function o(e) {
        var a = (e = Math.round(e)) % 3600, t = a % 60;
        return {h: Math.floor(e / 3600), m: Math.floor(a / 60), s: Math.ceil(t)}
    }

    function n() {
        var e = "";
        if (window.getSelection) if (!document.activeElement || "textarea" !== document.activeElement.tagName.toLowerCase() && "input" !== document.activeElement.tagName.toLowerCase()) {
            try {
                if (window.getSelection) var a = window.getSelection().toString(); else a = document.getSelection()
            } catch (e) {
                console.log(e)
            }
            e = a
        } else {
            e = document.activeElement.value.substring(document.activeElement.selectionStart, document.activeElement.selectionEnd)
        } else document.selection.createRange && (e = document.selection.createRange().text);
        return "" !== e && e
    }

    function i() {
        return window.getSelection ? window.getSelection().empty ? window.getSelection().empty() : window.getSelection().removeAllRanges && window.getSelection().removeAllRanges() : document.selection && document.selection.empty(), !0
    }

    function s(e, a) {
        var t = document.createElement("script");
        t.type = "text/javascript", t.async = !0, t.readyState ? t.onreadystatechange = function () {
            "loaded" !== t.readyState && "complete" !== t.readyState || (t.onreadystatechange = null, a())
        } : t.onload = function () {
            a()
        }, t.src = e, document.getElementsByTagName("head")[0].appendChild(t)
    }

    return {
        init: function () {
            var t, o;
            a(), t = 0, $(window).on("resize", (function () {
                clearTimeout(t), t = setTimeout((function () {
                    $(window).width() < 768 && $(".wrap-fix-menu").removeClass("navbar-fixed-top")
                }), 80)
            })), $(window).scroll((function (e) {
                var a = $(".header-top").height(), t = $(document).scrollTop(), o = $(window).width();
                t > a && o > 767 ? $(".wrap-fix-menu").addClass("navbar-fixed-top") : $(".wrap-fix-menu").removeClass("navbar-fixed-top")
            })), function () {
                var e = $(".owl-banners-main").data("items") > 4;
                e && $(".wrap-main-banners .arrow-banners").show();
                var a = $(".owl-banners-main").owlCarousel({
                    loop: e,
                    margin: 0,
                    nav: !1,
                    dots: !1,
                    responsive: {0: {items: 1}, 750: {items: 2}, 992: {items: 3}, 1200: {items: 4}}
                });
                $(".next-banners-main").click((function () {
                    return a.trigger("next.owl.carousel"), !1
                })), $(".prev-banners-main").click((function () {
                    return a.trigger("prev.owl.carousel"), !1
                }))
            }(), function () {
                var e = document.querySelector("#ya-map-main");
                if (!e) return !1;
                if (void 0 === jsOption.api_map_key_ya) return console.warn("twim.gossite: not key api map yandex;"), !1;
                void 0 !== window.ymaps ? a() : s("https://api-maps.yandex.ru/2.1/?apikey=" + jsOption.api_map_key_ya + "&lang=ru_RU", a);

                function a() {
                    ymaps.ready((function () {
                        var a, t, o, n, i = "#0e4779";
                        return void 0 === jsOption.coord_ya ? (console.warn("twim.gossite: not set coord map yandex;"), !1) : (void 0 !== jsOption.ya_map_iconColor && (i = jsOption.ya_map_iconColor), t = e.getAttribute("data-title"), (a = function (e) {
                            for (var a = e.split(","), t = 0; t < a.length; t++) a[t] = a[t].trim();
                            return !!(Array.isArray(a) && a.length >= 2) && a
                        }(jsOption.coord_ya)) ? ((o = new ymaps.Map("ya-map-main", {
                            center: a,
                            zoom: 10,
                            controls: ["zoomControl", "fullscreenControl", "trafficControl", "typeSelector", "geolocationControl"]
                        })).behaviors.disable(["scrollZoom"]), o.container.fitToViewport(), n = new ymaps.Placemark(o.getCenter(), {iconCaption: t}, {
                            preset: "islands#icon",
                            iconColor: i
                        }), void o.geoObjects.add(n)) : (console.warn("twim.gossite: not valid coord map yandex;"), !1))
                    }))
                }
            }(), $(".owl-slider-main").owlCarousel({
                loop: !0,
                margin: 0,
                nav: !0,
                dots: !0,
                items: 1,
                autoplay: !0,
                autoplayHoverPause: !0,
                navText: ['<i class="ion ion-ios-arrow-left"></i>', '<i class="ion ion-ios-arrow-right"></i>']
            }), function () {
                var a = [], t = [], o = new Date;
                $(".list-events-main .item").each((function () {
                    var e = $(this).data("date"), o = moment(e, "DD.MM.YYYY");
                    moment().isBefore(o) && t.push(e), a.push(e)
                })), t.length > 0 && (o = moment(t[0], "DD.MM.YYYY").format("MM/DD/YYYY"));
                $("#datetimepicker-events").datetimepicker({
                    inline: !0,
                    sideBySide: !1,
                    useCurrent: !1,
                    defaultDate: o,
                    locale: "ru",
                    format: "DD.MM.YYYY",
                    icons: {previous: "ion ion-ios-play-outline ion-rotate-180", next: "ion ion-ios-play-outline"}
                }).on("dp.change", (function (t) {
                    console.log("date changed = " + t);
                    var o = window.location.hostname, n = e.date.format("DD.MM.YYYY"),
                        i = {arrFilter_DATE_ACTIVE_FROM_1: n + " 00:00:00", arrFilter_DATE_ACTIVE_FROM_2: n + " 23:59:00", set_filter: "Y"},
                        s = "//" + o + "/news/?" + Object.keys(i).map(e => encodeURIComponent(e) + "=" + encodeURIComponent(i[e])).join("&");
                    window.location.replace(s), $(this).data("DateTimePicker").enabledDates(a), $(".list-events-main .item").hide(), $('.list-events-main .item[data-date="' + t.date.format("DD.MM.YYYY") + '"]').fadeIn("slow")
                })).on("dp.update", (function (e) {
                    console.log("date updated"), $(this).data("DateTimePicker").enabledDates(a)
                })).on("dp.load", (function () {
                    console.log("date loaded"), console.log("arDate = " + a), $(this).data("DateTimePicker").enabledDates(a), $('.list-events-main .item[data-date="' + t[0] + '"]').fadeIn("slow")
                })).trigger("dp.load")
            }(), function () {
                function e(e, a) {
                    var t, o = $.cookie("special_param");
                    void 0 !== o && ((t = JSON.parse(o))[e] = a, o = JSON.stringify(t), $.cookie("special_param", o, {path: "/"}))
                }

                function a() {
                    var e = $.cookie("special_param");
                    if (void 0 !== e) {
                        var a = JSON.parse(e);
                        if ("Y" === a.special) {
                            var t = "special";
                            void 0 !== a.theme ? ($(".color button").removeClass("active"), $('button[data-color="' + a.theme + '"]').addClass("active"), t += " " + a.theme) : ($('button[data-color="tm-white"]').addClass("active"), t += " tm-white"), void 0 !== a.fz ? ($(".font-size button").removeClass("active"), $('button[data-font-size="' + a.fz + '"]').addClass("active"), t += " " + a.fz) : $('button[data-font-size=""]').addClass("active"), void 0 !== a.ff ? ($(".font-family button").removeClass("active"), $('button[data-font-family="' + a.ff + '"]').trigger("click"), t += " " + a.ff) : $('button[data-font-family=""]').addClass("active"), void 0 !== a.ls ? ($(".char-interval button").removeClass("active"), $('button[data-interval="' + a.ls + '"]').addClass("active"), t += " " + a.ls) : $('button[data-interval=""]').addClass("active"), "N" === a.image ? ($(".img-show-button").find("i.fa").removeClass("fa-check-square-o").addClass("fa-square-o").data("image", "N"), t += " hide-image") : ($(".img-show-button").find("i.fa").removeClass("fa-square-o").addClass("fa-check-square-o").data("image", "Y"), $("body").removeClass("hide-image")), $("body").addClass(t)
                        }
                    }
                }

                $("a.special").on("click", (function (e) {
                    var t = $.cookie("special_param");
                    if (void 0 === t) t = JSON.stringify({special: "Y", theme: "tm-white", fz: "", ls: "", ff: "", image: "Y"}); else {
                        var o = JSON.parse(t);
                        o.special = "Y", t = JSON.stringify(o)
                    }
                    return $.cookie("special_param", t, {path: "/"}), a(), !1
                })), $("#link_settings").click((function () {
                    $(".settings-panel").slideToggle("slow")
                })), $(document).on("click", (function (e) {
                    0 === $(".special-panel").has(e.target).length && $(".settings-panel").slideUp("slow")
                })), $("button.normal-version").on("click", (function (a) {
                    e("special", "N"), $("body").removeClass("special hide-image fz-medium fz-large ff-serif tm-white tm-black tm-blue tm-brown interval-medium interval-large")
                })), $(".font-size button").on("click", (function () {
                    $(".font-size button").removeClass("active");
                    var a = $(this).addClass("active").data("font-size");
                    $("body").removeClass("fz-medium fz-large").addClass(a), e("fz", a)
                })), $(".font-family button").click((function () {
                    $(".font-family button").removeClass("active");
                    var a = $(this).addClass("active").data("font-family");
                    $('button[data-font-family="' + a + '"]').addClass("active"), $("body").removeClass("ff-serif").addClass(a), e("ff", a)
                })), $(".color button").click((function () {
                    $(".color button").removeClass("active");
                    var a = $(this).addClass("active").data("color");
                    $('button[data-color="' + a + '"]').addClass("active"), $("body").removeClass("tm-white tm-black tm-blue tm-brown").addClass(a), e("theme", a)
                })), $(".char-interval button").click((function () {
                    $(".char-interval button").removeClass("active");
                    var a = $(this).addClass("active").data("interval");
                    $("body").removeClass("interval-medium interval-large").addClass(a), e("ls", a)
                })), $(".img-show-button").click((function () {
                    var a = "Y";
                    "Y" === $(this).data("image") ? ($(this).children("i.fa").removeClass("fa-check-square-o").addClass("fa-square-o"), a = "N", $("body").addClass("hide-image")) : ($(this).children("i.fa").removeClass("fa-square-o").addClass("fa-check-square-o"), a = "Y", $("body").removeClass("hide-image")), $(this).data("image", a), e("image", a)
                })), a()
            }(), o = 0, $("#search-panel").on("hidden.bs.collapse", (function () {
                $("body").removeClass("no-scroll").css({"padding-right": ""}), $(".bt-overlay").remove(), $('input[type="text"]').blur()
            })), $("#search-panel").on("show.bs.collapse", (function () {
                o = window.innerWidth - document.documentElement.clientWidth, $("body").addClass("no-scroll").append('<div class="bt-overlay"></div>'), $("body").css({"padding-right": o}), $('input[type="text"]').focus()
            })), $("#search-panel").on("show.bs.collapse", (function () {
                $("html, body").animate({scrollTop: 0}, 500)
            })), $("#search-panel").on("shown.bs.collapse", (function () {
                $('input[type="text"]').focus()
            })), $("body").on("click", ".bt-overlay", (function () {
                $("#search-panel").collapse("hide")
            })), $("#search-panel .close").on("click", (function () {
                $("#search-panel").collapse("hide")
            })), $(".upper").on("click", (function () {
                $("html, body").animate({scrollTop: 0}, 500)
            })), function () {
                var e = $('input[data-input="daterange"]'), a = e.val();
                if (e.daterangepicker({
                    autoApply: !0,
                    applyClass: "btn-info",
                    cancelClass: "btn-info",
                    locale: {applyLabel: "Готово", cancelLabel: "Закрыть", fromLabel: "От", toLabel: "До"}
                }), void 0 !== a && 0 === a.length) {
                    var t = moment().subtract(30, "days"), o = moment();
                    e.data("daterangepicker").setStartDate(t), e.data("daterangepicker").setEndDate(o)
                }
            }(), $('a[href^="#"]').click((function () {
                if ($('a[name="' + this.hash.slice(1) + '"]').length > 0) return $("html, body").animate({scrollTop: $('a[name="' + this.hash.slice(1) + '"]').offset().top - 100}, 1e3), !1
            })), $(".chocolat-gallery").Chocolat(), $("a.view_popup_doc").on("click", (function () {
                var e = $(this).attr("href"), a = $(this).attr("title");
                return e.split(".").pop(), $.ajax({url: e, dataType: "html", method: "GET", cache: !1}).done((function (e) {
                    $("#modal_doc .modal-title").html(a), $("#modal_doc .modal-body").html(e), $("#modal_doc").modal("show")
                })), !1
            })), function () {
                function e() {
                    try {
                        if (BX.UserConsent.loadFromForms(), !BX.UserConsent) return;
                        var e = BX.UserConsent.load(BX("userconsent-container"));
                        if (!e) return;
                        BX.addCustomEvent(e, BX.UserConsent.events.save, (function (e) {
                            var a = $("form[name='question_form']");
                            "Y" == a.data("submit") && (a.trigger("submit"), a.data("submit", "N"))
                        })), BX.addCustomEvent(e, BX.UserConsent.events.refused, (function () {
                            $("form[name='question_form']").data("submit", "N")
                        }))
                    } catch (e) {
                        console.log("error BX.UserConsent.loadFromForms")
                    }
                }

                function t(e, a) {
                    e.parent(".form-group").addClass("has-error"), e.next().next(".help-block").remove(), e.parent(".form-group").append("<span class='help-block'>" + a + "</span>")
                }

                function o(e) {
                    e.parent(".form-group").removeClass("has-error"), e.next().next(".help-block").remove()
                }

                $(".link-open-question").click((function () {
                    var e = $(this), a = e.attr("href");
                    return e.toggleClass("open"), $(a).removeClass("hidden").slideToggle("slow"), e.hasClass("open") ? e.children("i.fa").attr("class", "fa fa-chevron-up") : e.children("i.fa").attr("class", "fa fa-chevron-down"), !1
                })), $('*[data-toggle="modal_classic"]').on("click", (function (t) {
                    var o = $(this), n = o.data("target");
                    if ($(n).length < 1) {
                        $("#modal_classic").clone().attr("id", n.substring(1)).appendTo("body");
                        var i = o.data("load-page"), s = o.data("title");
                        (l = $(n)).find(".modal-title").text(s);
                        $.ajax({url: i, dataType: "html", method: "GET", cache: !1, data: {AJAX_PAGE: "Y"}}).done((function (t) {
                            var o = $(t).find(".box-body");
                            l.find(".modal-body").html(o), a(), e(), l.modal("show")
                        })).fail((function () {
                            l.find(".modal-body").html("Ошибка запроса, повторите операцию позже или обратитесь к администратору сайта"), l.modal("show")
                        })).always((function () {
                            void 0 !== window.Recaptchafree && Recaptchafree.reset()
                        }))
                    } else {
                        var l;
                        (l = $(n)).modal("show")
                    }
                })), BX.ready((function () {
                    e()
                })), $(document).on("click", "form[name='question_form'] input[type='submit']", (function () {
                    return $(this).closest("form").data("submit", "Y"), BX.onCustomEvent("userconsent-event", []), !1
                })), $(document).on("submit", "form[name='question_form']", (function () {
                    var n = $("input[name='user_name']", $(this)), i = $("input[name='user_email']", $(this)),
                        s = ($("input[name='user_phone']", $(this)), $("select[name='q_categ']", $(this)), $("textarea[name='MESSAGE']", $(this))),
                        l = $("button[type='submit']", $(this)), r = $(this), d = $(this).parent(".mfeedback"), c = "N", u = 0;
                    return 0 === n.val().length ? (t(n, "Укажите, как к Вам обращаться"), c = "Y") : n.val().length < 3 ? (t(n, "Должно быть не менее 3-х символов"), c = "Y") : o(n), console.log(s.val()), 0 === s.val().length ? (t(s, "Не заполнены обязательные поля"), c = "Y") : s.val().length < 10 ? (t(s, "Должно быть не менее 10-х символов"), c = "Y") : s.val().length > 500 ? (t(s, "Должно быть не более 500 символов"), c = "Y") : o(s), 0 === i.val().length ? (t(i, "Не заполнены обязательные поля"), c = "Y") : /^[a-zA-Z0-9_.+-]+@[a-z0-9-]+\.[a-z]{2,6}$/i.test(i.val()) ? o(i) : (t(i, "Ошибка! Введен некорректный адрес email"), c = "Y"), "N" === c && 1 !== u && (u = 1, l.prop("disabled", !0), $.ajax({
                        type: r.attr("method"),
                        url: r.attr("action"),
                        data: r.serialize() + "&submit=y&AJAX_PAGE=Y",
                        cache: !1,
                        dataType: "html"
                    }).done((function (a, t, o) {
                        var n = $(a).find(".mfeedback");
                        d.replaceWith(n);
                        var i = $(a).find(".ok-message");
                        1 === i.length && ($("#modal_question").modal("hide"), function (e) {
                            var a = $("#modal_success");
                            a.length < 1 && ($("#modal_classic").clone().attr("id", "modal_success").appendTo("body"), (a = $("#modal_success")).find(".modal-dialog").addClass("modal-sm"));
                            a.find(".modal-body").html(e), setTimeout((function () {
                                a.modal("show")
                            }), 600)
                        }(i.html())), e()
                    })).fail((function (e, a, t) {
                        alert(a + ": " + t)
                    })).always((function (e, t) {
                        u = 0, l.prop("disabled", !1), void 0 !== window.Recaptchafree && Recaptchafree.reset(), a()
                    }))), !1
                }))
            }(), function () {
                function e(e) {
                    this.$element = $(e), this.$content = this.$element.find(".modal-content");
                    var a = this.$content.outerHeight() - this.$content.innerHeight(), t = $(window).width() < 768 ? 20 : 60,
                        o = $(window).height() - (t + a) - ((this.$element.find(".modal-header").outerHeight() || 0) + (this.$element.find(".modal-footer").outerHeight() || 0));
                    this.$content.css({overflow: "hidden"}), this.$element.find(".modal-body").css({"max-height": o, "overflow-y": "auto"})
                }

                $(".modal.center").on("show.bs.modal", (function () {
                    $(this).show(), e(this)
                })), $(window).on("resize", (function () {
                    0 != $(".modal.center.in").length && e($(".modal.center.in"))
                }))
            }(), $("input[name='send']").on("click", (function () {
                $(".form-group__type-send").toggle()
            })), $("input[data-input-date]").datetimepicker({inline: !1, sideBySide: !1, useCurrent: !0, locale: "ru", format: "DD.MM.YYYY"}), function () {
                "ontouchstart" in document.documentElement ? $(".nav-main .dropdown-toggle").on("touchstart", e) : $(".nav-main .dropdown-toggle").on("mouseenter", e);

                function e(e) {
                    var a, t, o, n = $(".nav-main");
                    (o = $(this).next("ul")).css({
                        left: "",
                        display: "block"
                    }), a = o[0].getBoundingClientRect(), t = n[0].getBoundingClientRect(), o.css({display: ""}), t.right < a.right && o.css({left: "-" + (a.right - t.right) + "px"}), "mouseenter" === e.type && ($(this).attr("aria-expanded", "true"), $(this).parent("li.dropdown").addClass("open"))
                }
            }(), $('[data-toggle="tooltip"]').tooltip()
        }, onload: function () {
            $(".scrollbar-outer, .scrollbar-theme").scrollbar({ignoreMobile: !1, ignoreOverlay: !1}), function () {
                var e, a = "stop", o = new Audio, s = "";
                if ("ya" == jsOption.type_voice) {
                    window.ya.speechkit.settings.lang = "ru-RU", window.ya.speechkit.settings.apikey = jsOption.speechkit_apikey, window.ya.speechkit.settings.model = "notes";
                    var l = new ya.speechkit.Tts({emotion: "good", speed: 1.1, speaker: "jane"});
                    if (!jsOption.speechkit_apikey || "" === jsOption.speechkit_apikey || " " === jsOption.speechkit_apikey) return
                }
                o.volume = 1, $("body").hasClass("special") && $(".soundbar").removeClass("hide");
                if ($("a.special").on("click", (function (e) {
                    $(".soundbar").removeClass("hide")
                })), $("button.normal-version").on("click", (function (e) {
                    $(".soundbar").addClass("hide")
                })), "ontouchstart" in document.documentElement) return;
                $(".soundbar").removeClass("soundbar_hide"), $(".wrap-content").on("mouseup", (function (e) {
                    var a, t;
                    s = n();
                    var o = $(".soundcursor");
                    s && $("body").hasClass("special") ? (a = e.pageX, t = e.pageY, 0 === o.length && $("body").append('<button class="soundcursor"><div class="soundcursor__icon"><i class="fa fa-play" aria-hidden="true"></i></div></button>'), $(".soundcursor").css({
                        top: t - 25,
                        left: a + 10
                    })) : $(".soundcursor").remove()
                })).on("mousedown", (function () {
                    i()
                })), $("body").on("click", ".soundcursor", (function (n) {
                    if (s) if (s.length > 3e3) {
                        var i = $("#modal_error");
                        i.length < 1 && ($("#modal_classic").clone().attr("id", "modal_error").appendTo("body"), i = $("#modal_error")), i.find(".modal-dialog").addClass("modal-sm"), i.find(".modal-title").html("Ошибка"), i.find(".modal-body").html("Выделенный текст должен иметь меньше 3000 символов, текущий размер - " + s.length + " символов"), i.modal("show")
                    } else $(".soundbar_loader").removeClass("soundbar_loader_hide"), $(".soundbar__play").addClass("soundbar__play_hide"), function (n) {
                        "ya" == jsOption.type_voice ? (o.pause(), a = "play", l.speak(n, {
                            dataCallback: function (n) {
                                "stop" !== a && (o.src = URL.createObjectURL(n), o.play(), $(".soundbar_loader").addClass("soundbar_loader_hide"), $(".soundbar__play").addClass("soundbar__play_hide"), $(".soundbar__timers").removeClass("soundbar__timers_hide"), e = setInterval((function () {
                                    $(".soundbar__curretn-time").text(t(o.currentTime))
                                }), 1e3))
                            }
                        })) : "rv" == jsOption.type_voice && responsiveVoice.voiceSupport() && responsiveVoice.speak(n, "Russian Female", {
                            onstart: function () {
                                $(".soundbar_loader").addClass("soundbar_loader_hide"), $(".soundbar__play").addClass("soundbar__play_hide"), $(".soundbar__timers").removeClass("soundbar__timers_hide"), $(".soundbar__duration-time").html("&nbsp;"), $(".soundbar__curretn-time").html("&nbsp;")
                            }, onend: function () {
                                $(".soundbar__play").removeClass("soundbar__play_hide"), $(".soundbar__timers").addClass("soundbar__timers_hide")
                            }
                        })
                    }(s);
                    return $(".soundcursor").remove(), !1
                })), $(o).on("ended", (function () {
                    clearInterval(e), $(".soundbar__play").removeClass("soundbar__play_hide"), $(".soundbar__timers").addClass("soundbar__timers_hide")
                })).on("loadedmetadata", (function () {
                    $(".soundbar__duration-time").text(t(o.duration))
                })), $(".soundbar").on("click", (function () {
                    o.pause(), a = "stop", $(".soundbar__play").removeClass("soundbar__play_hide"), $(".soundbar__timers").addClass("soundbar__timers_hide"), $(".soundbar_loader").addClass("soundbar_loader_hide"), "rv" == jsOption.type_voice && responsiveVoice.cancel()
                }))
            }()
        }, getSelectedText: n, removeSelectedText: i, secondsToTime: o, formatTime: t, loadScript: s, supports_html5_storage: function () {
            try {
                return "localStorage" in window && null !== window.localStorage
            } catch (e) {
                return !1
            }
        }
    }
}();
var a = {
    init: function () {
        var e, a, t, o, n, i, s, l, r, d, c;
        $("input[data-category]").change((function (e) {
            var a = $(this).val(), t = $(".wrap-select[data-category-toggle=" + a + "]");
            t.removeClass("hidden"), t.find("select").prop("disabled", !1), $(".wrap-select[data-category-toggle]").not(t).addClass("hidden").find("select").prop("disabled", !0)
        })), $("input[data-disabled-input]").change((function () {
            var e = $(this), a = e.data("disabled-input");
            e.prop("checked") ? $(a).prop("disabled", !0) : $(a).prop("disabled", !1)
        })), e = $("#coauthor-template").html(), a = $(".ir-coauthors-include"), t = a.find(".ir-coauthor"), o = t.length, t.find(".ir-coauthor_btn").on("click", (function (e) {
            $(this).parents(".ir-coauthor").remove()
        })), $("#add-coauthor").on("click", (function (t) {
            o++;
            var n = e.replace(/#ID#/gi, o), i = $(n);
            i.find(".ir-coauthor_btn").on("click", (function (e) {
                i.remove()
            })), a.append(i)
        })), n = $(".ir-wrapper-password-inputs"), $("#ir-toggle-reg").on("change", (function (e) {
            $(this).prop("checked") ? n.removeClass("hidden") : n.addClass("hidden")
        })), i = $(".file-upload"), l = (s = i).find(".file-upload__input-file"), r = s.find(".file-upload__button"), (d = s.next(".file-upload-clear")).on("click", (function (e) {
            l.val(""), r.text(r.data("text")), d.addClass("hidden")
        })), l.focus((function () {
            s.addClass("focus")
        })).blur((function () {
            s.removeClass("focus")
        })), l.change((function () {
            var e;
            l[0].files.length > 0 && (r.text(l[0].files.length + " " + (e = l[0].files.length, cases = [2, 0, 1, 1, 1, 2], ["файл", "файла", "файлов"][e % 100 > 4 && e % 100 < 20 ? 2 : cases[e % 10 < 5 ? e % 10 : 5]])), d.removeClass("hidden"))
        })).change(), $(window).resize((function () {
            l.triggerHandler("change")
        })), (c = $(".ir-popup_success")).length > 0 && c.fadeIn()
    }
};
jQuery((function (e) {
    App.init(), a.init()
})), $(window).on("load", (function () {
    App.onload()
})), Modernizr.touchevents && $("html").removeClass("bx-no-touch").addClass("bx-touch")