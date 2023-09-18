function getSliderSettings(){
    return{
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
    }
}

$(document).ready(function () {
    $.ajax({
        url: '/shop/modules/itj_blog_section/ajax_cms.php',
        type : 'POST',
        data : {
            ajax: true,
            action: "fetchTPL",
        },
        success : function(result) {
            $('#cms-block-details').append(result);
            $('#cms-block-details').slick('unslick');
            $('#cms-block-details').slick(getSliderSettings());            
        }
    });
});
