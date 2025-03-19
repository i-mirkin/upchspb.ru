var window_width = 0;

function func_main_slider(){
	$(".front-slider__cont").on('init', function(slick){
	    $(".front-slider__fone-item[data-ind='0']").addClass("active");
		$(".front-slider").addClass("front-slider--loaded");
	});
	
	$(".front-slider__cont").slick({
		dots: true,
		fade: true,
		autoplay: true,
		autoplaySpeed: 5000,
		pauseOnHover:false,
		pauseOnFocus:false,
		rows: 0,
		nextArrow: ".front-slider__arr--next",
		prevArrow: ".front-slider__arr--prev",
		adaptiveHeight: true
	});
	
	$('.front-slider__cont').on('beforeChange', function(event, slick, currentSlide, nextSlide){ 
		$(".front-slider__fone-item").removeClass("front-slider__fone-item--vs");
		$(".front-slider__fone-item[data-ind='"+nextSlide+"']").addClass("front-slider__fone-item--vs");		
	});
}

$(document).ready(function(){
	$(".scrollbar-dynamic").scrollbar();
	func_main_slider()
	parent_slider()

	header_menu()

  $(document).mouseup(function(e) { // событие клика по веб-документу
    var div = $(".header-search"); // тут указываем ID элемента
    var div2 = $(".header__bottom--adap");
    if ($(window).width() < 992) {
        if (!div.is(e.target) // если клик был не по нашему блоку
            &&
            !$("header .header__top-search").is(e.target) //не по кнопки search в хедере
            &&
            !$("header").is(e.target) 
            &&
            div.has(e.target).length === 0) { // и не по его дочерним элементам
        	div.removeClass("active");
            // if ($(".header__bottom").hasClass("open")) {
            //     $("body").removeClass("body--open-menu")
            //     $(".header__bottom").removeClass("open").stop().slideUp();
            // }
        // $(".header-search__input input").val('');
      } else if ($("header .header__top-search").is(e.target)) {
              div.toggleClass("active");
              $(".ya-site-form__input-text").focus();
              // $(".header-search__input input").val('');
              if ($(".header__bottom").hasClass("open")) {
              	$("body").removeClass("body--open-menu");
              	$(".header__bottom").removeClass("open").stop().slideUp();
              }
      } else if ($("header .header-search__close").is(e.target)) { 
              div.removeClass("active");
              $(".ya-site-form__input-text").blur();
              // $(".header-search__input input").val('');
      }
  	} 

  });


  $(document).mouseup(function(e) { // событие клика по веб-документу
    var div2 = $(".header__bottom--adap");
    if ($(window).width() < 992) {
        if ($("body").hasClass("Safari")) {
            if (!div2.is(e.target) // если клик был не по нашему блоку
                &&
                !$("header").is(e.target) 
                &&
                div2.has(e.target).length === 0
                &&
                $("header").has(e.target).length === 0) { // и не по его дочерним элементам
                if ($(".header__bottom").hasClass("open")) {
                    $("body").removeClass("body--open-menu")
                    $(".header__bottom").removeClass("open").stop().slideUp();
                }
            // $(".header-search__input input").val('');
          } else if ($("header .header__top-search").is(e.target)) {
                  div.toggleClass("active");
                  $(".ya-site-form__input-text").focus();
                  // $(".header-search__input input").val('');
                  if ($(".header__bottom").hasClass("open")) {
                    $("body").removeClass("body--open-menu");
                    $(".header__bottom").removeClass("open").stop().slideUp();
                  }
          } else if ($("header .header-search__close").is(e.target)) { 
                  div.removeClass("active");
                  $(".ya-site-form__input-text").blur();
                  // $(".header-search__input input").val('');
          }
        }

    } 

  });
  
  
  
  
  $(".news-detail-more").click(function(){
	  var top = $(window).scrollTop();
	  
	  $(this).prev().addClass("news-detail--open").css("max-height", "none");
	  $(this).hide();
	  $(window).scrollTop(top);
  })

  // box-body custom table
  if ($(".box-body table").length > 0) {
    if (!$(".box-body table").hasClass("map-columns")) {
        $(".box-body table").wrap("<div class='table_responsive_outer'></div>");
        $(".box-body table").wrap("<div class='content_table'></div>");
        $(".content_table").prepend("<div class='content_table__btn content_table__btn--right'></div>");
        $(".content_table").prepend("<div class='content_table__btn content_table__btn--left'></div>");
        $(".box-body table").wrap("<div class='scrollbar-dynamic content_table--scrollbar'></div>");
        $(".box-body .content_table--scrollbar").scrollbar();
      } else {
        $(".box-body table").wrap("<div class='table_responsive_outer'></div>");
      }
        
    }

    

    

    $(".content_table__btn--left").click(function() {
        var tab_width = $(this).closest(".content_table").width();
        var bar_left = parseInt($(this).closest(".content_table").find('.scrollbar-dynamic .scroll-bar').css("left"));
        var table = $(this).closest(".content_table").find('table').width();
        var left = bar_left / tab_width * table;
        var scrollbar = $(this).closest(".content_table").find('.scrollbar-dynamic');
        $(scrollbar).scrollLeft(left - tab_width / 2);
        setTimeout(function() {
            tab_scrollbar_arr();
        }, 600);

    })

    $(".content_table__btn--right").click(function() {
        var tab_width = $(this).closest(".content_table").width();
        var bar_left = parseInt($(this).closest(".content_table").find('.scrollbar-dynamic .scroll-bar').css("left"));
        var table = $(this).closest(".content_table").find('table').width();
        var left = bar_left / tab_width * table;
        var scrollbar = $(this).closest(".content_table").find('.scrollbar-dynamic');
        $(scrollbar).scrollLeft(left + tab_width / 2);
        setTimeout(function() {
            tab_scrollbar_arr();
        }, 600);
    })


    $(window).resize(function() {
        tab_scrollbar_init();
    })
    // end box-body custom table
	
	news_detail_report();

})

