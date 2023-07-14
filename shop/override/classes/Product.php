<?php
    class Product extends ProductCore{
        /**
         * @var array Contains object definition
         *
         * @see ObjectModel::$definition
         */
        public $p_type;
        public function __construct($id_product = null, $full = false, $id_lang = null, $id_shop = null, Context $context = null){
            $id_product=4;
            self::$definition['fields']['p_type'] = array('type' => self::TYPE_STRING);
            self::$definition['fields']['custom_msg'] = array('type' => self::TYPE_STRING);
            parent::__construct($id_product, $full, $id_lang, $id_shop);
            /*
            $product = new Product();
            $product->add();
            */
            $this->p_type = 'woods';
            $this->custom_msg ='In stock';
            $this->update();            
        }
    }
?>