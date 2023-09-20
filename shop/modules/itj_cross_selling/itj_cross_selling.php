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

        $this->registerHook('displayFooterProduct');
    }

    public function install()
    {
        return (
                parent::install()
            ); 
    }

    /**
     * @see Module::uninstall()
     */
    public function uninstall()
    {
        return parent::uninstall();
    }  

    public function hookDisplayFooterProduct(){ 
        $this -> context -> smarty -> assign(
            [
                'products' => $this->getOrderProducts(),
            ]
        );           
        return $this -> display(__FILE__, 'view/templates/hook/itj_cross_selling.tpl'); 
    }

    public function hookDisplayHeader(){
        $this->context->controller->addCSS(($this->_path) . 'css/slick.css', 'all');
        $this->context->controller->addJS(($this->_path).'js/slick.min.js'); 
        $this->context->controller->addJS(($this->_path).'js/itj_cross_selling.js');            
    }

    public function getOrderProducts(){
        $sql = 'SELECT DISTINCT od.product_id, o.id_order, od.product_name, od.product_quantity, od.product_price
                FROM '._DB_PREFIX_.'orders o
                LEFT JOIN '._DB_PREFIX_.'order_detail od 
                ON (od.id_order = o.id_order)';
        $results = Db::getInstance() -> executeS($sql);

        $lang_id = (int) Configuration::get('PS_LANG_DEFAULT');
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
            $product_name = $result['product_name'];
            $product_price = $result['product_price'];

            $productDetails[] = [
                "name" => $product_name,
                "price" => $product_price,
                "image" =>$imagePath,
            ];
        }
        return $productDetails;
    }

    public function getContent(){
        $hi = $this->getOrderProducts();
        var_dump($hi);
        die();
    }
}
?>