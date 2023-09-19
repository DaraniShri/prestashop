jQuery(document).ready(function () {
   
   initslideToShow = 5;
   
   if(jQuery(window).width() <= 1200){
    initslideToShow = 3;
   }
   if(jQuery(window).width() <= 998){
    initslideToShow = 2;
   }
   if(jQuery(window).width() <= 599){
    initslideToShow = 1;
   }

   jQuery("#itJonactionBlockProducts > .block > .right-block > .products").slick({
         slidesToShow: initslideToShow,
         slidesToScroll: 1,
         arrows: true,
         dots: false,
         responsive: [
            {
                breakpoint: 1200,
                settings: {
                     slidesToShow: 3
                }
            },
            {
                breakpoint: 998,
                settings: {
                     slidesToShow: 2
                }
            },
            {
                breakpoint: 767,
                settings: {
                     slidesToShow: 2
                }
            },
            {   breakpoint: 599,
                settings: {
                     slidesToShow: 1
                }
            }
         ]
    });
   
});