<?php
    include_once('../../config/config.inc.php');
    include_once('../../init.php');

    $cms = new CMS();
    $link = new Link();
    $pages = $cms->getCMSPages(Context::getContext()->language->id , 3, true, 1);
    $cms_page = [];
    foreach($pages as $page){
        $page['page_link'] = $link->getCMSLink($page['id_cms']);
        $cms_page[] = $page;
    }
    $smarty = new Smarty();
    $smarty->assign('cms_page', $cms_page);
    $response = $smarty->fetch(_PS_MODULE_DIR_.'itj_blog_section/view/templates/hook/customBlockCmsPages.tpl');
    echo $response;
?>