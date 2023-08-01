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
            $rowId=$_GET['slide_id'];
            $deleteId=$_GET['slides_id'];
            $warningMessage = '';
            if (Tools::isSubmit('submit' . $this->name)) {
                $configValue = (string) Tools::getValue('block-title');
                if (empty($configValue)){
                    $warningMessage.= $this->displayError($this->l('Invalid Configuration value'));
                } else {
                    Configuration::updateValue('update_value', $configValue);
                    $warningMessage.= $this->displayConfirmation($this->l('Settings updated'));
                }
            }
            if (Tools::isSubmit('insertion' . $this->name)) {
                $slidername = (string) Tools::getValue('slider_name');
                if (empty($slidername)){
                    $warningMessage.= $this->displayError($this->l('Enter slider name'));
                }
                $link = (string) Tools::getValue('link');
                if (empty($link)){
                    $warningMessage.= $this->displayError($this->l('Enter the link'));
                }
                $position = (int) Tools::getValue('position');
                if (empty($position)){
                    $warningMessage.= $this->displayError($this->l('Enter position'));
                }
                $status = (int) Tools::getValue('status');
                if (empty($status)){
                    $warningMessage.= $this->displayError($this->l('Enter the status'));
                }
                $image = (string) Tools::getValue('image');
                if (empty($image)){
                    $warningMessage.= $this->displayError($this->l('Attach image file'));
                }
                else{                 
                    $fileName=$_FILES['image']['name'];
                    $temp_file = $_FILES['image']['tmp_name'];
                    $uploadFile=$this->fileUpload($fileName, $temp_file);
                }
                $insertData = array(
                    'name_slide' => $slidername,
                    'link' => $link,
                    'position' => $position,
                    'active' => $status,
                    'image' => $uploadFile,
                );
                $process = Db::getInstance()->insert('sp_banner', $insertData,false,true,Db::INSERT,false);
                if($process){
                    $changes.= $this->displayConfirmation($this->l('Your settings have been saved'));     
                }
                else{
                    $warningMessage.= $this->displayError($this->l('There was a problem'));
                }
            }
            if($rowId){
                $warningMessage.= $this->updateRecord($rowId);
            }
            if($deleteId){
                $this->deleteRecord($deleteId);
            }
            if (Tools::isSubmit('updation' . $this->name)) {
                $id = (int) Tools::getValue('id');
                if (empty($id)){
                    $warningMessage.= $this->displayError($this->l('Enter the ID'));
                }
                $slidername = (string) Tools::getValue('slider_name');
                if (empty($slidername)){
                    $warningMessage.= $this->displayError($this->l('Enter Slider name'));
                }
                $link = (string) Tools::getValue('link');
                if (empty($link)){
                    $warningMessage.= $this->displayError($this->l('Enter link'));
                }
                $position = (int) Tools::getValue('position');
                if (empty($position)){
                    $warningMessage.= $this->displayError($this->l('Enter position'));
                }
                $status = (int) Tools::getValue('status');
                if (empty($status)){
                    $warningMessage.= $this->displayError($this->l('Enter status'));
                }
                $image = (string) Tools::getValue('images');
                if (empty($image)){
                    $warningMessage.= $this->displayError($this->l('Enter status'));
                }
                else{
                    $fileName=$_FILES['images']['name'];
                    $temp_file = $_FILES['images']['tmp_name'];
                    $uploadFile=$this->fileUpload($fileName,$temp_file);
                }               
                $updateData = array(
                    'name_slide' => $slidername,
                    'link' => $link,
                    'position' => $position,
                    'active' => $status,
                    'image' => $uploadFile,
                );
                $action = Db::getInstance()->update('sp_banner', $updateData,"id_slide=$id",0,false,true,false);
                if(empty($action)){
                    $warningMessage.= $this->displayError($this->l('No update query'));
                }
                else{
                    $changes.= $this->displayConfirmation($this->l('Your settings have been saved'));     
                }
                
            }
            return $warningMessage . $changes . $this->displayForm() . $this->displayInsertForm() . $this->viewDb();                       
        }

        public function getDbContent(){
            $db = \Db::getInstance();
            $request="SELECT * FROM sp_banner  WHERE active='1';";
            $result=$db->executeS($request);
            return $result;
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
            $helper->fields_value['block-title'] = Configuration::get('update_value');
            return $helper->generateForm([$form]);
        }

        /**
         * @see Module::fileUpload()
         * returns the uploaded file name
         */

        public function fileUpload($fileName,$temp_file){

            $image_path = dirname(__DIR__) . "\sp_banner\images\\" . $fileName;
            if (move_uploaded_file($temp_file, $image_path)) {
                $warningMessage.= $this->displayConfirmation($this->l(' File uploaded successfully'));
                return $fileName;
            } else {
                $warningMessage.= $this->displayError($this->l('Error in uploading file'));
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
                            'label' =>'Slider name',
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
                    'sp_banner' => $this->getDbContent(),
                    'sp_title' =>Configuration::get("update_value")
                ]
            );
            return $this->display(__FILE__, 'sp_banner.tpl');
        }

        public function hookDisplayHeader(){
            $this->context->controller->registerStylesheet('slider-custom-styles', 'modules/' . $this->name . '/css/slick.css', ['media' => 'all', 'priority' => 150]);
            $this->context->controller->registerJavascript('modules-slick-js-banner', 'modules/' . $this->name . '/js/slick.min.js', ['position' => 'top', 'priority' => 150]);
            $this->context->controller->registerStylesheet('custom-styles-banner', 'modules/' . $this->name . '/css/custom.css', ['position' => 'top', 'priority' => 150]);
            $this->context->controller->registerJavascript('modules-slider-banner', 'modules/' . $this->name . '/js/custom.js', ['position' => 'top', 'priority' => 150]);
        }

        public function viewDb(){
            $this->context->smarty->assign(
                [
                    'sp_table' => $this->getDbContent(),
                    'link' => $this->context->link
                ]
            );
            return $this->display(__FILE__, 'tableContent.tpl');
        }

        public function updateRecord($slide_id){
            $conn = \Db::getInstance();
            $selectQuery="SELECT * FROM sp_banner WHERE id_slide=$slide_id;";
            $result=$conn->getRow($selectQuery);
            $form=[
                'form' =>[
                    'legend' => [
                        'title' => $this->l('Settings'),
                    ],
                    'input' =>array( 
                        array(   
                            'type' => 'hidden',
                            'name' => 'id', 
                            'value' => $result[0]['id_slide'], 
                        ),   
                        array(   
                            'type' => 'text',
                            'name' => 'slider_name',    
                            'value' => $result[0]['name_slude'], 
                            'label' =>'Slider name',
                        ),    
                        array(    
                            'type'=>'text',    
                            'name' => 'link',    
                            'label' =>'link', 
                            'value' => $result[0]['link'],   
                        ),
                        array(    
                            'type'=>'text',    
                            'name' => 'position',    
                            'label' =>'Position',  
                            'value' => $result[0]['position'], 
  
                        ), 
                        array(
                            'type' => 'radio',
                            'label' => $this->l('Status'),
                            'name' => 'status',
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
                            'name' => 'images',    
                            'label' => $this->l('Image file'),
                            'value' => $result[0]['image'],   

                        ),
                    ),
                    'submit' =>[ 
                        'name' => 'updation',   
                        'title' => 'Update',
                    ],
                ]
            ];
            $helperupdateform = new HelperForm();
            $helperupdateform->table = $this->table;    
            $helperupdateform->name_controller = $this->name;    
            $helperupdateform->submit_action = 'updation' . $this->name;    
            $helperupdateform->fields_value['id'] =$result['id_slide'];
            $helperupdateform->fields_value['slider_name'] = $result['name_slide'];
            $helperupdateform->fields_value['position'] = $result['position'] ;
            $helperupdateform->fields_value['status'] = $result['active'] ;     
            $helperupdateform->fields_value['link'] = $result['link'] ;    
            return $helperupdateform->generateForm([$form]);
            
        }

        public function deleteRecord($slide_id){
            $conn = \Db::getInstance();
            $selectQuery="SELECT * FROM sp_banner WHERE id_slide=$slide_id;";
            $result=$conn->executeS($selectQuery);
            $deleteQuery=$conn->delete('sp_banner',"id_slide=$slide_id",0,true,false);
        }
    }
?>