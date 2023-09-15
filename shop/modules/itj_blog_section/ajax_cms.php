<?php
    include_once('../../config/config.inc.php');
    include_once('../../init.php');
    
    $db = \Db::getInstance();
    $query = "SELECT id_cms, meta_title FROM ps_cms_lang WHERE id_lang = 1 AND id_shop = 1 AND id_cms > 5";
    $result=$db->executeS($query);
    foreach($result as $val){
        $cms = new CMS($val['id_cms']);
        $link = new Link();
        $url = $link->getCMSLink($cms);
        $response = array(
            'name' => $val['meta_title'],
            'url' => $url,
        );
        if(!empty($response)){
            echo json_encode($response);
        }
    }
?>