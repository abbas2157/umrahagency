(function ($) {
    jQuery.fn.checkEmpty = function () {
        return !$.trim(this.html()).length;
    };
}(jQuery));

$(document).ready(function () {

    //Search Engine Click functions Ends
    if ($(".Passengers").hasClass("auto-filled-values")) {
        countPassenger($(this).find(".minus").parents("form"));
    }

    if ($(".Passengers").length > 0) {
        $(".passengers").each(function (index, el) {
            countPassenger($(this).find(".minus").parents("form"));
        });
    }

    $(".plus").click(function () {
        var Adult = $(this).parents("form").find(".totalAdult").val();
        var Child = $(this).parents("form").find(".totalChild").val();
        var Infant = $(this).parents("form").find(".totalInfant").val();
        var mainPhone = $(".navbar-nav").find(".nav-item.phone a").text();

        if (parseInt(Adult) + parseInt(Child) + parseInt(Infant) < 9) {
            if ($(this).siblings("input.passengerInput").hasClass("totalAdult")) {
                addPassenger($(this));
            } else if ($(this).siblings("input.passengerInput").hasClass("totalChild")) {
                if (Child < Adult * 2) {
                    addPassenger($(this));
                } else {
                    alert("Maximum number of child should be double number of adults!");
                }
            } else if ($(this).siblings("input.passengerInput").hasClass("totalInfant")) {
                if (Infant < Adult) {
                    addPassenger($(this));
                } else {
                    alert("Number of infants should be equal to or less then number of adults!");
                }
            }
        } else {
            alert("Total no of person should not be more than 9!\n Call us on " + mainPhone.trim() + " for bulk bookings.");
        }
    });

    $(".minus").click(function () {
        var Adult = $(this).parents("form").find(".totalAdult").val();
        var Child = $(this).parents("form").find(".totalChild").val();
        var Infant = $(this).parents("form").find(".totalInfant").val();

        if ($(this).siblings("input.passengerInput").hasClass("totalAdult")) {
            if (Adult * 2 <= Child || Adult * 2 - 1 <= Child) {
                alert("Kindly decrease the number of Children first!");
            } else if (Adult <= Infant) {
                alert("Kindly decrease the number of Infant first!");
            } else {
                minusPassenger($(this));
            }
        } else if ($(this).siblings("input.passengerInput").hasClass("totalChild") || $(this).siblings("input.passengerInput").hasClass("totalInfant")) {
            minusPassenger($(this));
        }
    });
    $(".passenger-contain")
        .find(".inputValue")
        .val("0" + 1 + " Adt - 0" + 0 + " Chd - 0" + 0 + " Inf");

    function countPassenger(value) {
        var adultCount = $(value).find("input.totalAdult").val();
        var childCount = $(value).find("input.totalChild").val();
        var infantCount = $(value).find("input.totalInfant").val();
        $(value)
            .find(".inputValue")
            .val("0" + adultCount + " Adt - 0" + childCount + " Chd - 0" + infantCount + " Inf");
    }

    function addPassenger(value) {
        if (value.parents(".passenger").find(".passengerInput").val() < 10) {
            value
                .parents(".passenger")
                .find(".passengerInput")
                .val(+value.parents(".passenger").find(".passengerInput").val() + 1);
        }
        countPassenger(value.parents("form"));
    }

    function minusPassenger(value) {
        if (value.parents(".passenger").find(".passengerInput").val() > (value.parents(".passenger").find(".passengerInput").hasClass("totalAdult") ? 1 : 0)) {
            value
                .parents(".passenger")
                .find(".passengerInput")
                .val(+value.parents(".passenger").find(".passengerInput").val() - 1);
        }
        countPassenger(value.parents("form"));
    }

    //count passenger js End

    //match height js Start
    if ($(".holidayStructureText").length > 0) {
        $(".holidayStructureText .desciption").matchHeight();
    }
    if ($(".mainPackage").length > 0) {
        $(".mainPackage").matchHeight();
    }
    if ($(".holidayText").length > 0) {
        $(".holidayText").matchHeight();
    }
    if ($(".hajjpackage").length > 0) {
        $(".hajjpackage").matchHeight();
    }
    if ($(".mainPackage").length > 0) {
        $(".mainPackage .mainPackageDesc .title").matchHeight();
        $(".mainPackage .mainPackageDesc .tagline").matchHeight();
    }
    //match height js End

    //owl carousel js Start
    if ($('.owl-carousel').length > 0) {
        $('.owl-carousel').each(function () {
            var $carousel = $(this);
            owlOptions = {
                items: $carousel.data("items"),
                slideBy: $carousel.data("slideby"),
                center: $carousel.data("center"),
                loop: $carousel.data("loop"),
                margin: $carousel.data("margin"),
                nav: $carousel.data("nav"),
                dots: $carousel.data("dots"),
                autoplay: $carousel.data("autoplay"),
                responsive: $carousel.data("responsive"),
                autoplayTimeout: $carousel.data("autoplay-timeout"),
                navContainer: $carousel.parents('.container').find('.customNav'),
                navText: ['<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24.5 30.3" style="enable-background:new 0 0 24.5 30.3; transform: rotate(180deg);" xml:space="preserve"><path d="M0.9,2.2c-1.6-2.3-1-2.9,1.4-1.5l21.2,12.9c1.4,0.9,1.4,2.3,0,3.1L2.3,29.6c-2.4,1.4-3,0.8-1.4-1.5l1-1.5c4.5-6.3,4.5-16.6,0-22.9L0.9,2.2z"/></svg>', '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24.5 30.3" style="enable-background:new 0 0 24.5 30.3;" xml:space="preserve"><path d="M0.9,2.2c-1.6-2.3-1-2.9,1.4-1.5l21.2,12.9c1.4,0.9,1.4,2.3,0,3.1L2.3,29.6c-2.4,1.4-3,0.8-1.4-1.5l1-1.5c4.5-6.3,4.5-16.6,0-22.9L0.9,2.2z"/></svg>'],
                responsive: {
                    0: {
                        items: 1,
                        margin: $carousel.data("responsive-margin"),
                    },
                    575.98: {
                        items: $carousel.data("responsive-small"),
                        margin: $carousel.data("small-responsive-margin"),
                    },
                    768: {
                        items: $carousel.data("responsive-medium"),
                        margin: $carousel.data("medium-responsive-margin"),
                    },
                    991: {
                        items: $carousel.data("responsive-large"),
                        margin: $carousel.data("large-responsive-margin"),
                    },
                    1200: {
                        items: $carousel.data("responsive-Xlarge"),
                        margin: $carousel.data("Xlarge-responsive-margin"),
                    }
                },
            };

            if (!$(this).hasClass('DisableCarousel')) {
                var owlActive = $carousel.owlCarousel(owlOptions);
            } else {
                $carousel.addClass('off');
            }
        });
    }
    //owl carousel js End


    // SVG images start
    //Redo XML
    /*$('img.svg').each(function(){
        var $img = $(this);
        var imgID = $img.attr('id');
        var imgClass = $img.attr('class');
        var imgURL = $img.attr('src');

        jQuery.get(imgURL, function(data) {
            // Get the SVG tag, ignore the rest
            var $svg = $(data).find('svg');

            // Add replaced image's ID to the new SVG
            if(typeof imgID !== 'undefined') {
                $svg = $svg.attr('id', imgID);
            }
            // Add replaced image's classes to the new SVG
            if(typeof imgClass !== 'undefined') {
                $svg = $svg.attr('class', imgClass+' replaced-svg');
            }

            // Remove any invalid XML tags as per http://validator.w3.org
            $svg = $svg.removeAttr('xmlns:a');

            // Replace image with new SVG
            $img.replaceWith($svg);

        }, 'xml');
    });*/
    // SVG images end

    // SVG images start
    $("img[src$='.svg']:not(.no-automate)").each(function () {
        var imgID = $(this).attr('id');
        var imgTitle = $(this).attr('title');
        var imgClass = $(this).attr('class');
        var imgURL = $(this).attr('src');
        //$svg=svg[imgURL];

        var $svg = $(svg[imgURL]);
        if (typeof imgID !== 'undefined') {
            $svg = $svg.attr('id', imgID);
        }
        // Add replaced image's classes to the new SVG
        if (typeof imgClass !== 'undefined') {
            $svg = $svg.attr('class', imgClass + ' replaced-svg');
        }

        $svg.append('<title>' + imgTitle + '</title>');
        $(this).replaceWith($svg);
    })
    // SVG images end

    //slick carousel js Start
    if ($(".package-slick-carousel").length > 0) {
        $('.package-slick-carousel').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.slick-carousel-nav'
        });
        $('.slick-carousel-nav').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.package-slick-carousel',
            dots: false,
            centerMode: true,
            focusOnSelect: true,
            prevArrow: $('.slick-arrow.left'),
            nextArrow: $('.slick-arrow.right'),
        });
    }
    //slick carousel js End

    //navbar bg color js Start
    var slider_height = $('.search-banner').height() - 300;
    var page_offset = $(window).scrollTop();
    if (slider_height > page_offset) {
        $("header").removeClass('with-bg');
    }
    else {
        $("header").addClass('with-bg');
    }
    $(window).scroll(function () {
        var slider_height = $('.search-banner').height() - 300;
        var page_offset = $(window).scrollTop();
        if (slider_height > page_offset) {
            $("header").removeClass('with-bg');
        }
        else {
            $("header").addClass('with-bg');
        }
    });
    //navbar bg color js End

    // Function to refresh text captcha
    function refreshCaptcha($form) {
        var $captchaSpan = $form.find('.captcha-text');
        var formId = $form.attr('id');
        var path = '/get-captcha';
        $.get(path + '?form_id=' + formId + '&t=' + Math.random(), function (data) {
            $captchaSpan.text(data);
        });
    }

    // Refresh captcha on load
    $(window).on('load', function () {
        $('.form').each(function () {
            refreshCaptcha($(this));
        });
    });

    //validation js Start
    if ($(".form").length > 0) {
        $(".form").each(function () {
            var $this = $(this);
            var time = $.now();
            var formId = 'form-' + time;
            $this.attr('id', formId);
            // Add hidden input for form_id if not exists
            if ($this.find('input[name="form_id"]').length === 0) {
                $this.prepend('<input type="hidden" name="form_id" value="' + formId + '">');
            }
            $this.validate({
                submitHandler: function (form) {
                    var $form = $(form);
                    var $btn = $form.find('button[type="submit"]');
                    var $btnTextSpan = $btn.find('.text');
                    var originalBtnText = $btnTextSpan.length ? $btnTextSpan.text() : $btn.text();

                    if ($btnTextSpan.length) {
                        $btnTextSpan.text('Sending...');
                    } else {
                        $btn.text('Sending...');
                    }
                    $btn.prop('disabled', true);

                    $.ajax({
                        url: $form.attr('action'),
                        type: 'POST',
                        data: $form.serialize(),
                        dataType: 'json',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                alert(response.message);
                                $form[0].reset();
                                // Refresh captcha
                                refreshCaptcha($form);
                                if ($('.modal').is(':visible')) {
                                    $('.modal').modal('hide');
                                }
                            } else {
                                alert(response.message);
                                // Refresh captcha on error too
                                refreshCaptcha($form);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                            alert('An error occurred. Please try again.');
                        },
                        complete: function () {
                            $btn.prop('disabled', false);
                            if ($btnTextSpan.length) {
                                $btnTextSpan.text(originalBtnText);
                            } else {
                                $btn.text(originalBtnText);
                            }
                        }
                    });
                    return false;
                },
            });
        });
    }
    //validation js End

    //datepicker js Start
    if ($('.DepartureDate').length > 0) {
        $('.DepartureDate').datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: +2,
            dayNamesMin: ["sun", "mon", "tue", "wed", "thu", "fri", "sat"]
        });
    }
    //datepicker js End

    //departure date check js Start
    jQuery(".selectDepart .btn-group-toggle .btn").click(function () {
        var input_val = jQuery(this).find("input").val();
        if (input_val == "Fixed") {
            jQuery(".departDate").collapse("show");
            jQuery(".DepartureDate").prop("disabled", false);
        } else {
            jQuery(".departDate").collapse("hide");
            jQuery(".DepartureDate").prop("disabled", true);
        }
    });
    //departure date check js End
    /* removing empty p on all site start*/
    $('p').each(function () {
        var $this = $(this);
        if ($this.html().replace(/\s|&nbsp;/g, '').length == 0)
            $this.remove();
    });

    $('.page-content').each(function () {
        if ($(this).find("div.container").checkEmpty()) {
            $(this).remove();
        }
    });

    /* removing empty p on all site end */
    //bootstrap carousel js Start
    $('.carousel').carousel({
        interval: 5000,
        pause: false
    });
    //bootstrap carousel js End

    var navbar_Height = $(".navbar").height() + 10;
    //navbar_Height = navbar_Height + 10;
    $(".bookNow").click(function (event) {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: $($(this).attr("href")).offset().top - navbar_Height
        }, 700);
    });
    $(".btnCustomized").click(function (event) {
        navbar_Height = navbar_Height + 30;
        event.preventDefault();
        $('html, body').animate({
            scrollTop: $($(this).attr("href")).offset().top - navbar_Height
        }, 700);
    });
    //dropdown
    $(".dropdown i").on("click", function () {
        $(this).toggleClass("fa-plus fa-minus");
        if ($(this).parents(".dropdown").hasClass("show-in")) {
            $(".dropdown").removeClass("show-in");
        } else {
            $(this).parents(".dropdown").toggleClass("show-in");
        }
    });
    //dropdown

    //back to top button Start
    if ($('#back-to-top').length) {
        var scrollTrigger = 100, // px
            backToTop = function () {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('#back-to-top').addClass('show');
                } else {
                    $('#back-to-top').removeClass('show');
                }
            };
        backToTop();
        $(window).on('scroll', function () {
            backToTop();
        });
        $('#back-to-top').on('click', function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: 0
            }, 1500);
        });
    }
    //back to top button End

    $(".PassengersField,.btn.general-btn.btn-block").on("click", function () {
        $(".beat-passenger-dropdown").slideToggle().toggleClass('active');
    })




    if ($(".scroll-page-content").length > 0) {
        var Scrollbar = window.Scrollbar;
        Scrollbar.init(document.querySelector('.scroll-page-content'), {
            alwaysShowTracks: true,
        });
    }

});

