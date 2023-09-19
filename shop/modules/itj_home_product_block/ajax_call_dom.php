<?php

if(isset($_GET['getProducts']) && $_GET['getProducts'] === 'efk;4jif-024ijf24ij230'){
    include_once('../../config/config.inc.php');
    include_once('../../init.php');
   
    $itj_home_product_block_obj = Module::getInstanceByName('itj_home_product_block');
    $blocks = $itj_home_product_block_obj -> getFullProductBlock();

    $smarty = new Smarty();
    $smarty->assign('blocks', $blocks);
    $response = $smarty->fetch(_PS_MODULE_DIR_.'itj_home_product_block/view/templates/hook/ajaxProduct.tpl');
    echo $response;
}

