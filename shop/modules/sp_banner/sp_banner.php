<?php
    if (!defined('_PS_VERSION_')) {
        exit;
    }

    class Sp_Banner extends Module{
        public function __construct()
        {
            $this->name = 'sp_banner';
            $this->tab = 'front_office_features';
            $this->version = '1.0.0';
            $this->author = 'abcd';
            $this->bootstrap = true;

            parent::__construct();

            $this->displayName = $this->l('Custom Module');
            $this->description = $this->l('Creating a banner in the home page.');
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
                ); 
        }

        /**
         * @see Module::uninstall()
         */
        public function uninstall()
        {
            return parent::uninstall();
        }

        public function hookDisplayHome(){
            return $this->display(__FILE__, 'sp_banner.tpl');
        }

        public function hookDisplayHeader(){
            $this->context->controller->registerStylesheet('modules-homeslider', 'modules/' . $this->name . '/css/slick.css', ['media' => 'all', 'priority' => 150]);
            $this->context->controller->registerJavascript('modules-slickslides', 'modules/' . $this->name . '/js/slick.min.js', ['position' => 'top', 'priority' => 150]);
            $this->context->controller->registerStylesheet('custom-styles', 'modules/' . $this->name . '/css/custom.css', ['position' => 'top', 'priority' => 150]);
            $this->context->controller->registerJavascript('modules-slider', 'modules/' . $this->name . '/js/custom.js', ['position' => 'top', 'priority' => 150]);
        }
    }
?>