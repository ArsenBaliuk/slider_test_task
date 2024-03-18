jQuery(document).ready(function ($) {

    jQuery(document).on('click', '.single-slide', function () {
        let slide_id = $(this).data('id');
        console.log(slide_id);
        jQuery('.popup-slider').addClass('active-popup');
        jQuery('.opacity-bg').addClass('show-bg');
        jQuery('html').css("overflow", "hidden");

        jQuery.ajax({
            url: ajax_object.ajaxurl,
            method: 'GET',
            data: {
                action: 'show_slide_desc',
                slide_id: slide_id,
            },
            success: function (response) {
                // jQuery('.popup_wrapper').empty();
                console.log(response);
                // jQuery('.popup_wrapper').append(response);

            },
        });

    });

    jQuery(document).on('click', '.close-popup-btn', function () {
        jQuery('.popup-slider').removeClass('active-popup');
        jQuery('.opacity-bg').removeClass('show-bg');
        jQuery('html').css("overflow", "unset");
    });

});

const swiperSlider = new Swiper('.swiper-slider', {
    centeredSlides: true,
    navigation: true,
    slidesPerView: "auto",
    loop: true,
    spaceBetween: 16,
    initialSlide: 0,
    createElements: true,
    pagination: {
        el: ".swiper-pagination",
        dynamicBullets: true,
        dynamicMainBullets: 4,
    },
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
        pauseOnMouseEnter:true,
    },
    breakpoints: {
        767: {
            centeredSlides: true,
            spaceBetween: 37.33,
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true,
                dynamicMainBullets: "auto",
            },
        },
        991: {
            centeredSlides: true,
            spaceBetween: 37.33,
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true,
                dynamicMainBullets: "auto",
            },
        },
        1440: {
            centeredSlides: false,
            slidesPerView: 4,
            slidesPerGroup: 2,
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true,
                dynamicMainBullets: "auto",
            },
        }
    },
});