$(window).load(function(){


})

$(window).on("load", function(){
	console.log("load")
    window_width = $(window).width();
    header_menu_resize();

    if($(window).scrollTop() > 30) {
        $('#toTop').fadeIn();
    } 
    $(window).scroll(function() {
        if($(this).scrollTop() > 30) 
        {
            $('#toTop').fadeIn();
        } 
        else
        {
            $('#toTop').fadeOut();
        }
    });

    $('#toTop').click(function() {
        $('body,html').animate({scrollTop:0},500);
    });

    $('#toTopSearch').click(function() {
        $('body,html').animate({scrollTop:0},500);
        $(".ya-site-form__input-text").focus();
    });

    $(".header-info").clone().appendTo(".header__bottom .header-bottom__info");
    
	$(document).on("click", ".slick-lightbox-slick-caption a", function(){
		href = $(this).attr("href");
		window.open(href);
		return false;
	})

// 
    tab_scrollbar_init();

    $(".content_table--scrollbar").on("scroll", function() {
        if ($(".content_table--scrollbar").hasClass("scroll-scrollx_visible")) {
            tab_scrollbar_arr();
        }
    });
// 
	news_detail_report();
});

$(window).resize(function(){
	window_width = $(window).width();
	header_menu_resize()
	news_detail_report()
  
})

$(window).scroll(function() {
    if ($('.tab-serv-table__btn').length > 0) {
        asideRun();
    }
})


function news_detail_report() {
	if ($(".news-detail--report").length && $(window).width()>991) {
	  	if (!$(".news-detail--report").hasClass("news-detail--open")) {
		  var right_height = $(".col-right").outerHeight();
		  var left_height = $(".col-left").outerHeight();
		  var inner = $(".news-detail--report").outerHeight();
		  
		  var height_result = right_height - (left_height - inner);
		  
		  if (height_result>0) {
			  $(".news-detail--report").css("max-height",height_result+"px" )
		  } else {
			  $(".news-detail--report").addClass("news-detail--open")
		  }
		  
		  if ($(".col-right").outerHeight()>=$(".col-left").outerHeight()+ 50) {
			  $(".news-detail--report").addClass("news-detail--open")
		  }
		  
		}
  	}
}

function asideRun() {
    if ($(".content_table .scroll-content").hasClass("scroll-scrollx_visible") && $('.content_table__btn').length > 0) {
        var proposalOffset = $('.content_table').offset().top;
        if ($(window).scrollTop() >= proposalOffset && ($(window).scrollTop() + $(window).height()) < (proposalOffset + $('.content_table').outerHeight())) {
            $(".content_table__btn").css({
                "transform": "translateY( " + ($(window).scrollTop() - proposalOffset) + "px)"
            });
        }
    }
}

