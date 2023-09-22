<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class Itj_Cross_Selling extends Module {
    public function __construct() {
        $this->name = 'itj_cross_selling';
        $this->version = '0.0.1';
        $this->author = 'IT Jonction Lab';
        $this->need_instance = 0;
        $this->bootstrap = true;
        $this->ps_versions_compliancy = ['min' => '1.7.1.0','max' => _PS_VERSION_,];
        parent::__construct();

        $this->displayName = $this->l('Cross-selling');
        $this->description = $this->l('Displays cross selling products for product page.');
        // $this ->registerHook('displayFooterProductAfter');
    }

    /**
     * Summary of install
     * @return bool
     */
    public function install()
    {
        return (
                parent::install()
                && $this -> registerHook('displayFooterProduct')
                && $this -> registerHook('displayHeader')
                && $this -> registerHook('displayCartModalFooter')
            ); 
    }

    /**
     * @see Module::uninstall()
     */
    public function uninstall()
    {
        return parent::uninstall();
    } 
    
    public function hookDisplayFooterProductAfter(){
        die("scisjdnvjinv");
    }

    public function getContent(){

    }

    
    public function hookDisplayFooterProduct($params){ 
        $products = $this -> getOrderProductsWithoutCurrentProduct($params['product']->id);
        $this -> context -> smarty -> assign(
            [
                'products' => $products,
            ]
        );           
        return $this -> display(__FILE__, 'view/templates/hook/itj_cross_selling.tpl'); 
    }

    public function hookDisplayCartModalFooter($params){ 
        $products = $this -> getOrderProductsWithoutCurrentProduct($params['product']->id);
        $this -> context -> smarty -> assign(
            [
                'products' => $products,
            ]
        );           
        return $this -> display(__FILE__, 'view/templates/hook/itj_cross_selling.tpl'); 
    }

    public function hookDisplayHeader(){
        $this->context->controller->addCSS(($this->_path) . 'css/slick.css', 'all');
        $this->context->controller->addJS(($this->_path).'js/slick.min.js'); 
        $this->context->controller->addJS(($this->_path).'js/itj_cross_selling.js');            
    }

    public function getOrderProductsWithoutCurrentProduct($id){
        $product_query = "SELECT DISTINCT product_id, unit_price_tax_incl
                          FROM ". _DB_PREFIX_ ."order_detail
                          WHERE product_id !=". $id ." AND id_order IN (
                                            SELECT id_order 
                                            FROM ". _DB_PREFIX_ ."order_detail 
                                            WHERE product_id = $id
                                        )";
        $results = Db::getInstance() -> executeS($product_query);
        $lang_id = (int) Configuration::get('PS_LANG_DEFAULT');
        $link = new Link();
        $productDetails=[];
        foreach($results as $result){
            $product_id = $result['product_id'];
            $product = new Product($product_id, false, $lang_id);
            $productImages = $product->getImages((int) $lang_id);
            if ($productImages && count($productImages) > 0) {
                $link = new Link;
                foreach ($productImages as $key => $productImage) {
                    $id_image = $productImage['id_image'];
                    $imagePath = "http://" . $link->getImageLink($product->link_rewrite[Context::getContext()->language->id], $id_image, 'home_default');
                }
            }
            $productDetails[] = [
                "name" => $product -> name,
                "price" => $result['unit_price_tax_incl'],
                "image" =>$imagePath,
                "description" => $product -> description_short,
                "url" => $link->getProductLink($product),
            ];
        }
        return $productDetails;
    }
}
?>