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
                            'label' => $this->getTranslator()->trans('Newtab Enabled', array(), 'Admin.Global'),
                            'name' => 'active_slide_feature',
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
        
        public function renderList()
        {
            $slides = $this->getSlides();
            foreach ($slides as $key => $slide) {            
                $slides[$key]['status'] = $this->displayStatus($slide['id_slide'], $slide['active']);
                $associated_shop_ids = Ps_HomeSlide::getAssociatedIdsShop((int)$slide['id_slide']);
                if ($associated_shop_ids && count($associated_shop_ids) > 1) {
                    $slides[$key]['is_shared'] = true;
                } else {
                    $slides[$key]['is_shared'] = false;
                }
                $slides[$key]['new_tab']=Configuration::get('open_new_tab_'.$slide['id_slide']);
            }

            $this->context->smarty->assign(
                array(
                    'link' => $this->context->link,
                    'slides' => $slides,
                    'image_baseurl' => $this->_path.'images/',
                    )
            );

            return $this->display(__FILE__, 'list.tpl');
        }

        public function _postProcess(){
            if (Tools::isSubmit('submitSlide')) {
                /* Sets ID if needed */
                $sliderId = (int) Tools::getValue('id_slide');
                $sliderTabValue = (int) Tools::getValue('active_slide_feature');
                Configuration::updateValue('open_new_tab_'.$sliderId, $sliderTabValue);
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
    }
?>