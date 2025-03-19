"use strict";

var AppControlThemes = function(){

    document.addEventListener("DOMContentLoaded", function(event){
        _controlTheme()
    }, false);

    function _controlTheme(){
        var flag_ajax = 0,
            reload_page = false;
    
        // управление панелью тем
        $("#control-panel .toggle-control").on("click", function(){
            $("#control-panel").toggleClass("open");
            if($("#control-panel").hasClass("open")){
                $(this).addClass("open").children("i").addClass("fa-spin");
                sessionStorage.setItem('control_panel_show', 'Y');
            } else {
                $(this).removeClass("open").children("i").removeClass("fa-spin");
                sessionStorage.setItem('control_panel_show', 'N');
            }
            return false;
        });
        if(sessionStorage.getItem('control_panel_show') === "Y"){
            $("#control-panel .toggle-control").trigger("click");
        }
        
        $("#control-panel .toggle-control").on("mouseover", function () {
            if(!$(this).hasClass("open")){
                $(this).children("i").addClass("fa-spin");
            } 
        }).on("mouseout", function () {
            if(!$(this).hasClass("open")){
                $(this).children("i").removeClass("fa-spin");
            } 
        });

        // toggle class label button
        $("#control-panel label").on("click", function(e){
            $(this).addClass("active").siblings("label").removeClass("active");
        });
        
        // color picker
        $('input[name="custom_color_main"]').minicolors({
            theme: "box",
            changeDelay: 25,
            change: function(value, opacity) {
                $(".box-custom .main").css({"border-color": value+" transparent transparent transparent"});
            }
        });
        $('input[name="custom_color_second"]').minicolors({
            theme: "box",
            changeDelay: 25,
            change: function(value, opacity) {
                $(".box-custom .dark").css({"border-color": "transparent transparent "+value+" transparent"});
            }
        });
        
        // show color picker custom
        $("#custom-color .box-color").on("click", function(e){
            $(this).parent("label").find(".popup-color-set").toggleClass("hidden");
            $(this).parent("label").find("input[name='theme_color']").prop("checked", true);
            e.preventDefault();
        });
        // close popup color picker
        $(".popup-color-set .close").on("click", function(e){
            $(this).parent(".popup-color-set").addClass("hidden");
            e.preventDefault();
        });
        // close popup color picker
        $(document).on('click', function(e) {
            if (!$(e.target).closest("#custom-color").length) {
            $(".popup-color-set").addClass("hidden");
            }
            e.stopPropagation();
        });
        //set params, need reload page
        $('.theme-control input[data-reload="Y"]').on('change', function(e) {
            reload_page = true;
        });
        // submit form
        $("form[name='theme-control'] button[type='submit']").on("click", function(){
            var $form = $(this).parents("form"),
                typeSend = $(this).attr("name");
            if (flag_ajax === 0) {
                var $btn = $form.find("button");
                flag_ajax = 1;
                $btn.prop("disabled", true);
                $.ajax({
                    type: "POST",
                    url: $form.attr("action"),
                    data: $form.serialize() + "&"+typeSend+"=Y&ajax=Y",
                    cache: false,
                    dataType: "json"
                }).done(function (data, textStatus, jqXHR) {
                    if(data.css !== undefined){ //css
                        if($("#custom_style").length > 0){                            
                            $("#custom_style").text(data.css);
                        } else {
                            $( "<style id='custom_style'>"+data.css+"</style>" ).appendTo("head");
                        } 
                    } 
                    if("theme" in data){ //theme
                        $(".label-themes").removeClass("active");
                        $(".label-themes[data-theme='"+data["theme"]+"']").addClass("active");
                        $("input[name='theme_color'][value='"+data["theme"]+"']").prop("checked", true);
                    } 
                    if("layout" in data){ //layout
                        if("layouts" in data && Array.isArray(data.layouts)){
                            $("body").removeClass(data.layouts.join(' '));
                            if(data.layout !== "wide"){
                                $("body").addClass(data.layout);
                            }
                        }
                        $form.find("input[name='layout'][value='"+data.layout+"']").parent('label').trigger("click");
                    }
                    if(reload_page || typeSend === "reset"){
                        window.location.reload(true);
                    }
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    alert(textStatus+": " +  errorThrown);
                }).always(function (jqXHR, textStatus) {
                    flag_ajax = 0;
                    $btn.prop("disabled", false);
                });
            }
            return false;
        });
    }

    return{
       // init: init
    };
}();
