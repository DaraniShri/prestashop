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
        $this -> insertTable();

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

    public function createTableExportOrder()
    {
        $db = \Db::getInstance();
        $sql = "CREATE TABLE IF NOT EXISTS " . _DB_PREFIX_ . "export_order(
                export_orderid int(50) AUTO_INCREMENT,
                order_number int(50) NOT NULL,
                order_date date NOT NULL,
                deliver_date date,
                customer_code varchar(50),
                customer_businessname varchar(255),
                customer_name varchar(255),
                customer_address varchar(255),
                customer_place varchar(50),
                customer_postalcode int(50),
                customer_zone varchar(50),
                customer_country varchar(50),
                customer_phone int(20),
                mobile_customers int(20),
                customer_fax int(20),
                customer_email varchar(255),
                delivery_code varchar(50),
                delivery_businessname varchar(255),
                delivery_name varchar(255),
                delivery_address varchar(255),
                delivery_place varchar(50),
                delivery_postalcode varchar(50),
                delivery_zone varchar(50),
                delivery_country varchar(50),
                delivery_phone int(20),
                mobile_delivery int(20),
                fax_delivery int(20),
                email_delivery varchar(255),
                carrier_code varchar(50),
                carrier_businessname varchar(255),
                carrier_name varchar(255),
                carrier_address varchar(255),
                carrier_place varchar(50),
                carrier_postalcode varchar(50),
                carrier_zone varchar(50),
                carrier_country varchar(50),
                carrier_phone int(20),
                mobile_carrier int(20),
                fax_carrier int(20),
                email_carrier varchar(255),
                order_linenumber int(50) NOT NULL,
                reference_order_linenumber varchar(50) NOT NULL,
                line_type varchar(1) NOT NULL,
                item_code varchar(50) NOT NULL,
                item_description varchar(200),
                customer_itemcode varchar(50),
                customer_itemdescription varchar(200),
                customer_documentreference varchar(50),
                lot int(50),
                quantity_requested int(10) NOT NULL,
                annotations varchar(255),
                response varchar(255),
                PRIMARY KEY (export_orderid)
            )";
        $result = $db -> execute($sql);
        return $result;
    }

    public function getContent(){
    }

    public function insertTable()
    {
        $export_order = new Export_Order();
        $export_order->order_number=20;
        $export_order->order_date="2003-11-05";
        $export_order->order_linenumber=1;
        $export_order->reference_order_linenumber='1';
        $export_order->line_type='B';
        $export_order->item_code='DIODE';
        $export_order->quantity_requested=12;
        $export_order->add();
    }
}

?>