function tab_scrollbar_init() {
    if ($(".content_table--scrollbar").hasClass("scroll-scrollx_visible")) {
        tab_scrollbar_arr();
    } else {
        $('.content_table__btn--left').addClass("content_table__btn--noactive");
        $('.content_table__btn--right').addClass("content_table__btn--noactive");
    }
    // if ($(".tab-serv-table").outerHeight() > $(window).height()) {
    //   $(".tab-serv-table").addClass("tab-serv-table--big")
    // } else {
    //   $(".tab-serv-table").removeClass("tab-serv-table--big")
    // }

    asideRun();

}

function tab_scrollbar_arr() {
    var bar_left = parseInt($(".content_table .scrollbar-dynamic .scroll-bar").css("left"));
    var bar_width = parseInt($(".content_table .scrollbar-dynamic .scroll-bar").css("width"));
    var tab_width = $(".content_table--scrollbar").width();
    if (bar_left > 10) {
        if (bar_width + bar_left + 10 >= tab_width) {
            $('.content_table__btn--right').addClass("content_table__btn--noactive");
            $('.content_table__btn--left').removeClass("content_table__btn--noactive");
        } else {
            $('.content_table__btn--left').removeClass("content_table__btn--noactive");
            $('.content_table__btn--right').removeClass("content_table__btn--noactive");
        }
    } else {
        $(".content_table__btn--left").addClass("content_table__btn--noactive");
        $('.content_table__btn--right').removeClass("content_table__btn--noactive");
    }
}


function parent_slider(){
	$(".partner-list__slider").slick({
		dots: false,
		autoplay: true,
		autoplaySpeed: 4000,
		pauseOnHover:false,
		pauseOnFocus:false,
		slidesToShow: 6,
		slidesToScroll: 1,
		rows: 0,
		responsive: [
		{
		      breakpoint: 2500,
		      settings: {
		        slidesToShow: 6
		      }
		    },
		{
		      breakpoint: 2000,
		      settings: {
		        slidesToShow: 5
		      }
		    },
			{
		      breakpoint: 1600,
		      settings: {
		        slidesToShow: 4
		      }
		    },
		    {
		      breakpoint: 767,
		      settings: {
		        slidesToShow: 3
		      }
		    },
		    {
		      breakpoint: 500,
		      settings: {
		        slidesToShow: 2
		      }
		    },
		    {
		      breakpoint: 320,
		      settings: {
		        slidesToShow: 1
		      }
		    }
		]
	});

	/*
		
	*/
	    
}


