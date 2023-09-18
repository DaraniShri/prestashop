function getSlickDetails(){
    return{
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
    }
}

jQuery(document).ready(function () {

    var productDataUrl = '/shop/modules/itj_home_product_block/ajax_call_dom.php?getProducts=efk;4jif-024ijf24ij230&&shop_id='+jQuery("#module_form").data("shopid");
    $.ajax({
        url: productDataUrl,
        type : 'POST',
        data : {
            ajax: true,
            action: "fetchTPL",
        },
        success : function(response) {
            $('#itJonactionBlockProducts').append(response);
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
            jQuery('#itJonactionBlockProducts > .block > .right-block > .products').slick(getSlickDetails());
        }
    });
});
