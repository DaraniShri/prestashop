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
        }

        /**
         * @see Module::install()
         */
        public function install()
        {
            return (
                    parent::install()
                    && $this->registerHook('displayHome')
                    && $this->registerHook('displayHeader') 
                    && $this->registerHook('displayNewAdmin') 
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

        public function hookDisplayHeader(){
            
        }

        public function hookDisplayNewAdmin(){
            $this->context->controller->registerStylesheet('select2-styles', 'modules/' . $this->name . '/css/select2.css', ['media' => 'all', 'priority' => 150]);
            $this->context->controller->registerJavascript('select2-script', 'modules/' . $this->name . '/js/select2.min.js', ['position' => 'top', 'priority' => 150]);
            $this->context->controller->registerJavascript('select2-custom-script', 'modules/' . $this->name . '/js/custom_select.js', ['position' => 'top', 'priority' => 150]);
        }

        public function getContent(){
            return $this->selectProduct();
        }

        public function getDbContent(){
            $db = \Db::getInstance();
            $request="SELECT ps_product_lang.id_product,ps_product_lang.name FROM ps_product_lang LEFT JOIN ps_product ON ps_product.id_product=ps_product_lang.id_product WHERE id_lang='1';";
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
