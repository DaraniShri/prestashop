<?php
    include_once('../../config/config.inc.php');
    include_once('../../init.php');

    $itj_blog_section_obj = Module::getInstanceByName('itj_blog_section');
    $blocks = $itj_blog_section_obj -> getTemplate();

    echo $blocks;
?>