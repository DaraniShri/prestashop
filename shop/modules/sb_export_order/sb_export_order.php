<?php
require_once(_PS_MODULE_DIR_ . 'sb_export_order\classes\export_order.php'); 

class Sb_Export_Order extends Module
{
    public function __construct()
    {
        $this -> name = 'sb_export_order';
        $this -> tab = 'back_office_features';
        $this -> version = '1.0.0';
        $this -> author = 'Prestashop';
        $this -> bootstrap = true;

        parent::__construct();

        $this ->displayName = $this -> l('Export Orders');
        $this ->description = $this ->l ('Exports the Shop Orders');
        $this ->confirmUninstall = $this -> l('Are you sure you want to uninstall?');
        $this -> registerHook('actionValidateOrder');
    }

    /**
     * @see Module::install()
     */
    public function install()
    {
        return (
                parent::install()
                && $this -> createTableExportOrder()
            ); 
    }

    /**
     * @see Module::uninstall()
     */
    public function uninstall()
    {
        return parent::uninstall();
    }  

    public function getContent(){
    }

    public function createTableExportOrder(){
        $export_order = new Export_Order();
        $export_order -> create();        
    }

    public function hookActionValidateOrder($params)  {
        $checkIfTableExists = 'SELECT export_orderid from ' ._DB_PREFIX_.'export_order'; 
        if (Db::getInstance()->ExecuteS($checkIfTableExists)){
            $export_order = new Export_Order();
            $export_order->insert($params['order']);
        }
        else{
            $export_order = new Export_Order();
            $export_order -> create();
            $export_order->insert($params['order']);
        }        
    }  
}

?>