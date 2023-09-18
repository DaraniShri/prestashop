jQuery(document).ready(function () {
    
    console.log('i am loaded');
    
    
    jQuery('.full-block').each(function (index, element) {
        var block = jQuery('#' + element.id);
        if( index === 0 ){
            block.find('#list-block-name').addClass('active');
            block.find('.block-content').addClass('active');
        }
        jQuery("#capitoolsBlockTabs").append(block.find('#list-block-name'));
        
        jQuery("#capitoolsBlockTabsContent").append(block.find('.block-content'));
        element.remove();
    });
    
    var productDataUrl = '/shop/modules/itj_home_product_block/ajax_help.php?getProducts=efk;4jif-024ijf24ij230&&shop_id='+jQuery("#module_form").data("shopid");
    
    jQuery(".select-home-product").select2({
        multiple: true,
        ajax: {
            url: productDataUrl,
            dataType: 'json',
            processResults: function (response) {
                return {
                    results: response
                };
            }
        }
    });
    jQuery(".select-home-product").trigger('change');
});