function header_menu() {
	if (window_width<=991) {
			$(".header__bottom .b-container").scrollbar();
			console.log('scroll-in')
	} else {
		console.log('scroll-destroy')
		$(".header__bottom .b-container").scrollbar("destroy");
	}

	$(".header__top-menu").click(function(){
		if ($(".header__bottom").hasClass("open")) {
			$("body").removeClass("body--open-menu")
			$(".header__bottom").removeClass("open").stop().slideUp();
		} else {
			$("body").addClass("body--open-menu")
			$(".header__bottom").addClass("open").stop().slideDown();
		}
		if (window_width<=991) {
			$(".header__bottom .b-container").scrollbar();
		}
		
	})

	$(".header-menu__item--parent .header-menu__item-title").click(
		function(evt){
			if (window_width<=991) {
				var _this = $(this);
				var _this_lvl2 = $(this).siblings(".header-menu__lvl2");
				if (_this.hasClass("header-menu__item-title--nolink")) {
					if (_this_lvl2.hasClass("open")) {
						
						_this_lvl2.removeClass("open").stop().slideUp();
						_this.removeClass("parent-open");
					} else {
						
						$(".header-menu__lvl2").removeClass("open").hide();
						$(".header-menu__lvl2").siblings(".header-menu__item-title").removeClass("parent-open");
						_this_lvl2.addClass("open").stop().slideDown();
						_this.addClass("parent-open");
					}
				} else {
					if (!_this_lvl2.hasClass("open")) {
						
						evt.preventDefault();
						$(".header-menu__lvl2").removeClass("open").hide();
						$(".header-menu__lvl2").siblings(".header-menu__item-title").removeClass("parent-open");
						_this_lvl2.addClass("open").stop().slideDown();
						_this.addClass("parent-open");
						return false;
						
					} else {
						
					}
				}
			}
		}
	)
	
	/*
	$(".header-menu__item--parent .header-menu__item-title").click(
		function(evt){
			var _this = $(this);
			var _this_lvl2 = $(this).siblings(".header-menu__lvl2");
			if (_this.hasClass("header-menu__item-title--nolink")) {
				if (!$(this).hasClass("hover")) {
					if (_this_lvl2.hasClass("open")) {
						console.log("1")
						_this_lvl2.removeClass("open").stop().slideUp();
					} else {
						console.log("2")
						$(".header-menu__lvl2").removeClass("open").hide();
						_this_lvl2.addClass("open").stop().slideDown();
					}
				} else {
					return false;
				}
			} else {
				if (!_this_lvl2.hasClass("open")) {
					if (!$(this).hasClass("hover")) {
						console.log("3")
						evt.preventDefault();
						$(".header-menu__lvl2").removeClass("open").hide();
						_this_lvl2.addClass("open").stop().slideDown();
						return false;
					} else {
						console.log("6")
						return false;
					}
				} else {
					console.log("7")
				}
			}
		}
	)

	$(".header-menu__item--parent ").hover(
		function(evt){
			if (window_width>991) {
				$(this).find(".header-menu__item-title").addClass("hover")
				var _this = $(this).find(".header-menu__item-title");
				var _this_lvl2 = _this.siblings(".header-menu__lvl2");
				if (_this.hasClass("header-menu__item-title--nolink")) {
					console.log("4_1")
					console.log($(this))
					$(".header-menu__lvl2").removeClass("open").hide();
					_this_lvl2.addClass("open").stop().slideDown();
				} else {
					if (!_this_lvl2.hasClass("open")) {
						evt.preventDefault();
						evt.stopPropagation();
						console.log("4_2")
						$(".header-menu__lvl2").removeClass("open").hide();
						_this_lvl2.addClass("open").stop().slideDown();
						return false;
					} 
				}
			}
		}, 
		function(evt){
			if (window_width>991) {
				console.log("5")
				console.log($(this))
				$(this).find(".header-menu__item-title").removeClass("hover")
				$(this).find(".header-menu__lvl2").removeClass("open").stop().slideUp();
			}
		}
	)*/
}
function header_menu_resize() {
	if (window_width<=991) {
		$(".header__bottom").addClass("header__bottom--adap")
		if ($(".header__bottom").hasClass("open")) {
			$(".header__bottom:not(.open)").hide();
			$(".header-menu__lvl2").removeClass("open").attr('style', '');
		}
	} else {
		$(".header__bottom").removeClass("open header__bottom--adap open").show();
		$("body").removeClass("body--open-menu")
		$(".header-menu__lvl2").siblings(".header-menu__item-title").removeClass("parent-open");
	}

	if (window_width<=991) {
			$(".header__bottom .b-container").scrollbar();
			console.log('scroll-in')
	} else {
		console.log('scroll-destroy')
		$(".header__bottom .b-container").scrollbar("destroy");
	}
}

$(document).ready(function(){
	$('body').on('submit', '[name=apply_form]', function(e){
		e.preventDefault();
		var thisform = $(this);
		var apply_form = $(this)[0];
		var apply_data = new FormData(apply_form);
		var apply_url = thisform.attr('action');
		$.ajax({
			type: 'POST',
			url: apply_url,
			enctype: 'multipart/form-data',
			data: apply_data,
			processData: false,
			contentType: false,
			cache: false,
			success: function(data) {
				thisform.find('.help-block').remove();
				thisform.find('.form-group').removeClass('has-error')
				var resp = $.parseJSON(data);
				
				if(resp.IS_ERROR) {
					$.each(resp, function(k,v) {
						$('[name='+k+']').parent('.form-group').addClass('has-error');
						$('[name='+k+']').parent('.form-group').append('<span class="help-block">'+v+'</span>');
						if(k == 'FILE') {
							$('[name=apply_form]').find('#inputFileContact').parents('.form-group').addClass('has-error');
							$('[name=apply_form]').find('#inputFileContact').parents('.form-group').append('<span class="help-block">'+v+'</span>');
						}
					});
					$("#modal_apply").modal("hide");
					$('.form-send-error').text(resp.error_msg);
					$('#formSendModalError').modal('show');
				} else {
					$("#modal_apply").modal("hide");
					$('.form-send-success').text(resp.success_msg);
					$('#formSendModal').modal('show');
				}
			}
		});
		
	});
});



