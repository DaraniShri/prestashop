<?php
    class Ps_ImageSliderOverride extends Ps_ImageSlider {

        public function renderAddForm()
        {
            $fields_form = array(
                'form' => array(
                    'legend' => array(
                        'title' => $this->getTranslator()->trans('Slide information', array(), 'Modules.Imageslider.Admin'),
                        'icon' => 'icon-cogs'
                    ),
                    'input' => array(
                        array(
                            'type' => 'file_lang',
                            'label' => $this->getTranslator()->trans('Image', array(), 'Admin.Global'),
                            'name' => 'image',
                            'required' => true,
                            'lang' => true,
                            'desc' => $this->getTranslator()->trans('Maximum image size: %s.', array(ini_get('upload_max_filesize')), 'Admin.Global')
                        ),
                        array(
                            'type' => 'text',
                            'label' => $this->getTranslator()->trans('Title', array(), 'Admin.Global'),
                            'name' => 'title',
                            'lang' => true,
                        ),
                        array(
                            'type' => 'text',
                            'label' => $this->getTranslator()->trans('Target URL', array(), 'Modules.Imageslider.Admin'),
                            'name' => 'url',
                            'required' => true,
                            'lang' => true,
                        ),
                        array(
                            'type' => 'text',
                            'label' => $this->getTranslator()->trans('Caption', array(), 'Modules.Imageslider.Admin'),
                            'name' => 'legend',
                            'lang' => true,
                        ),
                        array(
                            'type' => 'textarea',
                            'label' => $this->getTranslator()->trans('Description', array(), 'Admin.Global'),
                            'name' => 'description',
                            'autoload_rte' => true,
                            'lang' => true,
                        ),
                        array(
                            'type' => 'switch',
                            'label' => $this->getTranslator()->trans('Enabled', array(), 'Admin.Global'),
                            'name' => 'active_slide',
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => 'active_on',
                                    'value' => 1,
                                    'label' => $this->getTranslator()->trans('Yes', array(), 'Admin.Global')
                                ),
                                array(
                                    'id' => 'active_off',
                                    'value' => 0,
                                    'label' => $this->getTranslator()->trans('No', array(), 'Admin.Global')
                                )
                            ),
                        ),
                        array(
                            'type' => 'switch',
                            'label' => $this->getTranslator()->trans('Enable New Tab', array(), 'Admin.Global'),
                            'name' => 'active_slide_feature',
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => 'active_on',
                                    'value' => 1,
                                    'checked' => 'true',
                                    'label' => $this->getTranslator()->trans('Yes', array(), 'Admin.Global')
                                ),
                                array(
                                    'id' => 'active_off',
                                    'value' => 0,
                                    'label' => $this->getTranslator()->trans('No', array(), 'Admin.Global')
                                )
                            ),
                        ),
                    ),
                    'submit' => array(
                        'title' => $this->getTranslator()->trans('Save', array(), 'Admin.Actions'),
                    )
                ),
            );

            if (Tools::isSubmit('id_slide') && $this->slideExists((int)Tools::getValue('id_slide'))) {
                $slide = new Ps_HomeSlide((int)Tools::getValue('id_slide'));
                $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_slide');
                $fields_form['form']['images'] = $slide->image;

                $has_picture = true;

                foreach (Language::getLanguages(false) as $lang) {
                    if (!isset($slide->image[$lang['id_lang']])) {
                        $has_picture &= false;
                    }
                }

                if ($has_picture) {
                    $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'has_picture');
                }
            }

            $helper = new HelperForm();
            $helper->show_toolbar = false;
            $helper->table = $this->table;
            $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
            $helper->default_form_language = $lang->id;
            $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
            $this->fields_form = array();
            $helper->module = $this;
            $helper->identifier = $this->identifier;
            $helper->submit_action = 'submitSlide';
            $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
            $helper->token = Tools::getAdminTokenLite('AdminModules');
            $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
            $helper->tpl_vars = array(
                'base_url' => $this->context->shop->getBaseURL(),
                'language' => array(
                    'id_lang' => $language->id,
                    'iso_code' => $language->iso_code
                ),
                'fields_value' => $this->getAddFieldsValues(),
                'languages' => $this->context->controller->getLanguages(),
                'id_language' => $this->context->language->id,
                'image_baseurl' => $this->_path.'images/'
            );

            $helper->override_folder = '/';

            $languages = Language::getLanguages(false);

            if (count($languages) > 1) {
                return $this->getMultiLanguageInfoMsg() . $helper->generateForm(array($fields_form));
            } else {
                return $helper->generateForm(array($fields_form));
            }
        } 

        public function getWidgetVariables($hookName = null, array $configuration = [])
        {
            $slides = $this->getSlides(true);
            if (is_array($slides)) {
                foreach ($slides as &$slide) {
                    $slide['sizes'] = @getimagesize((__DIR__ . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $slide['image']));
                    if (isset($slide['sizes'][3]) && $slide['sizes'][3]) {
                        $slide['size'] = $slide['sizes'][3];
                    }
                }
            }

            $config = $this->getConfigFieldsValues();
            $new_tab_slider=Configuration::get('new_tab_imageslider');
            $newtab_slide_id=explode(',',$new_tab_slider);

            return [
                'homeslider' => [
                    'speed' => $config['HOMESLIDER_SPEED'],
                    'pause' => $config['HOMESLIDER_PAUSE_ON_HOVER'] ? 'hover' : '',
                    'wrap' => $config['HOMESLIDER_WRAP'] ? 'true' : 'false',
                    'slides' => $slides,
                ],
                'newtabslideid' => $newtab_slide_id,
            ];
        }

        public function getAddFieldsValues()
        {
            $fields = array();

            if (Tools::isSubmit('id_slide') && $this->slideExists((int)Tools::getValue('id_slide'))) {
                $slide = new Ps_HomeSlide((int)Tools::getValue('id_slide'));
                $fields['id_slide'] = (int)Tools::getValue('id_slide', $slide->id);
            } else {
                $slide = new Ps_HomeSlide();
            }
            $ids=Tools::getValue('id_slide');
            $sliderId=Configuration::get('new_tab_imageslider');
            $sliderIdNewTab=explode(',',$sliderId);
            if(in_array($ids,$sliderIdNewTab)){
                $fields['active_slide_feature'] = 1;
            }
            else{
                $fields['active_slide_feature'] = 0;
            }
            $fields['active_slide'] = Tools::getValue('active_slide', $slide->active);
            
            $fields['has_picture'] = true;

            $languages = Language::getLanguages(false);

            foreach ($languages as $lang) {
                $fields['image'][$lang['id_lang']] = Tools::getValue('image_'.(int)$lang['id_lang']);
                $fields['title'][$lang['id_lang']] = Tools::getValue('title_'.(int)$lang['id_lang'], $slide->title[$lang['id_lang']]);
                $fields['url'][$lang['id_lang']] = Tools::getValue('url_'.(int)$lang['id_lang'], $slide->url[$lang['id_lang']]);
                $fields['legend'][$lang['id_lang']] = Tools::getValue('legend_'.(int)$lang['id_lang'], $slide->legend[$lang['id_lang']]);
                $fields['description'][$lang['id_lang']] = Tools::getValue('description_'.(int)$lang['id_lang'], $slide->description[$lang['id_lang']]);
            }
            return $fields;
        }

        public function _postProcess(){
            if (Tools::isSubmit('submitSlide')) {
                /* Sets ID if needed */
                if(Tools::getValue('active_slide_feature')==1){
                    $this->storeConfiguration(Tools::getValue('id_slide'));
                }
                if(Tools::getValue('active_slide_feature')==0){
                    $this->removeConfiguration(Tools::getValue('id_slide'));
                }
                if (Tools::getValue('id_slide')) {
                    $slide = new Ps_HomeSlide((int)Tools::getValue('id_slide'));
                    if (!Validate::isLoadedObject($slide)) {
                        $this->_html .= $this->displayError($this->getTranslator()->trans('Invalid slide ID', array(), 'Modules.Imageslider.Admin'));
                        return false;
                    }
                } else {
                    $slide = new Ps_HomeSlide();
                    /* Sets position */
                    $slide->position = (int)$this->getNextPosition();
                }
                /* Sets active */
                $slide->active = (int)Tools::getValue('active_slide');

                /* Sets each langue fields */
                $languages = Language::getLanguages(false);

                foreach ($languages as $language) {
                    $slide->title[$language['id_lang']] = Tools::getValue('title_'.$language['id_lang']);
                    $slide->url[$language['id_lang']] = Tools::getValue('url_'.$language['id_lang']);
                    $slide->legend[$language['id_lang']] = Tools::getValue('legend_'.$language['id_lang']);
                    $slide->description[$language['id_lang']] = Tools::getValue('description_'.$language['id_lang']);

                    /* Uploads image and sets slide */
                    $type = Tools::strtolower(Tools::substr(strrchr($_FILES['image_'.$language['id_lang']]['name'], '.'), 1));
                    $imagesize = @getimagesize($_FILES['image_'.$language['id_lang']]['tmp_name']);
                    if (isset($_FILES['image_'.$language['id_lang']]) &&
                        isset($_FILES['image_'.$language['id_lang']]['tmp_name']) &&
                        !empty($_FILES['image_'.$language['id_lang']]['tmp_name']) &&
                        !empty($imagesize) &&
                        in_array(
                            Tools::strtolower(Tools::substr(strrchr($imagesize['mime'], '/'), 1)), array(
                                'jpg',
                                'gif',
                                'jpeg',
                                'png'
                            )
                        ) &&
                        in_array($type, array('jpg', 'gif', 'jpeg', 'png'))
                    ) {
                        $temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
                        $salt = sha1(microtime());
                        if ($error = ImageManager::validateUpload($_FILES['image_'.$language['id_lang']])) {
                            $errors[] = $error;
                        } elseif (!$temp_name || !move_uploaded_file($_FILES['image_'.$language['id_lang']]['tmp_name'], $temp_name)) {
                            return false;
                        } elseif (!ImageManager::resize($temp_name, __DIR__.'/images/'.$salt.'_'.$_FILES['image_'.$language['id_lang']]['name'], null, null, $type)) {
                            $errors[] = $this->displayError($this->getTranslator()->trans('An error occurred during the image upload process.', array(), 'Admin.Notifications.Error'));
                        }
                        if (isset($temp_name)) {
                            @unlink($temp_name);
                        }
                        $slide->image[$language['id_lang']] = $salt.'_'.$_FILES['image_'.$language['id_lang']]['name'];
                    } elseif (Tools::getValue('image_old_'.$language['id_lang']) != '') {
                        $slide->image[$language['id_lang']] = Tools::getValue('image_old_' . $language['id_lang']);
                    }
                }

                /* Processes if no errors  */
                if (!$errors) {
                    /* Adds */
                    if (!Tools::getValue('id_slide')) {
                        if (!$slide->add()) {
                            $errors[] = $this->displayError($this->getTranslator()->trans('The slide could not be added.', array(), 'Modules.Imageslider.Admin'));
                        }
                    } elseif (!$slide->update()) {
                        $errors[] = $this->displayError($this->getTranslator()->trans('The slide could not be updated.', array(), 'Modules.Imageslider.Admin'));
                    }
                    $this->clearCache();
                }
            }
        }

        public function storeConfiguration($id){
            $slider = Configuration::get('new_tab_imageslider');
            $slider_array = explode(',',$slider);
            if(!in_array($id,$slider_array)){
                array_push($slider_array,$id);
            }
            $slider_id_string= implode(',',$slider_array);
            Configuration::updateValue('new_tab_imageslider',$slider_id_string);                                 
        }

        public function removeConfiguration($id){
            $slider = Configuration::get('new_tab_imageslider');
            $slider_array = explode(',',$slider);
            if(in_array($id,$slider_array)){
                $index=array_search($id,$slider_array);
                unset($slider_array[$index]);
                $slider_id_string= implode(',',$slider_array);
                Configuration::updateValue('new_tab_imageslider',$slider_id_string);                                 
            }
        }
    }
?>