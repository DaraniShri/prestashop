<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class Itj_Blog_Section extends Module {

    public $numberOfBlock = 6;
    protected static $cache_products;

    public function __construct() {
        $this->name = 'itj_blog_section';
        $this->version = '0.0.1';
        $this->author = 'IT Jonction Lab';
        $this->need_instance = 0;
        $this->bootstrap = true;
        $this->ps_versions_compliancy = ['min' => '1.7.1.0','max' => _PS_VERSION_,];
        parent::__construct();

        $this->displayName = $this->l('Blog info display on Footer');
        $this->description = $this->l('Displays Blog updates for homepage.');
        $this->registerHook('displayHeader');
    }

    public function install() {
        if (!parent::install() 
                || !$this->registerHook('displayHome')
        ) {
            return false;
        }
        return true;
    }

    public function uninstall() {
        return parent::uninstall();
    }

    public function hookDisplayHeader($params) {                              
        if($this->context->controller->php_self=="index"){             
            $this->context->controller->addCSS(($this->_path) . 'css/itj_blog_section.css', 'all');
            $this->context->controller->addJS(($this->_path).'js/itj_blog_section.front.js', 'all');    
            $this->context->controller->addJS(($this->_path).'js/cms.js', 'all');        
        }    
    }

    public function hookDisplayHome($params) {
        
        //if(isset($params['display'])){           
            // $options=[];
            // foreach (Language::getLanguages() as $lang) {
            //     $options[] = [
            //         'id_option' => $lang['id_lang'],
            //         'name' => $lang['name'],
            //         'iso_code' => $lang['iso_code']
            //     ];
            // }
            // $blocks = $this->getFullBlock($options);
        $blocks = $this->getCMSPageBlock();
        $this->smarty->assign(
                array(
                    'blocks' => array_reverse($blocks)
                )
        );
        return $this->display(__FILE__, 'view/templates/hook/blockCmsPages.tpl');
    }

    public function getBlock($number,$option,$get_product_title = false) { 
        return array( 
            'itj_blog_section_image_' . $number . '_'.$option['iso_code'] => Configuration::get('itj_blog_section_image_' . $number . '_'.$option['iso_code']), 
            'itj_blog_section_name_' . $number . '_'.$option['iso_code'] => Configuration::get('itj_blog_section_name_' . $number . '_'.$option['iso_code']), 
            'itj_blog_section_description_' . $number . '_'.$option['iso_code'] => Configuration::get('itj_blog_section_description_' . $number . '_'.$option['iso_code']), 
            'itj_blog_section_link_' . $number . '_'.$option['iso_code'] => Configuration::get('itj_blog_section_link_' . $number . '_'.$option['iso_code']) 
        ); 
    } 

    public function setBlock($number, $lang, $data = array()) { 
        if (isset($data['itj_blog_section_name']) && !empty($data['itj_blog_section_name'])) { 
            $name = 'itj_blog_section_name_' . $number .'_'.$lang; 
            Configuration::updateValue($name, $data['itj_blog_section_name']); 
        } 
        if (isset($data['itj_blog_section_image']) && !empty($data['itj_blog_section_image'])) { 
            $name = 'itj_blog_section_image_' . $number .'_'.$lang; 
            if($data['itj_blog_section_image']=="remove"){
                Configuration::updateValue($name, ""); 
            }else{
                Configuration::updateValue($name, $data['itj_blog_section_image']); 
            }
        } 
        if (isset($data['itj_blog_section_description']) && !empty($data['itj_blog_section_description'])) { 
            $description = 'itj_blog_section_description_' . $number .'_'.$lang; 
            Configuration::updateValue($description, $data['itj_blog_section_description']); 
        } 
        if (isset($data['itj_blog_section_link']) && !empty($data['itj_blog_section_link'])) { 
            $link = 'itj_blog_section_link_' . $number .'_'.$lang; 
            Configuration::updateValue($link, $data['itj_blog_section_link']); 
        } 
    } 

    public function getContent() { 
        $default_lang = (int) Configuration::get('PS_LANG_DEFAULT'); 
        $options=[]; 
        foreach (Language::getLanguages() as $lang) { 
            $options[] = [ 
                'id_option' => $lang['id_lang'], 
                'name' => $lang['name'], 
                'iso_code' => $lang['iso_code'] 
            ]; 
        } 

        if (!empty($_POST['submititjonctionblockproducts']) && $_POST['submititjonctionblockproducts'] == '1') { 
            for ($i = 1; $i <= $this->numberOfBlock; $i++) { 
                foreach($options as $option){ 
                    //print_r($_POST['itj_blog_section_image_' . $i . '_'.$option['iso_code']]);die(); 
                    $update = array(); 
                    if (!empty($_POST['itj_blog_section_name_' . $i . '_'.$option['iso_code']])) { 
                        $update['itj_blog_section_name'] = $_POST['itj_blog_section_name_' . $i . '_'.$option['iso_code']]; 
                    } 
                    if (!empty($_POST['itj_blog_section_description_' . $i . '_'.$option['iso_code']])) { 
                        $update['itj_blog_section_description'] = $_POST['itj_blog_section_description_' . $i . '_'.$option['iso_code']]; 
                    } 
                    if (!empty($_POST['itj_blog_section_link_' . $i . '_'.$option['iso_code']])) { 
                        $update['itj_blog_section_link'] = $_POST['itj_blog_section_link_' . $i . '_'.$option['iso_code']]; 
                    } 
                    if (!empty($_FILES['itj_blog_section_image_' . $i . '_'.$option['iso_code']]["name"])) { 
                        if (!empty(getimagesize($_FILES['itj_blog_section_image_' . $i . '_'.$option['iso_code']]["tmp_name"]))) { 
                            $filename = pathinfo($_FILES['itj_blog_section_image_' . $i . '_'.$option['iso_code']]["name"]); 
                            $target_file = dirname(__FILE__)."/img/img_".$this->context->shop->name."_".$i."_".$option['iso_code']."_".time().".".$filename["extension"];                                                         
                            $image=Configuration::get('itj_blog_section_image_' . $i . '_'.$option['iso_code']);                            
                            if(file_exists( dirname(__FILE__)."/img/".$image)){
                                 unlink(dirname(__FILE__).'/img/'.$image);
                            }                                                       
                            move_uploaded_file($_FILES['itj_blog_section_image_' . $i . '_'.$option['iso_code']]["tmp_name"], $target_file); 
                            $update['itj_blog_section_image'] = "img_".$this->context->shop->name."_".$i."_".$option['iso_code']."_".time().".".$filename["extension"]; 
                        } 
                    } 
                    if(!empty($_POST['image_path_'.$i.'_'.$option['iso_code']])){
                        //print_r($update);die();
                        if($_POST['image_path_'.$i.'_'.$option['iso_code']] == "remove"){
                            $target_file = dirname(__FILE__)."/img/img_".$this->context->shop->name."_".$i."_".$option['iso_code']."."."png"; 
                            $update['itj_blog_section_image'] = "remove";
                            //unlink(_PS_MODULE_DIR_."itj_blog_section/img/img_".$this->context->shop->name."_".$i."_".$option['iso_code']."."."png");
                            //echo "<br>".$_POST['image_path_'.$i.'_'.$option['iso_code']];//die();
                        }
                    }
                    if (!empty($update)) { 
                        $this->setBlock($i, $option['iso_code'] , $update); 
                    } 
                }
            } 
        } 

        $saved_data = $this->getSavedData($options); 

        $main = array( 
            'admin_url' => $this->context->link->getAdminLink('AdminModules', false) . '&token=' . Tools::getAdminTokenLite('AdminModules') . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name, 
            'saved_data' => $saved_data, 
            'number_of_block' => $this->numberOfBlock, 
            'language_option' => $options, 
            'language_default' => $this->context->language->iso_code 
        ); 

        $this->context->controller->addCSS(($this->_path) . 'css/main.css', 'all'); 
        $this->context->controller->addJS(($this->_path) . 'js/itj_blog_section.js', 'all'); 
        $this->smarty->assign($main); 
        return $this->display(__FILE__, 'view/admin/admin.tpl'); 
    } 

    public function getSavedData($options) { 
        $saved_data = array(); 
        for ($i = 1; $i <= $this->numberOfBlock; $i++) { 
            foreach($options as $option){ 
                $saved_data['itj_blog_section_' . $i . '_'.$option['iso_code']] = $this->getBlock($i,$option, true); 
            } 
        } 
        return $saved_data; 
    } 

    public function getFullBlock($options) { 
        if (!isset(itj_blog_section::$cache_products)) { 
            $result = array(); 
            for ($i = 1; $i <= $this->numberOfBlock; $i++) { 
                foreach($options as $option){ 
                    $blockArray = $this->getBlock($i,$option); 
                    $block_name = $blockArray['itj_blog_section_name_' . $i . '_'.$option['iso_code']]; 
                    $block_image = $blockArray['itj_blog_section_image_' . $i . '_'.$option['iso_code']]; 
                    $block_description = $blockArray['itj_blog_section_description_' . $i . '_'.$option['iso_code']]; 
                    $block_link = $blockArray['itj_blog_section_link_' . $i . '_'.$option['iso_code']]; 
                    $result[$i]['itj_blog_section_title'][$option['iso_code']] = $block_name; 
                    $result[$i]['itj_blog_section_image'][$option['iso_code']] = $block_image; 
                    $result[$i]['itj_blog_section_description'][$option['iso_code']] = $block_description; 
                    $result[$i]['itj_blog_section_link'][$option['iso_code']] = $block_link; 
                } 
            } 
            itj_blog_section::$cache_products = $result; 
        } 
        return itj_blog_section::$cache_products; 
    } 

    public function getCMSPageBlock(){
        $cms = new CMS();
        $pages = $cms->getCMSPages(Context::getContext()->language->id , 3, true, 1);
        $cms_page = [];
        foreach($pages as $page){
            $link = new Link();
            $page['page_link'] = $link->getCMSLink($page['id_cms']);
            $cms_page[] = $page;
        }
        return $cms_page; 
    }
}