$(document).ready(function() {
    if ($(".content table").length > 0) {
        $(".content table").wrap("<div class='table_responsive_outer'></div>");
        $(".content table").wrap("<div class='content_table'></div>");
        $(".content_table").prepend("<div class='content_table__btn content_table__btn--right'></div>");
        $(".content_table").prepend("<div class='content_table__btn content_table__btn--left'></div>");
        $(".content table").wrap("<div class='scrollbar-dynamic content_table--scrollbar'></div>");
        $(".content .scrollbar-dynamic").scrollbar();
    }

    

    $(".content_table__btn--left").click(function() {
        var tab_width = $(this).closest(".content_table").width();
        var bar_left = parseInt($(this).closest(".content_table").find('.scrollbar-dynamic .scroll-bar').css("left"));
        var table = $(this).closest(".content_table").find('table').width();
        var left = bar_left / tab_width * table;
        var scrollbar = $(this).closest(".content_table").find('.scrollbar-dynamic');
        $(scrollbar).scrollLeft(left - tab_width / 2);
        setTimeout(function() {
            tab_scrollbar_arr();
        }, 600);

    })

    $(".content_table__btn--right").click(function() {
        var tab_width = $(this).closest(".content_table").width();
        var bar_left = parseInt($(this).closest(".content_table").find('.scrollbar-dynamic .scroll-bar').css("left"));
        var table = $(this).closest(".content_table").find('table').width();
        var left = bar_left / tab_width * table;
        var scrollbar = $(this).closest(".content_table").find('.scrollbar-dynamic');
        $(scrollbar).scrollLeft(left + tab_width / 2);
        setTimeout(function() {
            tab_scrollbar_arr();
        }, 600);
    })


    $(window).resize(function() {
        tab_scrollbar_init();
    })

})

jQuery(document).ready(function(){//$(window).load(function() {	
    tab_scrollbar_init();

    $(".content_table--scrollbar").on("scroll", function() {
        if ($(".content_table--scrollbar").hasClass("scroll-scrollx_visible")) {
            tab_scrollbar_arr();
        }
    });

    var nav_slider;
    var for_slider;

    function slider_nav() {
        for_slider = $('.detail-slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            dots: false,
            asNavFor: '.detail-slider-nav'
        });

        nav_slider = $('.detail-slider-nav').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.detail-slider-for',
            mobileFirst: true,
            arrows: false,
            dots: false,
            focusOnSelect: true,
            responsive: [{
                breakpoint: 1199,
                settings: {
                    slidesToShow: 4
                }
            }, {
                breakpoint: 992,
                settings: {
                    slidesToShow: 4
                }
            }, {
                breakpoint: 500,
                settings: {
                    slidesToShow: 3
                }
            }]
        });

    }

    slider_nav();
	
	$('.detail-slider-for').slickLightbox({
		itemSelector        : 'a',
		navigateByKeyboard  : true,
		//src: "data-src"
	});
	
	$(".chocolat-gallery--new").slickLightbox(
    {
		 caption: function(element, info) { return $(element).find('.chocolat-image-preview').html(); },
		 src: "data-src",
		 itemSelector: '.chocolat-image'
	});

	Array.prototype.forEach.call(document.querySelectorAll('.mask'), function(input) {
	    var keyCode;

	    function mask(event) {
	        event.keyCode && (keyCode = event.keyCode);
	        var pos = this.selectionStart;
	        if (pos < 3) event.preventDefault();
	        var matrix = "+7 (___) ___ ____",
	            i = 0,
	            def = matrix.replace(/\D/g, ""),
	            val = this.value.replace(/\D/g, ""),
	            new_value = matrix.replace(/[_\d]/g, function(a) {
	                return i < val.length ? val.charAt(i++) || def.charAt(i) : a
	            });
	        i = new_value.indexOf("_");
	        if (i != -1) {
	            i < 5 && (i = 3);
	            new_value = new_value.slice(0, i)
	        }
	        var reg = matrix.substr(0, this.value.length).replace(/_+/g,
	            function(a) {
	                return "\\d{1," + a.length + "}"
	            }).replace(/[+()]/g, "\\$&");
	        reg = new RegExp("^" + reg + "$");
	        if (!reg.test(this.value) || this.value.length < 5 || keyCode > 47 && keyCode < 58) this.value = new_value;
	        if (event.type == "blur" && this.value.length < 17) this.value = "";
	        
	    }

	    input.addEventListener("input", mask, false);
	    input.addEventListener("focus", mask, false);
	    input.addEventListener("blur", mask, false);
	    input.addEventListener("keydown", mask, false)
	    

	});

});

