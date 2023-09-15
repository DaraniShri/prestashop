jQuery(document).ready(function () {

    jQuery('.full-block').each(function (index, element) {
        var block = jQuery('#' + element.id);
        if (index === 0) {
            block.find('#list-block-name').addClass('active');
            block.find('.block-content').addClass('active');
        }
        jQuery("#capitoolsBlockTabs").append(block.find('#list-block-name'));
        jQuery("#capitoolsBlockTabsContent").append(block.find('.block-content'));
        element.remove();
    });

    jQuery('.form-input').hide();
    jQuery('.form-input.' + jQuery("#module_form").attr("formlang")).show();

    jQuery('.language-option').change(function () {
        jQuery("#module_form").attr("formlang", jQuery(this).val());
        jQuery(".language-option").val(jQuery(this).val());
        jQuery('.form-input').hide();
        jQuery('.form-input.' + jQuery("#module_form").attr("formlang")).show();
    });

    jQuery('.delete-icon').click(function () {
        //console.log(jQuery(".language-option").val()); 
        iconId = jQuery(this).attr("id");
        $imgPathId = "."+iconId.replace("icon", "img");
        $imagePathId = "#"+iconId.replace("icon", "image_path");
        jQuery($imagePathId).val("remove");

        jQuery($imgPathId).remove();
        jQuery(this).remove();
    });

});