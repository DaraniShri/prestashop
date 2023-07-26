<?php
    include_once('../../config/config.inc.php');
    include_once('../../init.php');
    if(isset($_GET['q'])){
        $product=$_GET['q'];
        $db = \Db::getInstance();
        $request="SELECT ps_product.id_product AS id,CONCAT(ps_product.reference,'-',ps_product_lang.name) AS text FROM ps_product LEFT JOIN ps_product_lang ON ps_product_lang.id_product=ps_product.id_product WHERE id_lang='1' and name like '%$product%';";
        $result=$db->executeS($request);
        if($result){
            echo json_encode($result);
        }
    }
   
?>