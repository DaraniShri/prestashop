$(document).ready(function () {
    var cmsUrl = '/shop/modules/itj_blog_section/ajax_cms.php';
    $.ajax({
        url: cmsUrl,
        success: function (response) {
            console.log(response['url']);
                // $(".dflex .blog-image").append("<img src='C:/xampp/htdocs/shop/modules/itj_blog_section/img/cms/picture.jpg' alt=''>");
        }
    });
});