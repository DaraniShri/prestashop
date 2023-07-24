<?php
    if (!defined('_PS_VERSION_')) {
        exit;
    }

    class Sp_Featured_Products extends Module{
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
            $this->registerHook('displayBackOfficeHeader');
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
        
        public function HookDisplayHome(){
            return $this->display(__FILE__, 'sp_featured_products.tpl');
        }

        public function getContent(){

            $this->context->controller->addCSS(($this->_path) . 'css/select2.min.css', 'all');
            $this->context->controller->addJS(($this->_path) . 'js/select2.min.js', 'all');
            $this->context->controller->addJS(($this->_path) . 'js/custom_select.js', 'all');
   
            return $this->selectProduct();
        }

        public function getDbContent(){
            $db = \Db::getInstance();
            $request="SELECT ps_product_lang.id_product,ps_product_lang.name FROM ps_product_lang LEFT JOIN ps_product ON ps_product.id_product=ps_product_lang.id_product WHERE id_lang='1' and name like '%%demo';";
            $result=$db->executeS($request);
            return $result;
        }

        public function selectProduct(){
            $this->context->smarty->assign(
                [
                    'dbData' => $this->getDbContent()
                ]
            );           
            return $this->display(__FILE__, 'selectProduct.tpl');
                     
        }

               
    }
?>