$(window).load(function () {
    $('#modalAlerts').modal('show');

    setTimeout(function () {
        $('.infoPopup').modal({
            show: true,
            backdrop: 'static',
            keyboard: false
        })
    }, 30000);

    $('.infoPopup').not('.active').on('hidden.bs.modal', function (e) {
        setInterval(function () {
            $('.infoPopup').not('.active').modal('show');
            $('.infoPopup').addClass('active');
        }, 60000);
        if ($('.infoPopup.active').length > 0) {
            Cookies.set('islamictravel_Promotion', $.now(), { expires: 1, path: '/' });
        }
    });

});





function customUploader(base_url) {
    var url = 'media.php';
    $("div.product_media").sortable();
    $('.catalog_product_image').each(function () {

        $(this).fileupload({
            url: url,
            dropZone: $(this).parents('.imageUpload'),
            dataType: 'json',
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 2000000, // 3MB
            add: function (e, data) {

                //alert('add');
                var uploadErrors = [];
                if (uploadErrors.length > 0) {
                    alert(uploadErrors.join("\n"));
                } else {
                    if ($(e.target).hasClass('blueimp-fileupload-disabled') && $(e.target).parents('.product_media_collection').find('.p_media').length >= 1) {
                        $(e.target).fileupload('disable');
                    } else {
                        data.submit();
                    }
                    if ($(e.target).data('single-image')) {
                        $(e.target).fileupload('disable');
                    }
                }
            },
            done: function (e, data) {
                //alert('done');
                $.each(data.result.files, function (index, file) {
                    if (file.url != "") {
                        var inp_name = 'p[media][]';
                        if ($(e.target).data('inp-name') && $(e.target).data('inp-name') != '') {
                            inp_name = $(e.target).data('inp-name');
                        }
                        $(e.target).parents('.product_media_collection').find('.progress-animated .progress-bar').css('width', '0');
                        var fileURL = file.url.replace(base_url, '');
                        var new_img = '<div class="p_media ui-state-default"><img src="' + fileURL + '?rand=' + Math.random() + '" class="img-responsive"><br><div class="btn-container"><button class="btn btn-danger delete deleteProductMedia" data-url="' + fileURL + '" data-type="Delete" onClick="deleteProductMedia(this,event)"><i class="fa fa-trash"></i></button> </div><input type="hidden" name="' + inp_name + '" value="' + fileURL + '"></div>';
                        $(e.target).parents('.product_media_collection').find('.product_media').append(new_img);
                    }
                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $(e.target).parents('.product_media_collection').find('.progress-animated .progress-bar').css(
                    'width',
                    progress + '%'
                );
                //alert('progress');
            }

        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled')
            .bind('fileuploadprocessfail', function (e, data) {
                alert(data.files[data.index].error);
                $('div.imageUpload').show();
                $('div#loading').hide();
            })
            .bind('fileuploadsubmit', function (e, data) {
                var thumb = medium = '';
                if ($(e.target).data('thumbnail') && $(e.target).data('thumbnail') != '') {
                    thumb = $(e.target).data('thumbnail');
                }
                if ($(e.target).data('medium') && $(e.target).data('medium') != '') {
                    medium = $(e.target).data('medium');
                }
                data.formData = {
                    'thumbnail': thumb,
                    'medium': medium,
                    'image_path': $(e.target).data('path'),
                };
            });
    })

    $("button.avatar-save").click(function () {
        var imgURL = $("input.avatar-src").val();
        var mainParent = $(this).parents('#avatar-modal').data('id');
        var thumb = medium = '';

        $.post('/administrator/crop.php', { 'avatar_src': $("input.avatar-src").val(), 'avatar_data': $('input.avatar-data').val() }, function (data) {
            if (data.state == 200 && data.result != 'null') {
                if ($('#' + mainParent).data("thumbnail")) //check to generate thumbnail on crop or not
                {
                    thumb = $('#' + mainParent).data('thumbnail').split("x");
                    $.post('ajax.php', { 'srcImage': imgURL, 'thumbWidth': thumb[0], 'thumbHeight': thumb[1], 'type': 'thumbnail', 'h': 'makeThumbnail' }, function (data) {
                        if (data == "success") {
                            $('#avatar-modal').modal('hide');
                            $("body").find("img[src='" + imgURL + "']").attr('src', imgURL + '?' + Math.random());
                        }
                    });
                }
                else {
                    $('#avatar-modal').modal('hide');
                    $("body").find("img[src='" + imgURL + "']").attr('src', imgURL + '?' + Math.random());
                }

                if ($('#' + mainParent).data("medium")) //check to generate medium on crop or not
                {
                    medium = $('#' + mainParent).data('medium').split("x");
                    $.post('ajax.php', { 'srcImage': imgURL, 'thumbWidth': medium[0], 'thumbHeight': medium[1], 'type': 'medium', 'h': 'makeThumbnail' }, function (data) {
                        if (data == "success") {
                            $('#avatar-modal').modal('hide');
                            $("body").find("img[src='" + imgURL + "']").attr('src', imgURL + '?' + Math.random());
                        }
                    });
                }
                else {
                    $('#avatar-modal').modal('hide');
                    $("body").find("img[src='" + imgURL + "']").attr('src', imgURL + '?' + Math.random());
                }
            }
        }, 'json');
    });

    $('#avatar-modal').on('hidden.bs.modal', function () {
        $(".avatar-wrapper img").cropper('destroy');
    });
}

function deleteProductMedia(obj, e) {
    e.preventDefault();
    $(obj).parents('div.p_media').append('<div class="fileDelete-process"></div>');
    $.post("ajax.php", { url: $(obj).data('url'), type: $(obj).data('type'), h: 'deleteMedia' }, function (data) {

        if (data.error == 1) {
            bootbox.alert(data.msg);
        } else {
            $(obj).parents('div.form-group').find('.form-control').removeClass("blueimp-fileupload-disabled");
            $(obj).parents('div.form-group').find('.catalog_product_image').fileupload('enable');
            $(obj).parents('div.p_media').remove();
        }
    }, 'json');
}


$(document).ready(function () {
    // Add click event to body element
    $('body').on('click', function (event) {
        if (!$(event.target).closest('.beat-passenger-dropdown,.inputValue.PassengersField').length) {
            if ($('.beat-passenger-dropdown').hasClass('active')) {
                $('.beat-passenger-dropdown').slideUp().removeClass('active');
            }
        }
    });

    $('.beat-passenger-dropdown,.inputValue.PassengersField').on('click', function (event) {
        event.stopPropagation();
    });

});