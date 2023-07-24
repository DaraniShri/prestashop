<?php
    echo "hello";
    include_once('../../config/config.inc.php');
    include_once('../../init.php');
    if(isset($_GET['term'])){
        $product=$_POST['term'];
        echo $product;
    }
   
?>