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
            $this->getDbContent();
            $output = '';
            $changes = '';
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
                $slidername = (string) Tools::getValue('slider_name');
                $link = (string) Tools::getValue('link');
                $position = (int) Tools::getValue('position');
                $status = (int) Tools::getValue('status');
                $image = (string) Tools::getValue('image');
                $uploadFile=$this->fileUpload($image);
                $insertData = array(
                    'name_slide' => $slidername,
                    'link' => $link,
                    'position' => $position,
                    'active' => $status,
                    'image' => $uploadFile,
                );
                $process = Db::getInstance()->insert('sp_banner', $insertData,false,true,Db::INSERT,false);
                if($process){
                    $changes = $this->displayConfirmation($this->l('Your settings have been saved'));     
                }
                else{
                    $output = $this->displayError($this->l('There was a problem'));
                }
            }
            return $output . $changes . $this->displayForm() . $this->displayInsertForm();
        }

        public function getDbContent(){
            $db = \Db::getInstance();
            $request="SELECT * FROM sp_banner";
            $result=$db->executeS($request);
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

        /**
         * @see Module::fileUpload()
         * returns the uploaded file name
         */

        public function fileUpload($uploadFile){
            $fileName=$_FILES['image']['name'];
            $temp_file = $_FILES['image']['tmp_name'];
            $image_path = dirname(__DIR__)."\sp_banner\images\\".$_FILES['image']['name'];
            if (move_uploaded_file($temp_file, $image_path)) {
                $output = $this->displayConfirmation($this->l(' File uploaded successfully'));
                return $fileName;
            } else {
                $output = $this->displayError($this->l('Error in uploading file'));
            }
        }

        public function displayInsertForm(){
            $form=[
                'form' =>[
                    'legend' => [
                        'title' => $this->l('Settings'),
                    ],
                    'input' =>array(   
                        array(   
                            'type' => 'text',
                            'name' => 'slider_name',    
                            'required' => true,
                            'label' =>'Slider name'    
                        ),    
                        array(    
                            'type'=>'text',    
                            'name' => 'link',    
                            'required' => true,    
                            'label' =>'link',   
                        ),
                        array(    
                            'type'=>'text',    
                            'name' => 'position',    
                            'required' => true,    
                            'label' =>'Position',    
                        ), 
                        array(
                            'type' => 'radio',
                            'label' => $this->l('Status'),
                            'name' => 'status',
                            'required'  => true,
                            'values' => array(
                                array(
                                    'id' => 'active',
                                    'value' => 1,
                                    'label' => $this->l('active')
                                ),
                                array(
                                    'id' => 'disable',
                                    'value' => 0,
                                    'label' => $this->l('disable')
                                ),
                            ),  
                        ),
                        array(    
                            'type'=>'file',    
                            'name' => 'image',    
                            'required' => true,    
                            'label' => $this->l('Image file'),
                        ),
                    ),
                    'submit' =>[ 
                        'name' => 'insertion',   
                        'title' => 'Insert',
                    ],
                ]
            ];
            $helperform = new HelperForm();
            $helperform->table = $this->table;    
            $helperform->name_controller = $this->name;    
            $helperform->submit_action = 'insertion' . $this->name;    
            return $helperform->generateForm([$form]);    
        }      
    
        public function hookDisplayHome(){
            $this->context->smarty->assign(
                [
                    'sp_banner' => $this->getDbContent()
                ]
            );
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