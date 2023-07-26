$(document).ready(function () {
    var productDataUrl = '/shop/modules/sp_featured_products/ajax_call.php?';
    $(".products").select2({
        multiple: true,
        ajax: {
            url: productDataUrl,
            dataType: 'json',
            processResults: function (response) {
                console.log(response);
                return {
                    results: response
                }
            }
        },
    });
    jQuery(".products").trigger('change');
});