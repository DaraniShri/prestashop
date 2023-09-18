<?php

if(isset($_GET['getProducts']) && $_GET['getProducts'] === 'efk;4jif-024ijf24ij230'){
    include_once('../../config/config.inc.php');
    include_once('../../init.php');
    $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
    $sql = 'SELECT
    DISTINCT p.id_product as id, concat(p.reference," - ",pl.name) as text
    FROM ' . _DB_PREFIX_ . 'product p 
    LEFT JOIN ' . _DB_PREFIX_ . 'product_lang pl ON (p.id_product = pl.id_product)
    LEFT JOIN ' . _DB_PREFIX_ . 'stock_available s ON (p.id_product = s.id_product)
     WHERE p.active = 1 AND pl.id_shop='.pSQL($_GET['shop_id']).' AND pl.id_lang='.$cookie->id_lang;
    if(!empty($_GET['q'])){
        $sql .= ' AND (pl.name LIKE "%' . pSQL($_GET['q']) . '%" OR p.reference LIKE "%' . pSQL($_GET['q']) . '%")';
    }
    $products = $db->executeS($sql);
    echo json_encode($products);
}

