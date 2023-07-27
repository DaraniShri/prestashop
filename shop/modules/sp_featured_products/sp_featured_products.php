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
            $this->context->smarty->assign(
                [
                    'featured_product' =>Configuration::get("update_product"),
                ]
            );
            return $this->display(__FILE__, 'sp_featured_products.tpl');
        }

        public function getContent(){
            $this->context->controller->addCSS(($this->_path) . 'css/select2.min.css', 'all');
            $this->context->controller->addJS(($this->_path) . 'js/select2.min.js', 'all');
            $this->context->controller->addJS(($this->_path) . 'js/html5sortable.min.js', 'all');
            $this->context->controller->addJS(($this->_path) . 'js/select2.sortable.min.js', 'all');
            $this->context->controller->addJS(($this->_path) . 'js/custom_select.js', 'all');
            if(Tools::getValue('submit')){
                $productId=$_POST['products'];
                $productArray=json_encode($productId);
                Configuration::updateValue('update_product',$productArray);
                $output=$this->displayConfirmation($this->l('Settings updated'));
                $lang_id = (int) Configuration::get('PS_LANG_DEFAULT');
                $productIdList=json_decode($productArray);
                var_dump($productIdList);
                foreach($productIdList as $productIds){
                    $product=new Product($productIds,false,$lang_id);
                    var_dump($product->id);
                    var_dump($product->name);
                    var_dump($product->reference);
                    var_dump($product->description);
                    var_dump($product->id_default_image);
                    var_dump($product);
                    //$template=$this->getProductData($product); 
                    $productImages = $product->getImages((int) $id_lang);
                    if ($productImages && count($productImages) > 0) {
                    $link = new Link;
                    foreach ($productImages AS $key => $val) {
                        $id_image = $val['id_image'];
                        $imagePath = $link->getImageLink($product->link_rewrite[Context::getContext()->language->id], $id_image, 'home_default');
                        echo $imagePath;
                    }                  
                }
                die();
            }
            return $this->selectProduct();
        }

        /*public function getProductData(){
            $assembler = new ProductAssembler($this->context);

            $presenterFactory = new ProductPresenterFactory($this->context);
            $presentationSettings = $presenterFactory->getPresentationSettings();
            $presenter = $presenterFactory->getPresenter();

            return $presenter->present(
                $presentationSettings,
                $assembler->assembleProduct($product),
                $this->context->language
            );*/
        }

        public function selectProduct(){
            $this->context->smarty->assign(
                [
                    'dbData' => $this->getDbContent(),
                    'admin_url' => $this->context->link->getAdminLink('AdminModules', false) . '&token=' . Tools::getAdminTokenLite('AdminModules') . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name,
                ]
            );           
            return $this->display(__FILE__, 'selectProduct.tpl');    
        }

        public function getDbContent(){
            $db = \Db::getInstance();
            $request="SELECT ps_product_lang.id_product,ps_product_lang.name FROM ps_product_lang LEFT JOIN ps_product ON ps_product.id_product=ps_product_lang.id_product WHERE id_lang='1' and name like '%%demo';";
            $result=$db->executeS($request);
            return $result;
        }               
    }
?>
