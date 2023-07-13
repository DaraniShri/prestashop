<?php
    class FrontController extends FrontControllerCore{
        /**
        * Sets controller CSS and JS files.
        *
        * @return bool
        */
        public function setMedia()
        {
            parent::setMedia(); 
            $this->registerStylesheet('theme-custom', '/assets/css/customchild.css', ['media' => 'all', 'priority' => 1000]);
            return true;
        }
    }
?>