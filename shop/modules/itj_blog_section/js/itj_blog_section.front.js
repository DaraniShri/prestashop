jQuery(document).ready(function () {
   
   
   jQuery(".blog-update-block").find(".section-details").slick({
         lazyLoad: 'anticipated',
         slidesToShow: 4,
         slidesToScroll: 1,
         arrows: true,
         dots: false,
         responsive: [
            {
                breakpoint: 1024,
                settings: {
                     slidesToShow: 3
                }
            },
            {
                breakpoint: 992,
                settings: {
                     slidesToShow: 2
                }
            },
            {
                breakpoint: 600,
                settings: {
                     slidesToShow: 1
                }
            },
         ]
    });
   
});