jQuery(document).ajaxComplete(function(){
	Array.prototype.forEach.call(document.querySelectorAll('.mask'), function(input) {
	    var keyCode;

	    function mask(event) {
	        event.keyCode && (keyCode = event.keyCode);
	        var pos = this.selectionStart;
	        if (pos < 3) event.preventDefault();
	        var matrix = "+7 (___) ___ ____",
	            i = 0,
	            def = matrix.replace(/\D/g, ""),
	            val = this.value.replace(/\D/g, ""),
	            new_value = matrix.replace(/[_\d]/g, function(a) {
	                return i < val.length ? val.charAt(i++) || def.charAt(i) : a
	            });
	        i = new_value.indexOf("_");
	        if (i != -1) {
	            i < 5 && (i = 3);
	            new_value = new_value.slice(0, i)
	        }
	        var reg = matrix.substr(0, this.value.length).replace(/_+/g,
	            function(a) {
	                return "\\d{1," + a.length + "}"
	            }).replace(/[+()]/g, "\\$&");
	        reg = new RegExp("^" + reg + "$");
	        if (!reg.test(this.value) || this.value.length < 5 || keyCode > 47 && keyCode < 58) this.value = new_value;
	        if (event.type == "blur" && this.value.length < 17) this.value = "";
	        
	    }

	    input.addEventListener("input", mask, false);
	    input.addEventListener("focus", mask, false);
	    input.addEventListener("blur", mask, false);
	    input.addEventListener("keydown", mask, false)

	});
});

function asideRun() {
    if ($(".content_table .scroll-content").hasClass("scroll-scrollx_visible") && $('.content_table__btn').length > 0) {
        var proposalOffset = $('.content_table').offset().top;
        if ($(window).scrollTop() >= proposalOffset && ($(window).scrollTop() + $(window).height()) < (proposalOffset + $('.content_table').outerHeight())) {
            $(".content_table__btn").css({
                "transform": "translateY( " + ($(window).scrollTop() - proposalOffset) + "px)"
            });
        }
    }
}

function tab_scrollbar_init() {
    if ($(".content_table--scrollbar").hasClass("scroll-scrollx_visible")) {
        tab_scrollbar_arr();
    } else {
        $('.content_table__btn--left').addClass("content_table__btn--noactive");
        $('.content_table__btn--right').addClass("content_table__btn--noactive");
    }
    // if ($(".tab-serv-table").outerHeight() > $(window).height()) {
    //   $(".tab-serv-table").addClass("tab-serv-table--big")
    // } else {
    //   $(".tab-serv-table").removeClass("tab-serv-table--big")
    // }

    asideRun();

}

function tab_scrollbar_arr() {
    var bar_left = parseInt($(".content_table .scrollbar-dynamic .scroll-bar").css("left"));
    var bar_width = parseInt($(".content_table .scrollbar-dynamic .scroll-bar").css("width"));
    var tab_width = $(".content_table--scrollbar").width();
    if (bar_left > 10) {
        if (bar_width + bar_left + 10 >= tab_width) {
            $('.content_table__btn--right').addClass("content_table__btn--noactive");
            $('.content_table__btn--left').removeClass("content_table__btn--noactive");
        } else {
            $('.content_table__btn--left').removeClass("content_table__btn--noactive");
            $('.content_table__btn--right').removeClass("content_table__btn--noactive");
        }
    } else {
        $(".content_table__btn--left").addClass("content_table__btn--noactive");
        $('.content_table__btn--right').removeClass("content_table__btn--noactive");
    }
}

$(window).scroll(function() {
    if ($('.tab-serv-table__btn').length > 0) {
        asideRun();
    }
});

$(document).ready(function(){
	$('.file-load-contact').on('change','input',function(){				
		if($(this).parent().find('.min-row-del').length == 0) $(this).parent().append('<a href="#" class="min-row-del">удалить</a>'); 
		$(this).parents('.label-file').append('<p class="min-row"><input class="inputFile inputFileContact" type="file" name="FILE[]" multiple=""></p>'); 
	});
	$('.file-load-contact').on('click', '.min-row-del', function(){
		$(this).parent().remove(); 
		return false;
	});

	$('[data-admin-only=Y]').append('<span class="admin-only-label">Доступно под админом</span>');
});
 

$(document).on('hidden.bs.modal', '#modal_success, #formSendModal', function (event) {
	window.location.href = '/';
});
