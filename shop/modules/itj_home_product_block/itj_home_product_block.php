<?php

if (!defined('_PS_VERSION_')) {
    exit;
}
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;

class itj_Home_Product_Block extends Module {

    public $numberOfBlock = 1;
    protected static $cache_products;

    public function __construct() {
        $this->name = 'itj_home_product_block';
        $this->version = '0.0.1';
        $this->author = 'IT Jonction Lab';
        $this->need_instance = 0;
        $this->bootstrap = true;
        $this->ps_versions_compliancy = ['min' => '1.7.1.0','max' => _PS_VERSION_,];
        parent::__construct();

        $this->displayName = $this->l('Featured products on the homepage');
        $this->description = $this->l('Displays featured products in the central column of your homepage.');
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
            $this->context->controller->addCSS(($this->_path) . 'css/itJonctionblockproducts.css', 'all');
            $this->context->controller->addJS(($this->_path) . 'js/itJonctionblockproducts.front.js', 'all');   
            $this->context->controller->addJS(($this->_path) . 'js/ajaxHomeProduct.js', 'all');     
        }    
    }

    public function hookDisplayHome($params) {
        return $this->display(__FILE__, 'view/templates/hook/blockProducts.tpl');
    }

    public function getBlock($number, $get_product_title = false) {
        $product_ids = Configuration::get('product_ids_' . $number);
        $selected_product = array();
        if ($get_product_title) {
            if (!empty($product_ids)) {
                $saved_ids = explode(', ', $product_ids);
                foreach ($saved_ids as $id) {
                    $product = new Product($id);
                    $selected_product[$id] = $product->reference . ' - ' . $product->name[$this->context->language->id];
                }
            } else {
                $selected_product = false;
            }
        } else {
            $selected_product = explode(', ', $product_ids);
        }

        return array(
            'block_name_' . $number => Configuration::get('block_name_' . $number),
            'product_ids_' . $number => $selected_product
        );
    }

    public function setBlock($number, $data = array()) {
        if (isset($data['name']) && !empty($data['name'])) {
            $name = 'block_name_' . $number;
            Configuration::updateValue($name, $data['name']);
        }

        if (is_string($data['product_ids']) && !empty($data['product_ids'])) {
            $product_ids = 'product_ids_' . $number;
            Configuration::updateValue($product_ids, $data['product_ids']);
        }
    }

    public function getContent() {
        if (!empty($_POST['submititjonctionblockproducts']) && $_POST['submititjonctionblockproducts'] == '1') {
            for ($i = 1; $i <= $this->numberOfBlock; $i++) {
                $update = array();
                if (!empty($_POST['block_name_' . $i])) {
                    $update['name'] = $_POST['block_name_' . $i];
                }
                if (!empty($_POST['product_ids_' . $i])) {
                    $update['product_ids'] = implode(', ', $_POST['product_ids_' . $i]);
                }
                if (!empty($update)) {
                    $this->setBlock($i, $update);
                }
            }
        }

        $saved_data = $this->getSavedData();

        $main = array(
            'admin_url' => $this->context->link->getAdminLink('AdminModules', false) . '&token=' . Tools::getAdminTokenLite('AdminModules') . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name,
            'saved_data' => $saved_data,
            'number_of_block' => $this->numberOfBlock,
            'shop_id' => $this->context->shop->id
        );

        $this->context->controller->addCSS(($this->_path) . 'css/select2.min.css', 'all');
        $this->context->controller->addCSS(($this->_path) . 'css/select2.sortable.css', 'all');
        $this->context->controller->addCSS(($this->_path) . 'css/main.css', 'all');

        $this->context->controller->addJS(($this->_path) . 'js/select2.min.js', 'all');
        $this->context->controller->addJS(($this->_path) . 'js/html5sortable.min.js', 'all');
        $this->context->controller->addJS(($this->_path) . 'js/select2.sortable.min.js', 'all');
        $this->context->controller->addJS(($this->_path) . 'js/itJonctionblockproducts.js', 'all');
        $this->smarty->assign($main);
        return $this->display(__FILE__, 'view/admin/admin.tpl');
    }

    public function getSavedData() {
        $saved_data = array();
        for ($i = 1; $i <= $this->numberOfBlock; $i++) {
            $saved_data['block_' . $i] = $this->getBlock($i, true);
        }
        return $saved_data;
    }

    public function getFullProductBlock() {
        global $cookie;$id_lang = $cookie->id_lang;
        if (!isset(itj_Home_Product_Block::$cache_products)) {
            $result = array();
            for ($i = 1; $i <= $this->numberOfBlock; $i++) {
                $blockArray = $this->getBlock($i);

                $block_name = $blockArray['block_name_' . $i];
                if (empty($block_name)) {
                    continue;
                }
                $result[$i]['title'] = $block_name;
                $product_ids = $blockArray['product_ids_' . $i];
                /*$products_for_template=[];*/
                foreach ($product_ids as $id) {
                    $product = (array) new product($id, false, $id_lang);
                    $product_details = $this->getProductById($id_lang, (int) $id);
					if(empty($product_details)){
						continue;
					}
                   $result[$i]['products'][]=$this->getProductTemplate($product_details);
                    
                }
            }
            itj_Home_Product_Block::$cache_products = $result;
        }
        return itj_Home_Product_Block::$cache_products;
    
    }

    public static function getProductById($id_lang, $product_id, $page_number = 0, $nb_products = 10, $count = false, $order_by = null, $order_way = null, Context $context = null) {

        if (!$context) {
            $context = Context::getContext();
        }

        $front = true;
        if (!in_array($context->controller->controller_type, array('front', 'modulefront'))) {
            $front = false;
        }

        if ($page_number < 0) {
            $page_number = 0;
        }
        if ($nb_products < 1) {
            $nb_products = 10;
        }
        if (empty($order_by) || $order_by == 'position') {
            $order_by = 'date_add';
        }
        if (empty($order_way)) {
            $order_way = 'DESC';
        }
        if ($order_by == 'id_product' || $order_by == 'price' || $order_by == 'date_add' || $order_by == 'date_upd') {
            $order_by_prefix = 'product_shop';
        } elseif ($order_by == 'name') {
            $order_by_prefix = 'pl';
        }
        if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)) {
            die(Tools::displayError());
        }

        $sql = new DbQuery();
        $sql->select(
                'p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, pl.`description`, pl.`description_short`, pl.`link_rewrite`, pl.`meta_description`,
        pl.`meta_keywords`, pl.`meta_title`, pl.`name`, pl.`available_now`, pl.`available_later`, image_shop.`id_image` id_image, il.`legend`, m.`name` AS manufacturer_name,
        product_shop.`date_add` > "' . date('Y-m-d', strtotime('-' . (Configuration::get('PS_NB_DAYS_NEW_PRODUCT') ? (int) Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20) . ' DAY')) . '" as new'
        );

        $sql->from('product', 'p');
        $sql->join(Shop::addSqlAssociation('product', 'p'));
        $sql->leftJoin('product_lang', 'pl', '
        p.`id_product` = pl.`id_product`
        AND pl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('pl')
        );
        $sql->leftJoin('image_shop', 'image_shop', 'image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop=' . (int) $context->shop->id);
        $sql->leftJoin('image_lang', 'il', 'image_shop.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int) $id_lang);
        $sql->leftJoin('manufacturer', 'm', 'm.`id_manufacturer` = p.`id_manufacturer`');

        $sql->where('product_shop.`active` = 1');
        $sql->where('p.`id_product`=' . (int) $product_id . ' ');

        if (Group::isFeatureActive()) {
            $groups = FrontController::getCurrentCustomerGroups();
            $sql->where('EXISTS(SELECT 1 FROM `' . _DB_PREFIX_ . 'category_product` cp
            JOIN `' . _DB_PREFIX_ . 'category_group` cg ON (cp.id_category = cg.id_category AND cg.`id_group` ' . (count($groups) ? 'IN (' . implode(',', $groups) . ')' : '= 1') . ')
            WHERE cp.`id_product` = p.`id_product`)');
        }

        $sql->orderBy((isset($order_by_prefix) ? pSQL($order_by_prefix) . '.' : '') . '`' . pSQL($order_by) . '` ' . pSQL($order_way));
        $sql->limit($nb_products, $page_number * $nb_products);

        if (Combination::isFeatureActive()) {
            $sql->select('product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity, IFNULL(product_attribute_shop.id_product_attribute,0) id_product_attribute');
            $sql->leftJoin('product_attribute_shop', 'product_attribute_shop', 'p.`id_product` = product_attribute_shop.`id_product` AND product_attribute_shop.`default_on` = 1 AND product_attribute_shop.id_shop=' . (int) $context->shop->id);
        }
        $sql->join(Product::sqlStock('p', 0));

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        // var_dump($result);
        // die();

        if (!$result) {
            return false;
        }

        if ($order_by == 'price') {
            Tools::orderbyPrice($result, $order_way);
        }

        $products_ids = array();
        foreach ($result as $row) {
            $products_ids[] = $row['id_product'];
        }
        // Thus you can avoid one query per product, because there will be only one query for all the products of the cart
        
       Product::cacheFrontFeatures($products_ids, $id_lang);
       return Product::getProductsProperties((int) $id_lang, $result);
    }
    
    public function getProductTemplate($products)
    {
         $assembler = new ProductAssembler($this->context);

        $presenterFactory = new ProductPresenterFactory($this->context);
        $presentationSettings = $presenterFactory->getPresentationSettings();
        $presenter = new ProductListingPresenter(
            new ImageRetriever(
                $this->context->link
            ),
            $this->context->link,
            new PriceFormatter(),
            new ProductColorsRetriever(),
            $this->context->getTranslator()
        );

    
      
            foreach ($products as $rawProduct) {
              
            $products_for_template= $presenter->present(
                $presentationSettings,
                $assembler->assembleProduct($rawProduct),
                $this->context->language
            );
        }
        return $products_for_template;
    }

}
