$(function(){
    var data=$("#products option:selected").text();
    $('#products').select2({
        placeholder: "Search a product",
        multiple:true,
        ajax: {
            type:'POST',
            url: '/shop/modules/sp_featured_products/ajax_call.php?term='+data+'&_type=query&q='+data+'',
        }
    });
    alert(data);

    $('#products').on('change', function() {
        var data = $("#products option:selected").text();
        $("#products").val(data);
    })
});