<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class Sp_Featured_Products extends Module
{
    public $imagePath;
    public function __construct()
    {
        $this->name = 'sp_featured_products';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'wxyz';
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Featured Products');
        $this->description = $this->l('Featured Products of the store.');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }

    /**
     * @see Module::install()
     */
    public function install()
    {
        return (
            parent::install()
            && $this->registerHook('displayHome')
            && $this->registerHook('displayBackOfficeHeader')
        );
    }

    /**
     * @see Module::uninstall()
     */
    public function uninstall()
    {


        return parent::uninstall();
    }

    public function HookDisplayHome()
    {
        $this->context->smarty->assign(
            [
                'featured_product' => Configuration::get("update_product"),
                'productsDetailsArray' => $this->getProductDetailsFromConfiguration(),
            ]
        );
        return $this->display(__FILE__, 'sp_featured_products.tpl');
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->registerStylesheet('product-style-classic', 'modules/' . $this->name . '/css/slick.css', ['media' => 'all', 'priority' => 150]);
        $this->context->controller->registerJavascript('product-js-classic', 'modules/' . $this->name . '/js/slick.min.js', ['position' => 'top', 'priority' => 150]);
        $this->context->controller->registerJavascript('product-js-custom', 'modules/' . $this->name . '/js/custom_slick.js', ['position' => 'top', 'priority' => 150]);
    }

    public function getContent()
    {
        $this->context->controller->addCSS(($this->_path) . 'css/select2.min.css', 'all');
        $this->context->controller->addJS(($this->_path) . 'js/select2.min.js', 'all');
        $this->context->controller->addJS(($this->_path) . 'js/html5sortable.min.js', 'all');
        $this->context->controller->addJS(($this->_path) . 'js/select2.sortable.min.js', 'all');
        $this->context->controller->addJS(($this->_path) . 'js/custom_select.js', 'all');

        if (Tools::getValue('submit')) {
            $this->updateProductIdToConfiguration();
            $this->storeProductDetailsToConfiguration();
            $this->getProductDetailsFromConfiguration();
        }
        return $this->selectProduct();
    }

    public function updateProductIdToConfiguration(){
        $productId = $_POST['products'];
        $productArray = json_encode($productId);
        Configuration::updateValue('update_product', $productArray);
    }

    public function getProductDetails()
    {        
        $productsData=array();
        $lang_id = (int) Configuration::get('PS_LANG_DEFAULT');
        $productIdFromConfiguration=Configuration::get("update_product");
        $productIdList = json_decode($productIdFromConfiguration);
        foreach ($productIdList as $productIds) {
            $product = new Product($productIds, false, $lang_id);
            $pName = $product->name;
            $productImages = $product->getImages((int) $lang_id);
            if ($productImages && count($productImages) > 0) {
                $link = new Link;
                foreach ($productImages as $key => $val) {
                    $id_image = $val['id_image'];
                    $imagePath = "http://" . $link->getImageLink($product->link_rewrite[Context::getContext()->language->id], $id_image, 'home_default');
                }
            }
            $productsData[] = [
                "name" => $pName,
                "path" => $imagePath
            ];
        }
        return $productsData;
    }

    public function storeProductDetailsToConfiguration(){
        $productDetails=$this->getProductDetails();
        $productsDetailsString = json_encode($productDetails);
        Configuration::updateValue('product_details', $productsDetailsString);
    }

    public function getProductDetailsFromConfiguration(){
        return $this->getProductDetails(); 
    }

    public function selectProduct()
    {
        $this->context->smarty->assign(
            [
                'dbData' => $this->getDbContent(),
                'admin_url' => $this->context->link->getAdminLink('AdminModules', false) . '&token=' . Tools::getAdminTokenLite('AdminModules') . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name,
            ]
        );
        return $this->display(__FILE__, 'selectProduct.tpl');
    }

    public function getDbContent()
    {
        $db = \Db::getInstance();
        $request = "SELECT ps_product_lang.id_product,ps_product_lang.name FROM ps_product_lang LEFT JOIN ps_product ON ps_product.id_product=ps_product_lang.id_product WHERE id_lang='1' and name like '%%demo';";
        $result = $db->executeS($request);
        return $result;
    }
}
?>