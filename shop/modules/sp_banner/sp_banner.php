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

        public function getContent()
        {
            $output = '';
            if (Tools::isSubmit('submit' . $this->name)) {
                $configValue = (string) Tools::getValue('block-title');

                if (empty($configValue)){
                    $output = $this->displayError($this->l('Invalid Configuration value'));
                } else {
                    Configuration::updateValue('update-value', $configValue);
                    $output = $this->displayConfirmation($this->l('Settings updated'));
                }
            }
            if (Tools::isSubmit('insertion' . $this->name)) {
                $modulename = (string) Tools::getValue('slider_name');
                $title = (string) Tools::getValue('slider_name');
            }
            return $output . $this->displayForm() . $this->displayInsertForm();
        }

        public function displayForm()
        {
            $form = [
                'form' => [
                    'legend' => [
                        'title' => $this->l('Settings'),
                    ],
                    'input' => [
                        [
                            'type' => 'text',
                            'label' => $this->l('Enter your title : '),
                            'name' => 'block-title',
                            'size' => 20,
                            'required' => true,
                        ],
                    ],
                    'submit' => [
                        'title' => $this->l('Save'),
                        'class' => 'btn btn-default pull-right',
                    ],
                ],
            ];

            $helper = new HelperForm();
            $helper->table = $this->table;
            $helper->name_controller = $this->name;
            $helper->submit_action = 'submit' . $this->name;
            $helper->fields_value['slidename'] = Configuration::get('update-value');
            return $helper->generateForm([$form]);
        }

        public function displayInsertForm(){
            $form=[
                'form' =>[
                    'input' =>array(   
                        array(   
                            'type' => 'text',
                            'name' => 'slider_name',    
                            'required' => true,    
                        ),    
                        array(    
                            'type'=>'text',    
                            'name' => 'title',    
                            'required' => true,    
                            'label' =>'title'    
                        ),  
                        array(    
                            'type'=>'radio',    
                            'name' => 'status',    
                            'required' => true,    
                            'label' =>'active'    
                        ), 
                        array(    
                            'type'=>'radio',    
                            'name' => 'status',    
                            'required' => true,    
                            'label' =>'disable'    
                        ),        
                    ),
                    'submit' =>[ 
                        'name' => 'insertion',   
                        'title' => 'insert',
                    ]    
                ]
            ];
            $helperform = new HelperForm();
            $helperform->table = $this->table;    
            $helperform->name_controller = $this->name;    
            $helperform->submit_action = 'insertion' . $this->name;    
            return $helperform->generateForm([$form]);    
        }      
    
        public function hookDisplayHome(){
            return $this->display(__FILE__, 'sp_banner.tpl');
        }

        public function hookDisplayHeader(){
            $this->context->controller->registerStylesheet('modules-homeslider', 'modules/' . $this->name . '/css/slick.css', ['media' => 'all', 'priority' => 150]);
            $this->context->controller->registerJavascript('modules-slick-js', 'modules/' . $this->name . '/js/slick.min.js', ['position' => 'top', 'priority' => 150]);
            $this->context->controller->registerStylesheet('custom-styles', 'modules/' . $this->name . '/css/custom.css', ['position' => 'top', 'priority' => 150]);
            $this->context->controller->registerJavascript('modules-slider', 'modules/' . $this->name . '/js/custom.js', ['position' => 'top', 'priority' => 150]);
        }
    }
?>